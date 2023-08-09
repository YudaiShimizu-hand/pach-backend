<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{

    public function index(Request $request)
    {
        $uid = $request->get('firebase_user_id');
        $getMachine = Machine::where('firebase_user_id', $uid)->get();
        return response()->json($getMachine, 200);
    }


    public function store(Request $request)
    {
        $place = new Machine();
        $place['firebase_user_id'] = $request->get('firebase_user_id');
        $place['machine_name'] = $request->machine_name;
        $place->save();
        return response()->json(['message' => '機種情報の登録に成功しました。']);
    }
}
