<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Data;
use App\Models\v1\Place;
use App\Models\v1\Shop;
use App\Models\v1\Machine;
use Illuminate\Http\Request;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
        $data = new Data();
        $data["place_id"] = Place::where('place_name', $request->place_name)->where('firebase_user_id', $request->get('firebase_user_id'))->value('id');
        $data["shop_id"] = Shop::where('shop_name', $request->shop_name)->where('firebase_user_id', $request->get('firebase_user_id'))->value('id');
        $data["machine_id"] = Machine::where('machine_name', $request->machine_name)->where('firebase_user_id', $request->get('firebase_user_id'))->value('id');
        $data["investment"] = $request->investment;
        $data["proceeds"] = $request->proceeds;
        $data["firebase_user_id"] = $request->get('firebase_user_id');
        if($data["investment"] > $data["proceeds"]){
            $data["score"] = $data["investment"] - $data["proceeds"];
            $data["judge_flag"] = false;
        }else{
            $data["score"] = $data["proceeds"] - $data["investment"];
            $data["judge_flag"] = true;
        }

        $data->save();
        return response()->json(['message' => '記録情報の登録に成功しました。']);
     }

     public function analysis(Request $request)
     {
        $place_id = Place::where('place_name', $request->place_name)->where('firebase_user_id', $request->get('firebase_user_id'))->value('id');
        $shop_id = Shop::where('shop_name', $request->shop_name)->where('firebase_user_id', $request->get('firebase_user_id'))->value('id');
        $machine_id = Machine::where('machine_name', $request->machine_name)->where('firebase_user_id', $request->get('firebase_user_id'))->value('id');
        $getAnalysis = [];
        $getAnalysis = $this->where('place_id', $place_id)->where('shop_id', $shop_id)->where('machine_id', $machine_id);
        $totalData = count($getAnalysis);
        $getWinData = [];
        $getWinData = $getAnalysis->where('judge_flag', true);
        $winData = count(getWinData);
        $analysisData = $winData / $getWinData * 100;
        return response()->json($analysisData, 200);
     }
}
