<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{

    public function index(Request $request)
    {
        $uid = $request->get('firebase_user_id');
        $getPlace = Place::where('firebase_user_id', $uid)->get();
        return response()->json($getPlace, 200);
    }

    public function store(Request $request)
    {
        $place = new Place();
        $place['firebase_user_id'] = $request->get('firebase_user_id');
        $place['place_name'] = $request->place_name;
        $place->save();
        return response()->json(['message' => '場所情報の登録に成功しました。']);
    }
}
