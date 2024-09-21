<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Shop;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class ProductController extends SearchableController
{
    protected string $title = 'Products';
    protected int $itemsPerPage = 4;

    protected function getQuery(): Builder
    {
        return Product::orderBy('code');
    }

    protected function getSearchType(): string
    {
        return 'products';
    }

    protected function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    protected function getListViewName(): string
    {
        return 'products.list';
    }

    public function show(string $productCode): View
    {
        $product = $this->find($productCode);
        return $this->view('products.view', [
            'product' => $product,
        ]);
    }

    public function showCreateForm(): View
    {
        Gate::authorize('create', Product::class); // Authorization check
        $categories = Category::all();
        $title = 'Create New Product';
        return view('products.create-form', compact('categories', 'title'));
    }

    public function list(Request $request): View
    {
        session()->put('bookmark.products.list', url()->current());

        $search = $this->prepareSearch($request->query());
        $query = $this->search($search)->withCount('shops');
        $products = $query->paginate($this->getItemsPerPage())->appends($search);

        return $this->view($this->getListViewName(), [
            'search' => $search,
            'products' => $products,
        ]);
    }



    public function showShops(Request $request, ShopController $shopController, $productCode)
    {
        $product = Product::where('code', $productCode)->firstOrFail();
        $search = $shopController->prepareSearch($request->query());
        $query = $shopController->filter($product->shops(), $search, 'shops');

        session()->put('bookmark.products.view-shops', url()->current());

        return view('products.view-shops', [
            'title' => "{$this->title} {$product->code} : Shop",
            'product' => $product,
            'search' => $search,
            'shops' => $query->paginate(5),
        ]);
    }



    function showEditForm(string $productCode): View
    {
        Gate::authorize('update', Product::class); // Authorization check

        $product = $this->find($productCode);
        $categories = Category::all();
        $title = "Edit Product: " . $product->name;

        return view('products.edit-form', compact('product', 'categories', 'title'));
    }


    public function create(Request $request): RedirectResponse
    {
        Gate::authorize('create', Product::class); // Authorization check

        $validatedData = $request->validate([
            'code' => 'required|unique:products',
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
        ]);

        $product = Product::create($validatedData);
        return redirect()
            ->route('products.list')
            ->with('status', "Product {$product->code} was created.");
    }


    function update(Request $request, string $productCode): RedirectResponse
    {
        Gate::authorize('update', Product::class); // Authorization check

        $validatedData = $request->validate([
            'code' => 'required|string|unique:products,code,' . $productCode . ',code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product = Product::where('code', $productCode)->firstOrFail();
        $product->update($validatedData);

        return redirect()
            ->route('products.list')
            ->with('status', "Product {$product->code} was updated.");
    }
    function delete(string $productCode): RedirectResponse
    {
        Gate::authorize('delete', Product::class); // Authorization check

        $product = $this->find($productCode);
        $product->delete();
        return redirect(
            session()->get('bookmark.products.view', route('products.list'))
        )->with('status', "Product {$product->code} was deleted.");
    }


    protected function view(string $view, array $data = [], string $customTitle = null): View
    {
        $title = $customTitle ?? $this->title;
        if ($view == 'products.list') {
            return view($view, array_merge([
                'title' => $title,
            ], $data));
        } else {
            return view($view, array_merge([
                'title' => "{$title} : " . ucfirst(last(explode('.', $view))),
            ], $data));
        }
    }
    function showAddShopsForm(
        ServerRequestInterface $request,
        ShopController $shopController,
        string $productCode
    ): View {
        Gate::authorize('update', Product::class); // Authorization check

        $product = $this->find($productCode);
        $query = Shop::orderBy('code')
            ->whereDoesntHave('products', function (Builder $innerQuery) use ($product) {
                return $innerQuery->where('code', $product->code);
            });

        $search = $shopController->prepareSearch($request->getQueryParams());
        $query = $shopController->filter($query, $search, 'shops');

        session()->put('bookmark.products.add-shops-form', url()->current());

        return view('products.add-shops-form', [
            'title' => "{$this->title} {$product->code} : Add Shops",
            'search' => $search,
            'product' => $product,
            'shops' => $query->paginate(5),
        ]);
    }

    function addShop(ServerRequestInterface $request, string $productCode): RedirectResponse
    {
        Gate::authorize('update', Product::class); // Authorization check

        $product = $this->find($productCode);
        $data = $request->getParsedBody();
        $shop = Shop::whereDoesntHave('products', function (Builder $innerQuery) use ($product) {
            return $innerQuery->where('code', $product->code);
        })->where('code', $data['shop'])->firstOrFail();
        $product->shops()->attach($shop);

        return redirect()
            ->route('products.add-shop', ['product' => $productCode])
            ->with('status', "Shop {$shop->code} was added to Product {$product->code}.");
    }

    function removeShop(string $productCode, string $shopCode): RedirectResponse
    {
        Gate::authorize('update', Product::class); // Authorization check

        $product = $this->find($productCode);
        $shop = $product->shops()
            ->where('code', $shopCode)
            ->firstOrFail();
        $product->shops()->detach($shop);

        return redirect()
            ->back()
            ->with('status', "Shop {$shop->code} was removed from Product {$product->code}.");
    }
}
