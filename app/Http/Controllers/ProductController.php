<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::all();
        return view('products.list', ['products' => $products, 'title' => 'Product : List']);
    }

    public function show($product)
    {
        $product = Product::where('code', $product)->firstOrFail();
        return view('products.view', ['product' => $product, 'title' => 'Product : List']);
    }
}
