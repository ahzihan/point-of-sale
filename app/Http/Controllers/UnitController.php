<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\View\View;
use Illuminate\Http\Request;

class UnitController extends Controller
{

    function UnitPage():View{
        return view('pages.dashboard.unit-page');
    }

    function UnitList(Request $request){
        $user_id=$request->header('id');
        return Unit::where('user_id',$user_id)->get();
    }

    function UnitCreate(Request $request){
        $user_id=$request->header('id');
        return Unit::create([
            'unit_name'=>$request->input('unit_name')
        ]);
    }

    function UnitUpdate(Request $request){
        $unit_id=$request->input('id');
        $user_id=$request->header('id');
        return Unit::where('id',$unit_id)->where('user_id',$user_id)->update([
            'unit_name'=>$request->input('unit_name'),
        ]);
    }

    function UnitDelete(Request $request){
        $unit_id=$request->input('id');
        $user_id=$request->header('id');
        return Unit::where('id',$unit_id)->where('user_id',$user_id)->delete();
    }
}
