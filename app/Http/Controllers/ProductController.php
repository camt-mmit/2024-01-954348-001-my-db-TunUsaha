<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    private string $title = 'Product';

    function list(): View
    {
        $product = Product::orderBy('code')->get();

        return view('products.list', ['title' => $this->title, 'products' => $product]);
    }

    function show(string $productCode): View
    {
        $product = Product::where('code', $productCode)->first();

        if ($product === null) {
            abort(404);
        }

        return view('products.view', ['title' => $this->title, 'product' => $product]);
    }
}
