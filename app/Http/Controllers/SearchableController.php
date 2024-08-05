<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class SearchableController extends Controller
{
    protected static array $ITEMS = [];

    abstract protected function getQuery(): Builder;

    protected function prepareSearch(array $search): array {
        $search['term'] = $search['term'] ?? null;
        $search['minPrice'] = isset($search['minPrice']) ? (float)$search['minPrice'] : null;
        $search['maxPrice'] = isset($search['maxPrice']) ? (float)$search['maxPrice'] : null;
        return $search;
    }

    protected function filterByTerm(Builder $query, ?string $term): Builder {
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

    protected function filterByPrice(Builder $query, ?float $minPrice, ?float $maxPrice): Builder {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    protected function filter(Builder $query, array $search): Builder {
        $query = $this->filterByTerm($query, $search['term']);
        $query = $this->filterByPrice($query, $search['minPrice'], $search['maxPrice']);
        return $query;
    }

    protected function search(array $search): Builder {
        $query = $this->getQuery();
        return $this->filter($query, $search);
    }

    // For easily searching by code.
    public function find(string $code): Model {
        return $this->getQuery()->where('code', $code)->firstOrFail();
    }

    public function list(Request $request, string $title = 'Products'): \Illuminate\View\View {
        $minPrice = $request->query('minPrice');
        $maxPrice = $request->query('maxPrice');
        $minPrice = is_numeric($minPrice) ? (float) $minPrice : null;
        $maxPrice = is_numeric($maxPrice) ? (float) $maxPrice : null;

        $search = $this->prepareSearch($request->query());
        $query = $this->search($search);

        return View::make('products.list', [
            'title' => "{$title} : List",
            'search' => $search,
            'products' => $query->paginate(5),
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ]);
    }


    protected function filterArrayByTerm(array $items, string $term): array {
        $results = [];

        foreach ($items as $item) {
            $nameMatch = stripos($item['name'], $term) !== false;
            $codeMatch = stripos($item['code'], $term) !== false;
            if ($nameMatch || $codeMatch) {
                $results[] = $item;
            }
        }
        return $results;
    }

    protected function filterArrayByPrice(array $items, ?float $minPrice, ?float $maxPrice): array {
        $results = [];

        foreach ($items as $item) {
            if (($minPrice === null || $item['price'] >= $minPrice) &&
                ($maxPrice === null || $item['price'] <= $maxPrice)) {
                $results[] = $item;
            }
        }
        return $results;
    }

    protected function searchArray(array $data): array {
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
