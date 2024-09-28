<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function showHome()
    {
        $title = 'Home';
        return view('homePage.home', compact('title'));
    }
}
