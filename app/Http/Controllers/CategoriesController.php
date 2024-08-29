<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

        return $this->view($this->getListViewName(), [
            'categories' => $categories,
            'search' => $search
        ]);
    }

    public function show(string $category): View
{
    $category = $this->find($category)->loadCount('products');
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

        Category::create($validatedData);
        return redirect()->route('categories.list')->with('success', 'Category created successfully.');
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

        return redirect()->route('categories.view', $category->code)->with('success', 'Category updated successfully.');
    }

    public function delete(string $category): RedirectResponse
    {
        $category = $this->find($category);
        $category->delete();
        return redirect()->route('categories.list')->with('success', 'Category deleted successfully.');
    }

    protected function view(string $view, array $data = [], string $customTitle = null): View
    {
        $title = $customTitle ?? $this->title;
        return view($view, array_merge([
            'title' => $title,
        ], $data));
    }
}
