<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showHome()
    {
        $title = 'Home';
        return view('homePage.home', compact('title'));
    }
}
