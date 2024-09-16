<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Product;


class ShopController extends SearchableController
{
    protected string $title = 'Shops';
    protected int $itemsPerPage = 4;

    protected function getQuery(): Builder
    {
        return Shop::orderBy('code');
    }

    protected function getSearchType(): string
    {
        return 'shops';
    }

    protected function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    protected function getListViewName(): string
    {
        return 'shops.list';
    }

    public function showProducts(Request $request, ProductController $productController, $shopCode)
    {
        $shop = Shop::where('code', $shopCode)->firstOrFail();
        $search = $productController->prepareSearch($request->query());
        $query = $productController->filter($shop->products(), $search)->withCount('shops');

        return view('shops.view-products', [
            'title' => "{$this->title} {$shop->name} : Products",
            'shop' => $shop,
            'search' => $search,
            'products' => $query->paginate(4),
        ]);
    }

    public function index(): View
    {
        $search = $this->prepareSearch(request()->all());
        $query = $this->search($search)->withCount('products');
        $shops = $query->paginate($this->getItemsPerPage())->appends($search);

        return $this->view($this->getListViewName(), [
            'shops' => $shops,
            'search' => $search
        ]);
    }

    public function show(string $shop): View
    {
        $shop = $this->find($shop)->loadCount('products');
        return $this->view('shops.view', [
            'shop' => $shop,
        ]);
    }

    public function showCreateForm(): View
    {
        return $this->view('shops.create-form');
    }

    public function create(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:shops',
            'name' => 'required',
            'owner' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required',
        ]);

        Shop::create($validatedData);
        return redirect()->route('shops.list')->with('success', 'Shop created successfully.');
    }

    public function showEditForm(string $shop): View
    {
        $shop = $this->find($shop);
        return $this->view('shops.edit-form', [
            'shop' => $shop,
        ]);
    }

    public function update(Request $request, string $shopCode): RedirectResponse
    {
        $shop = $this->find($shopCode);

        $validatedData = $request->validate([
            'name' => 'required',
            'owner' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required',
        ]);

        $shop->update($validatedData);

        return redirect()->route('shops.view', $shop->code)->with('success', 'Shop updated successfully.');
    }

    public function delete(string $shop): RedirectResponse
    {
        $shop = $this->find($shop);
        $shop->delete();
        return redirect()->route('shops.list')->with('success', 'Shop deleted successfully.');
    }

    protected function view(string $view, array $data = [], string $customTitle = null): View
    {
        $title = $customTitle ?? $this->title;
        if ($view == 'shops.list') {
            return view($view, array_merge([
                'title' => $title,
            ], $data));
        } else {
            return view($view, array_merge([
                'title' => "{$title} : " . ucfirst(last(explode('.', $view))),
            ], $data));
        }
    }

    public function showAddProductsForm(
        ServerRequestInterface $request,
        ProductController $productController,
        string $shopCode
    ): View {
        $shop = $this->find($shopCode);

        $query = Product::orderBy('code')
            ->whereDoesntHave('shops', function (Builder $innerQuery) use ($shop) {
                return $innerQuery->where('code', $shop->code);
            });

        $search = $productController->prepareSearch($request->getQueryParams());
        $query = $productController->filter($query, $search);

        return view('shops.add-products-form', [
            'title' => "{$this->title} {$shop->code} : Add Products",
            'search' => $search,
            'shop' => $shop,
            'products' => $query->paginate(4),
        ]);
    }

    function addProduct(ServerRequestInterface $request, string $shopCode): RedirectResponse
    {
        $shop = $this->find($shopCode);
        $data = $request->getParsedBody();
        $product = Product::whereDoesntHave('shops', function (Builder $innerQuery) use ($shop) {
            return $innerQuery->where('code', $shop->code);
        })->where('code', $data['product'])->firstOrFail();
        $shop->products()->attach($product);
        return redirect()->back();
    }

    function removeProduct(string $shopCode, string $productCode): RedirectResponse
    {
        $shop = $this->find($shopCode);
        $product = $shop->products()
            ->where('code', $productCode)
            ->firstOrFail();

        $shop->products()->detach($product);
        return redirect()->back();
    }
}
