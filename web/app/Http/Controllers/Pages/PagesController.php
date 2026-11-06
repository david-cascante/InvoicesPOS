<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function more_about(){
        return view('pages.more-about');
    }
    public function privacy(){
        return view('pages.privacy');
    }
    public function terms(){
        return view('pages.terms');
    }
    public function shop(){
        return view('pages.shop');
    }

}
