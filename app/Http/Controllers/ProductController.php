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

    protected function getQuery(): Builder
    {
        return Product::orderBy('code');
    }

    /*public function productList(Request $request): View
    {
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search);
        return view('products.list', [
            'title' => "{$this->title} : List",
            'search' => $search,
            'products' => $query->paginate(5),
        ]);
    }*/

    public function show(string $productCode): View
    {
        $product = $this->find($productCode);
        return view('products.view', [
            'title' => "{$this->title} : View",
            'product' => $product,
        ]);
    }

    public function showCreateForm(): View
    {
        return view('products.create-form', [
            'title' => "{$this->title} : Create",
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $product = Product::create($request->getParsedBody());
        return redirect()->route('products.list');
    }

    public function list(Request $request, string $title = 'Products'): View
    {
        $search = $this->prepareSearch($request->query());
        $query = $this->search($search);
        return view('products.list', [
            'search' => $search,
            'title' => "{$title} : List",
            'products' => $query->paginate(3),
        ]);
    }
}
