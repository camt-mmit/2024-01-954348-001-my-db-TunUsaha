<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;

class CategoriesController extends SearchableController
{
    protected string $title = 'Categories';
    protected int $itemsPerPage = 10;

    protected function getQuery(): Builder
    {
        return Category::orderBy('code');
    }

    protected function getSearchType(): string
    {
        return 'categories';
    }

    protected function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    protected function getListViewName(): string
    {
        return 'categories.list';
    }

    public function showProducts(Request $request, ProductController $productController, $categoryCode)
    {
        $category = Category::where('code', $categoryCode)->firstOrFail();
        $search = $productController->prepareSearch($request->query());
        $query = $productController->filter($category->products(), $search);

        return view('categories.view-products', [
            'title' => "{$this->title} {$category->name} : Products",
            'category' => $category,
            'search' => $search,
            'products' => $query->paginate(5),
        ]);
    }

    public function index(): View
    {
        $search = $this->prepareSearch(request()->all());
        $query = $this->search($search)->withCount('products');
        $categories = $query->paginate($this->getItemsPerPage())->appends($search);

        session()->put('bookmark.categories.list', url()->current());

        return $this->view($this->getListViewName(), [
            'categories' => $categories,
            'search' => $search
        ]);
    }

    public function show(string $category): View
    {
        $category = $this->find($category)->loadCount('products');

        session()->put('bookmark.categories.view', url()->current());

        return $this->view('categories.view', [
            'category' => $category,
        ]);
    }


    public function showCreateForm(): View
    {
        return $this->view('categories.create-form');
    }

    public function create(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:categories',
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $category = Category::create($validatedData);
        return redirect()
            ->route('categories.list')
            ->with('status', "Category {$category->code} was created.");
    }

    public function showEditForm(string $category): View
    {
        $category = $this->find($category);
        return $this->view('categories.edit-form', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, string $categoryCode): RedirectResponse
    {
        $category = $this->find($categoryCode);

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $category->update($validatedData);
        return redirect()
            ->route('categories.list')
            ->with('status', "Category {$category->code} was updated.");
    }

    public function delete(string $category): RedirectResponse
{
    $category = $this->find($category);
    Gate::authorize('delete', $category); // ตรวจสอบสิทธิ์การลบ
    $category->delete();
    return redirect(
        session()->get('categories.view', route('categories.list'))
    )->with('status', "Category {$category->code} was deleted.");
}


    protected function view(string $view, array $data = [], string $customTitle = null): View
    {
        $title = $customTitle ?? $this->title;
        return view($view, array_merge([
            'title' => $title,
        ], $data));
    }

    public function showAddProductsForm(
        ServerRequestInterface $request,
        ProductController $productController,
        string $categoryCode
    ): View {
        $category = $this->find($categoryCode);

        $query = Product::orderBy('code')
            ->whereDoesntHave('category', function (Builder $innerQuery) use ($category) {
                return $innerQuery->where('code', $category->code);
            });

        $search = $productController->prepareSearch($request->getQueryParams());
        $query = $productController->filter($query, $search);

        return view('categories.add-products-form', [
            'title' => "{$this->title} {$category->code} : Add Products",
            'search' => $search,
            'category' => $category,
            'products' => $query->paginate(4),
        ]);
    }

    function addProduct(ServerRequestInterface $request, string $categoryCode): RedirectResponse
    {
        $category = $this->find($categoryCode);
        $data = $request->getParsedBody();
        $product = Product::whereDoesntHave('shops', function (Builder $innerQuery) use ($category) {
            return $innerQuery->where('code', $category->code);
        })->where('code', $data['product'])->firstOrFail();
        $category->products()->attach($product);
        return redirect()
            ->route('categories.add-product', ['category' => $categoryCode])
            ->with('status', "Product {$product->code} was added to Shop {$category->code}.");
    }

    function removeProduct(string $categoryCode, string $productCode): RedirectResponse
    {
        $category = $this->find($categoryCode);
        $product = $category->products()
            ->where('code', $productCode)
            ->firstOrFail();

        $category->products()->detach($product);
        return redirect()
            ->back()
            ->with('status', "Product {$product->code} was removed from Category {$category->code}.");
    }
}
