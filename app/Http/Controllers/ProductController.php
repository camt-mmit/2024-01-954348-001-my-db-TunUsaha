<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    private string $title = 'Product';

    public function list(): View
    {
        $products = Product::orderBy('code')->get();
        return view('products.list', [
            'title' => "{$this->title} : List",
            'products' => $products,
        ]);
    }

    public function show(string $productCode): View
    {
        $product = Product::where('code', $productCode)->firstOrFail();
        return view('products.view', [
            'title' => "{$this->title} : View",
            'product' => $product,
        ]);
    }
}