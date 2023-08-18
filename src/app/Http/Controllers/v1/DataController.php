<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Data;
use App\Models\v1\Place;
use App\Models\v1\Shop;
use App\Models\v1\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\DataResource;

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
        $data["score"] = $data["proceeds"] - $data["investment"];
        $data->save();
        return response()->json(['message' => '記録情報の登録に成功しました。']);
     }

     public function analysis(Request $request)
     {
        $place_id = Place::where('place_name', $request->place_name)->where('firebase_user_id', $request->get('firebase_user_id'))->value('id');
        $shop_id = Shop::where('shop_name', $request->shop_name)->where('firebase_user_id', $request->get('firebase_user_id'))->value('id');
        $machine_id = Machine::where('machine_name', $request->machine_name)->where('firebase_user_id', $request->get('firebase_user_id'))->value('id');
        $getAnalysis = [];
        $getAnalysis = Data::where('place_id', $place_id)->where('shop_id', $shop_id)->where('machine_id', $machine_id);
        $totalData = $getAnalysis->count();
        $getWinData = [];
        $getWinData = $getAnalysis->whereRaw('CAST(proceeds AS SIGNED) - CAST(investment AS SIGNED) > 0')->get();
        $winData = count($getWinData);
        $analysisData = ($winData / $totalData) * 100;
        return response()->json($analysisData, 200);
     }

     public function total(Request $request)
     {
        $totalData = [];
        $totalData = Data::where('firebase_user_id', $request->get('firebase_user_id'))->get();
        $totals = 0;
        foreach($totalData as $total)
        {
            $totals += $total->score;
        }
        return response()->json($totals, 200);
     }

     public function monthTotal(Request $request)
     {
        $requestedMonth = $request->month;
        $totalData = Data::where('firebase_user_id', $request->get('firebase_user_id'))->whereRaw('MONTH(created_at) = ?', [$requestedMonth])->get();
        $totals = 0;
        foreach($totalData as $total)
        {
            $totals += $total->score;
        }
        return response()->json($totals, 200);
     }

     public function calendar(Request $request)
     {
        $calendarData = Data::where('firebase_user_id', $request->get('firebase_user_id'))->with(['place', 'shop', 'machine'])->get();
        $data = DataResource::collection($calendarData);
        return response()->json($data, 200);
     }
}
