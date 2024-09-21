<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Product;
use App\Models\Category;


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

    public function showProducts(Request $request, ProductController $productController, Shop $shop)
{
    // แก้ไขโค้ดให้ใช้ $shop แทน $category
    $search = $productController->prepareSearch($request->query());
    $query = $productController->filter($shop->products(), $search);

    session()->put('bookmark.shops.view-products', url()->current());

    return view('shops.view-products', [
        'title' => "{$this->title} {$shop->name} : Products",
        'shop' => $shop,
        'search' => $search,
        'products' => $query->paginate(5),
    ]);
}


    public function index(): View
    {
        $search = $this->prepareSearch(request()->all());
        $query = $this->search($search)->withCount('products');
        $shops = $query->paginate($this->getItemsPerPage())->appends($search);

        session(['bookmark.shops.view' => url()->current()]);

        return $this->view($this->getListViewName(), [
            'shops' => $shops,
            'search' => $search
        ]);
    }


    public function show(Shop $shop): View
{
    $shop->loadCount('products');
    session(['bookmark.shops.view' => url()->current()]);

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

        $shop = Shop::create($validatedData);
        return redirect()
            ->route('shops.list')
            ->with('status', "Shop {$shop->code} was created.");
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
        return redirect()
            ->route('shops.list')
            ->with('status', "Shop {$shop->code} was updated.");
    }

    public function delete(string $shop): RedirectResponse
    {
        $shop = $this->find($shop);
        $shop->delete();

        return redirect(
            session()->get('shops.view', route('shops.list'))
        )->with('status', "Shop {$shop->code} was deleted.");
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
        Request $request,
        ProductController $productController,
        Shop $shop
    ): View {


        $query = Product::orderBy('code')
            ->whereDoesntHave('shops', function (Builder $innerQuery) use ($shop) {
                return $innerQuery->where('id', $shop->id);
            });

        $search = $productController->prepareSearch($request->query());
        $query = $productController->filter($query, $search);

        session()->put('bookmark.shops.add-products-form', url()->current());

        return view('shops.add-products-form', [
            'title' => "{$this->title} {$shop->name} : Add Products",
            'search' => $search,
            'shop' => $shop,
            'products' => $query->paginate(4),
        ]);
    }


    public function addProduct(Request $request, Shop $shop): RedirectResponse
{
    $data = $request->validated();
    $product = Product::whereDoesntHave('shops', function (Builder $innerQuery) use ($shop) {
        return $innerQuery->where('id', $shop->id);
    })->where('code', $data['product'])->firstOrFail();
    $shop->products()->attach($product);
    return redirect()
        ->route('shops.add-products-form', ['shop' => $shop->code])
        ->with('status', "Product {$product->code} was added to Shop {$shop->code}.");
}

public function removeProduct(Shop $shop, string $productCode): RedirectResponse
{
    $product = $shop->products()
        ->where('code', $productCode)
        ->firstOrFail();

    $shop->products()->detach($product);
    return redirect()
        ->back()
        ->with('status', "Product {$product->code} was removed from Shop {$shop->code}.");
}
}
