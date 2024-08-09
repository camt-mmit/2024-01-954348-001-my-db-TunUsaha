<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends SearchableController
{
    protected string $title = 'Products';
    protected int $itemsPerPage = 5;

    protected function getQuery(): Builder
    {
        return Product::orderBy('code');
    }

    // เพิ่มเมธอดที่ implement จาก SearchableController
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
        return $this->view('products.create-form');
    }

    public function create(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:products',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
        ]);

        Product::create($validatedData);
        return redirect()->route('products.list')->with('success', 'Product created successfully.');
    }

    public function list(Request $request): View
    {
        $search = $this->prepareSearch($request->query());
        $query = $this->search($search);
        $products = $query->paginate($this->getItemsPerPage())->appends($search);
        return $this->view($this->getListViewName(), [
            'search' => $search,
            'products' => $products,
        ]);
    }

    public function showEditForm(string $productCode): View
    {
        $product = $this->find($productCode);
        return $this->view('products.edit-form', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
        ]);

        $product->update($validatedData);
        return redirect()->route('products.view', $product->code)->with('success', 'Product updated successfully.');
    }

    public function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->delete();
        return redirect()->route('products.list')->with('success', 'Product deleted successfully.');
    }

    protected function view(string $view, array $data = [], string $customTitle = null): View
    {
        $title = $customTitle ?? $this->title;
        return view($view, array_merge([
            'title' => "{$title} : " . ucfirst(last(explode('.', $view))),
        ], $data));
    }
}
