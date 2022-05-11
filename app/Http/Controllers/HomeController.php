<?php


namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function home() : View
    {
        return view('pages.home');
    }

    public function categories()
    {
        return view('pages.categories.index');
    }
}
