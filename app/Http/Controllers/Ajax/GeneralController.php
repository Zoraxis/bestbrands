<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax');
        $this->middleware('priveleges');
    }

    /**
     * Edit the profile for a given user.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function set(Request $request){
        if($request->input('a') != null){
            if($request->input('a') == 'addsizegrid'){
                if($request->input('brand_id') == '' || $request->input('image') == '' || $request->input('name') == ''){
                    die('empty');
                }
                DB::table('size_grid')->insert([
                    [
                        'brand_id'=> $request->input('brand_id'),
                        'image'=> $request->input('image'),
                        'name'=> $request->input('name')
                    ],
                ]);
            }
            if($request->input('a') == 'additem'){
                if($request->input('brand') == '' || $request->input('cat') == '' || $request->input('count') == '' || $request->input('name') == '' || $request->input('content') == '' || $request->input('price') == '' || $request->input('weight') == '' || $request->input('sz') == '' || $request->input('type') == '' || $request->input('img1') == '' || $request->input('img2') == '' || $request->input('imgs') == '' ){
                    die('empty');
                }
                DB::table('products')->insert([
                    [
                        'category_id'=> $request->input('cat'),
                        'brand_id'=> $request->input('brand'),
                        'count'=> $request->input('count'),
                        'name'=> $request->input('name'),
                        'content'=> $request->input('content'),
                        'price'=> $request->input('price'),
                        'weight'=> $request->input('weight'),
                        'sizes'=> $request->input('sz'),
                        'sex'=> $request->input('type'),
                        'image'=> $request->input('img1'),
                        'image2'=> $request->input('img2'),
                        'images'=> $request->input('imgs'),
                    ],
                ]);
                return 'lol';
            }
            if($request->input('a') == 'delitem') {
                $p = DB::table('products')->where([
                    ['id', $request->input('id')]
                ])->get();
                DB::table('products')->where([
                    ['id', $request->input('id')]
                ])->delete();
                return 'success';
            }
        }
    }
}
