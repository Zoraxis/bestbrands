<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;

class ProfileController extends Controller
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
    }

    public function out(){
        Auth::logout();
        return redirect('profile');
    }

    /**
     * Edit the profile for a given user.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function get(Request $request)
    {
        if ($request->input('a') != null) {
            if ($request->input('a') == 'address') {
                try {
                    return DB::table('address')
                            ->where([
                                    ['user_id', '=', Auth::id()],
                                ])
                            ->get();
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
            else if ($request->input('a') == '1address') {
                try {
                    return DB::table('address')
                            ->where([
                                    ['user_id', '=', Auth::id()],
                                    ['id', '=', $request->input('id')],
                                ])
                            ->get();
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
            else if($request->input('a') == 'products'){
                if(Auth::user()->role != 'u'){
                    return DB::table('products')->get();
                }else{
                    return redirect()->back();
                }
            }
            else if($request->input('a') == 'wishlist'){
                $all = DB::table('personal')->where([
                    ['user_id', Auth::id()],
                    ['is_wishlist', 1]
                ])->get();
                $res = [];
                foreach($all as $one){
                    array_push($res, DB::table('products')->where('id', $one->prod_id)->get()[0]);
                }
                return json_encode($res);
            }
            else if($request->input('a') == 'cart'){
                $all = DB::table('personal')->where([
                    ['user_id', Auth::id()],
                    ['is_cart', 1]
                ])->get();
                $res = [];
                foreach($all as $one){
                    $d = DB::table('products')->where('id', $one->prod_id)->get()[0];
                    $d->sz = $one->size;
                    $d->quant = $one->count;
                    array_push($res, $d);
                }
                return json_encode($res);
            }
            else if($request->input('a') == 'brands'){
                return json_encode(DB::table('brand')->get());
            }
            else if($request->input('a') == 'personal'){
                return json_encode(DB::table('personal')->get());
            }
            else if($request->input('a') == 'card'){
                return json_encode(DB::table('credit_card')->where('user_id', '=', Auth::id())->get());
            }
        }
    }

    /**
     * Edit the profile for a given user.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function edit(Request $request)
    {
        if ($request->input('a') != null) {
            if($request->input('a') == 'main'){
                $data = [
                    $request->input('name'),
                    $request->input('surname'),
                    $request->input('middlename'),
                    $request->input('email'),
                    $request->input('tel')
                ];

                for ($i = 0; $i < count($data); $i++) {
                    $data[$i] = trim($data[$i]);
                    $data[$i] = stripslashes($data[$i]);
                    $data[$i] = htmlspecialchars($data[$i]);
                    if ($data[$i] == '') {
                        die('empty'.$i);
                    }
                }
                if (!filter_var($data[3], FILTER_VALIDATE_EMAIL)) {
                    die('email3');
                }
                if (preg_match("/([+])([(])(\d{3})([)])([ ])(\d{2})([-])(\d{3})([-])(\d{2})([-])(\d{2})/", $data[4]) == 0) {
                    die($data[4].'tel4');
                }

                DB::table('users')
                ->where('id', '=', Auth::id())
                ->update(
                    [
                        'name' => $data[0],
                        'surname' => $data[1],
                        'middlename' => $data[2],
                        'email' => $data[3],
                        'telephone' => $data[4]
                    ],
                );
                return true;
            }
            else if($request->input('a') == 'extra'){
                DB::table('users')
                ->where('id', '=', Auth::id())
                ->update(
                    [
                        'sex' => $request->input('sex'),
                        'birthday' => $request->input('date'),
                    ],
                );
                return true;
            }
            else if($request->input('a') == 'addaddress'){
                if($request->input('post') != '' && $request->input('city') != ''){
                    $test = DB::table('address')->where(
                        [
                            ['post_type', $request->input('post_type')],
                            ['city', $request->input('city')],
                            ['warehouse_id', $request->input('post')],
                            ['user_id', Auth::id()],
                        ]
                    )->get();
                    if(count($test) > 0) {
                        die('repeat');
                    }
                    $count = DB::table('address')->where([
                        ['user_id', Auth::id()]
                    ])->get();
                    if(count($count) >= 5){
                        die('too_many');
                    }
                    $content = json_encode([
                            "apiKey"=> "ecf00f8706fa1e301f5dcdecac0cadd5",
                            "modelName"=> "Address",
                            "calledMethod"=> 'getCities',
                            "methodProperties" => [
                                "Ref"=> $request->input('city'),
                                "Limit"=> "1"
                            ]
                        ]
                    );

                    $curl = curl_init('https://api.novaposhta.ua/v2.0/json/');
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER,
                            array("Content-type: application/json"));
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
                    $res = json_decode(curl_exec($curl));
                    if($res->info->totalCount == 1){
                        $content = json_encode([
                            "apiKey"=> "ecf00f8706fa1e301f5dcdecac0cadd5",
                            "modelName"=> "Address",
                            "calledMethod"=> 'getWarehouses',
                            "methodProperties" => [
                                "CityRef"=> $request->input('city'),
                                "WarehouseId"=> intval($request->input('post')),
                                "Limit"=> "1"
                            ]
                        ]);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
                        $result = json_decode(curl_exec($curl));
                        if($result->info->totalCount == 1){
                            DB::table('address')->insert([
                                [
                                    'user_id'=> Auth::id(),
                                    'is_primary'=> true,
                                    'post_type'=> $request->input('post_type'),
                                    'city'=> $request->input('city'),
                                    'city_desc'=> $res->data[0]->Description,
                                    'warehouse_id'=> $request->input('post'),
                                    'place' => $result->data[0]->Description
                                ]
                            ]);
                        }
                    }

                    curl_close($curl);
                }
            }
            else if($request->input('a') == 'deladdress'){
                if($request->input('id') != ''){
                    try{
                        $test = DB::table('address')->where([
                            ['id', $request->input('id')],
                            ['user_id', Auth::id()],
                        ])->delete();
                    } catch ( Exception $e ){
                        die('wrong-user');
                    }
                }
            }
            else if($request->input('a') == 'editaddress'){
                if($request->input('post') != '' && $request->input('city') != ''&& $request->input('id') != ''){
                    $test = DB::table('address')->where(
                        [
                            ['user_id', Auth::id()],
                            ['id', $request->input('id')],
                        ]
                    )->get();
                    if(count($test) < 0) {
                        die('not_found');
                    }
                    $test = DB::table('address')->where(
                        [
                            ['post_type', $request->input('post_type')],
                            ['city', $request->input('city')],
                            ['warehouse_id', $request->input('post')],
                        ]
                    )->get();
                    if(count($test) > 0) {
                        die('repeat');
                    }
                    $content = json_encode([
                            "apiKey"=> "ecf00f8706fa1e301f5dcdecac0cadd5",
                            "modelName"=> "Address",
                            "calledMethod"=> 'getCities',
                            "methodProperties" => [
                                "Ref"=> $request->input('city'),
                                "Limit"=> "1"
                            ]
                        ]
                    );

                    $curl = curl_init('https://api.novaposhta.ua/v2.0/json/');
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER,
                            array("Content-type: application/json"));
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
                    $res = json_decode(curl_exec($curl));
                    if($res->info->totalCount == 1){
                        $content = json_encode([
                            "apiKey"=> "ecf00f8706fa1e301f5dcdecac0cadd5",
                            "modelName"=> "Address",
                            "calledMethod"=> 'getWarehouses',
                            "methodProperties" => [
                                "CityRef"=> $request->input('city'),
                                "WarehouseId"=> intval($request->input('post')),
                                "Limit"=> "1"
                            ]
                        ]);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
                        $result = json_decode(curl_exec($curl));
                        if($result->info->totalCount == 1){
                            DB::table('address')->where(
                                [
                                    ['user_id', Auth::id()],
                                    ['id', $request->input('id')],
                                ]
                            )->update([
                                'post_type'=> $request->input('post_type'),
                                'city'=> $request->input('city'),
                                'city_desc'=> $res->data[0]->Description,
                                'warehouse_id'=> $request->input('post'),
                                'place' => $result->data[0]->Description
                            ]);
                        }else{
                            die('id_not_found');
                        }
                    }else{
                        die('city_not_found');
                    }

                    curl_close($curl);
                }
            }
            else if($request->input('a') == 'count'){
                if($request->input('add') != null && $request->input('sz') != null && $request->input('id') != null){
                    if($request->input('add') == 't'){
                        DB::table('personal')->where([
                            ['prod_id', '=', $request->input('id')],
                            ['user_id', '=', Auth::id()],
                            ['size', '=', $request->input('sz')]
                        ])->increment('count');
                    } else{
                        DB::table('personal')->where([
                            ['prod_id', '=', $request->input('id')],
                            ['user_id', '=', Auth::id()],
                            ['size', '=', $request->input('sz')]
                        ])->decrement('count');
                    }
                }else {
                    die('empty');
                }
            }
            else if($request->input('a') == 'addcard') {
                if($request->input('cnum') == null || $request->input('name') == null || $request->input('exdate') == null) { die('empty'); }
                if(!$this->middleware('card')){ die('invalid_card');}
                DB::table('credit_card')->insert([
                    [
                        'user_id' => Auth::id(),
                        'number' => $request->input('cnum'),
                        'date' => $request->input('exdate'),
                        'fullname' => $request->input('name'),
                        'is_primary' => 1,
                    ]
                ]);
            }
            else if($request->input('a') == 'delcard'){
                if($request->input('id') != ''){
                    DB::table('credit_card')->where([
                        ['id', $request->input('id')],
                        ['user_id', Auth::id()],
                    ])->delete();
                }
            }
        }else{
            return redirect()->back();
        }
    }
}
