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
    protected int $itemsPerPage = 9;

    protected function getQuery(): Builder
    {
        return Product::orderBy('code');
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
        ]);

        Product::create($validatedData);
        return redirect()->route('products.list')->with('success', 'Product created successfully.');
    }

    public function list(Request $request, string $title = 'Products'): View
    {
        $search = $this->prepareSearch($request->query());
        $query = $this->search($search);

        $products = $query->paginate($this->itemsPerPage)->appends($search);

        return $this->view('products.list', [
            'search' => $search,
            'products' => $products,
        ], $title);
    }

    protected function view(string $view, array $data = [], string $customTitle = null): View
    {
        $title = $customTitle ?? $this->title;
        return view($view, array_merge([
            'title' => "{$title} : " . ucfirst(last(explode('.', $view))),
        ], $data));
    }
}
