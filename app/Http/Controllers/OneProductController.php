<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OneProductController extends Controller
{
    /**
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index($id, Request $request)
    {
        $personal = (object)['is_wishlist' => 0, 'is_cart' => 0];
        $empty = false;
        if (Auth::check()) {
            $personal = DB::table('personal')
            ->where([
                ['prod_id', '=', $id],
                ['user_id', '=', Auth::id()],
                ['size', '=', $request->input('sz')]
            ])
            ->get();
            info($id.' '.Auth::id());
            
            try {
                info($personal);
                $personal = json_decode($personal)[0];
            }catch(Exception $ex) {
                $empty = true;
                $personal = (object)['is_wishlist' => 0, 'is_cart' => 0];
            }
        }

        if ($request->input('a')) {
            if (Auth::check()) {
                if($request->input('sz') == '' || $request->input('sz') == null) {
                    die('empty.size');
                }
                if ($request->input('a') == 'w') {
                    if ($empty) {
                        DB::table('personal')->insert([
                            'prod_id' => $id,
                            'user_id' => Auth::id(),
                            'size' => $request->input('sz'),
                            'count' => 1,
                            'is_wishlist' => true,
                            'is_cart' => false
                        ]);
                    }else {
                        DB::table('personal')->where([
                            ['prod_id', '=', $id],
                            ['user_id', '=', Auth::id()],
                            ['size', '=', $request->input('sz')]
                        ])->update([
                            'is_wishlist' => !$personal->is_wishlist
                        ]);
                        return $personal;
                    }
                }elseif ($request->input('a') == 'c') {
                    if ($empty) {
                        DB::table('personal')->insert([
                            'prod_id' => $id,
                            'user_id' => Auth::id(),
                            'size' => $request->input('sz'),
                            'count' => 1,
                            'is_wishlist' => false,
                            'is_cart' => true
                        ]);
                    }else {
                        DB::table('personal')->where([
                            ['prod_id', '=', $id],
                            ['user_id', '=', Auth::id()],
                            ['size', '=', $request->input('sz')]
                        ])->update([
                            'is_cart' => !$personal->is_cart
                        ]);
                        return $personal;
                    }
                }
            }else {
                return redirect()->back()->with('error', 'is');
            }
        
        }

        DB::table('products')->where('id', $id)->increment('clicks');
        $product = Product::find($id);
        if($product->images != ''){
            $product->images = explode(';', $product->images);
        }
        return view('oneproduct', compact('product', 'personal'));
    }
}
