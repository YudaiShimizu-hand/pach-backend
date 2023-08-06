<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function store(Request $request)
    {
        $place = new Shop();
        $place['firebase_user_id'] = $request->get('firebase_user_id');
        $place['shop_name'] = $request->shop_name;
        $place->save();
        return response()->json(['message' => '店舗情報の登録に成功しました。']);
    }
}
