<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $options = [];
        $order = 'clicks';
        if($request->input('cat') !== null){
            array_push($options, ['category_id', $request->input('cat')]);
        }
        if($request->input('b') !== null){
            array_push($options, ['brand_id', $request->input('b')]);
        }
        if($request->input('sex') !== null){
            array_push($options, ['sex', $request->input('sex')]);
        }
        $products = DB::table('products')->where($options)->orderByDesc($order )->paginate(12);
        return view('products', compact('products'));
    }
}
