<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    const SUCCESS_ADD_MESSAGE = 'Product added to cart';
    const SUCCESS_REMOVE_MESSAGE = 'Product removed from cart';
    const SUCCESS_CLEAR_MESSAGE = 'Cart cleared';

    public function show()
    {
        $cart = session()->get('cart', []);
        return view('cart.show', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->route('cart.show')->with('success', self::SUCCESS_ADD_MESSAGE);
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.show')->with('success', self::SUCCESS_REMOVE_MESSAGE);
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.show')->with('success', self::SUCCESS_CLEAR_MESSAGE);
    }
}
