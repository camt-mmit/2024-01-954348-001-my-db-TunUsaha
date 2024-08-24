<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\View\View;

abstract class SearchableController extends Controller
{
    protected static array $ITEMS = [];

    abstract protected function getQuery(): Builder;
    abstract protected function getSearchType(): string;
    abstract protected function getItemsPerPage(): int;
    abstract protected function getListViewName(): string;

    protected function prepareSearch(array $search): array
    {
        $search['term'] = $search['term'] ?? null;
        $search['minPrice'] = isset($search['minPrice']) ? (float)$search['minPrice'] : null;
        $search['maxPrice'] = isset($search['maxPrice']) ? (float)$search['maxPrice'] : null;
        return $search;
    }

    protected function filterByTermForProducts(Builder $query, ?string $term): Builder
    {
        if (!empty($term)) {
            foreach (preg_split('/\s+/', trim($term)) as $word) {
                $query->where(function (Builder $innerQuery) use ($word): void {
                    $innerQuery
                        ->where('code', 'LIKE', '%' . $word . '%')
                        ->orWhere('name', 'LIKE', '%' . $word . '%');
                });
            }
        }
        return $query;
    }

    protected function filterByTermForShops(Builder $query, ?string $term): Builder
    {
        if (!empty($term)) {
            foreach (preg_split('/\s+/', trim($term)) as $word) {
                $query->where(function (Builder $innerQuery) use ($word): void {
                    $innerQuery
                        ->where('code', 'LIKE', '%' . $word . '%')
                        ->orWhere('name', 'LIKE', '%' . $word . '%')
                        ->orWhere('owner', 'LIKE', '%' . $word . '%');
                });
            }
        }
        return $query;
    }

    protected function filterByPrice(Builder $query, ?float $minPrice, ?float $maxPrice): Builder
    {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    protected function filter(Builder $query, array $search, string $type = 'products'): Builder
    {
        if ($type === 'products') {
            $query = $this->filterByTermForProducts($query, $search['term']);
        } else if ($type === 'shops') {
            $query = $this->filterByTermForShops($query, $search['term']);
        }
        $query = $this->filterByPrice($query, $search['minPrice'], $search['maxPrice']);
        return $query;
    }

    protected function search(array $search): Builder
    {
        $query = $this->getQuery();
        return $this->filter($query, $search, $this->getSearchType());
    }

    public function find(string $code): Model
    {
        return $this->getQuery()->where('code', $code)->firstOrFail();
    }

    public function list(Request $request): View
    {
        $search = $this->prepareSearch($request->query());
        $query = $this->search($search);
        $items = $query->paginate($this->getItemsPerPage())->appends($search);
        return view($this->getListViewName(), [
            'search' => $search,
            'items' => $items,
        ]);
    }

    protected function filterArrayByTerm(array $items, string $term): array
    {
        $results = [];
        foreach ($items as $item) {
            $nameMatch = stripos($item['name'], $term) !== false;
            $codeMatch = stripos($item['code'], $term) !== false;
            $ownerMatch = stripos($item['owner'], $term) !== false;
            if ($nameMatch || $codeMatch || $ownerMatch) {
                $results[] = $item;
            }
        }
        return $results;
    }

    protected function filterArrayByPrice(array $items, ?float $minPrice, ?float $maxPrice): array
    {
        $results = [];
        foreach ($items as $item) {
            if (($minPrice === null || $item['price'] >= $minPrice) &&
                ($maxPrice === null || $item['price'] <= $maxPrice)
            ) {
                $results[] = $item;
            }
        }
        return $results;
    }

    protected function searchArray(array $data): array
    {
        $term = $data['term'] ?? '';
        $minPrice = $data['minPrice'] ?? null;
        $maxPrice = $data['maxPrice'] ?? null;
        $items = static::$ITEMS;
        if ($term !== '') {
            $items = $this->filterArrayByTerm($items, $term);
        }
        $items = $this->filterArrayByPrice($items, $minPrice, $maxPrice);
        return $items;
    }
}
