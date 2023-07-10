<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class APIController extends Controller
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

    /**
     * Edit the profile for a given user.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function get(Request $request)
    {
        if ($request->input('a') != null) {
            if($request->input('a') == 'post'){
                if (strlen($request->input('input')) > 0) {
                    if($request->input('req') == 'id'){
                        try{
                            intval($request->input('input'));
                        } catch (Exception $e) { die('Not a number');}
                    }

                    if($request->input('req') == 'id'){
                        $props = [
                            "WarehouseId"=> intval($request->input('input')),
                            "CityRef"=> $request->input('cityRef'),
                            "Limit"=> 5
                        ];
                        $method = "getWarehouses";
                    } else {
                        $props = [
                            "CityName"=> $request->input('input'),
                            "Limit"=> "5",
                            "Page"=> "1"
                        ];
                        $method = "searchSettlements";
                    }

                    $content = json_encode([
                            "apiKey"=> "ecf00f8706fa1e301f5dcdecac0cadd5",
                            "modelName"=> "Address",
                            "calledMethod"=> $method,
                            "methodProperties" => $props
                        ]
                    );

                    $curl = curl_init('https://api.novaposhta.ua/v2.0/json/');
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER,
                            array("Content-type: application/json"));
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

                    $json_response = curl_exec($curl);

                    curl_close($curl);

                    return json_decode($json_response, true);
                }
            }
            if($request->input('a') == 'pricepost'){
                $content = json_encode([
                        "apiKey"=> "ecf00f8706fa1e301f5dcdecac0cadd5",
                        "modelName"=> "InternetDocument",
                        "calledMethod"=> "getDocumentPrice",
                        "methodProperties"=> [
                            "CitySender"=> "db5c891b-391c-11dd-90d9-001a92567626",
                            "CityRecipient"=> "981c109e-1a49-11ed-a361-48df37b92096",
                            "Weight"=> "10",
                            "ServiceType"=> "WarehouseWarehouse",
                            "Cost"=> "200",
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

                $json_response = curl_exec($curl);

                curl_close($curl);

                return json_decode($json_response, true);
            }
        }
    }
}
