<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
       return view('frontend.homepage');
    }

    public function contact()
    {
        return view('frontend.contact');
    }
    
    public function detail()
    {
        return view('frontend.detail');
    }

    
    public function detail1()
    {
        return view('frontend.detail1');
    }
    public function detail2()
    {
        return view('frontend.detail2');
    }
    public function detail3()
    {
        return view('frontend.detail3');
    }

    public function carasewa()
    {
        return view('frontend.carasewa');
    }

    public function product()
    {
        return view('frontend.product');
    }

    public function tentang()
    {
        return view('frontend.tentang');
    }

    public function detail4()
    {
        return view('frontend.sewa');
    }
}

