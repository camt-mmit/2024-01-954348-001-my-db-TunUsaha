<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function list()
    {
        $shops = Shop::all();
        return view('shops.list', ['shops' => $shops, 'title' => 'Shop :List']);
    }

    public function show($shop)
    {
        $shop = Shop::where('code', $shop)->firstOrFail();
        return view('shops.view', ['shop' => $shop, 'title' => 'Shop :View']);
    }
}
