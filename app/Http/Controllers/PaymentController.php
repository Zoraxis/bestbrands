<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(){
        $all = DB::table('personal')->where([
            ['user_id', Auth::id()],
            ['is_cart', 1]
        ])->get();
        $items = [];
        foreach($all as $one){
            $d = DB::table('products')->where('id', $one->prod_id)->get()[0];
            $d->sz = $one->size;
            $d->quant = $one->count;
            $sizes2 = [];
            $sizes = explode(' ', $d->sizes);
            foreach($sizes as $size){
                $sizes2[explode('.', $size)[0]] = explode('.', $size)[1];
            }
            $d->maxCount = $sizes2[$one->size];
            array_push($items, $d);
        }
        $address = DB::table('address')->where('user_id', Auth::id())->get();
        $cards = DB::table('credit_card')->where('user_id', Auth::id())->get();
        return view('payment', compact('items', 'address', 'cards'));
    }
}
