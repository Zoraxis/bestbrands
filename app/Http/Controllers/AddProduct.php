<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddProduct extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('priveleges');
    }

    public function index()
    {
        $brands = DB::table('brand')->get();
        $categories = DB::table('category')->get();
        return view('addproduct', compact('brands', 'categories'));
    }
}
