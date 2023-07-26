<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function CategoryList(Request $request){
        $user_id=$request->header('id');
        return Category::where('user_id',$user_id)->get();
    }

    function CategoryCreate(Request $request){
        $user_id=$request->header('id');
        return Category::create([
            'cat_name'=>$request->input('cat_name'),
            'user_id'=>$user_id
        ]);
    }

    function CategoryUpdate(Request $request){
        $cat_id=$request->input('id');
        $user_id=$request->header('id');
        return Category::where('id',$cat_id)->where('user_id',$user_id)->update([
            'cat_name'=>$request->input('cat_name'),
        ]);
    }

    function CategoryDelete(Request $request){
        $cat_id=$request->input('id');
        $user_id=$request->header('id');
        return Category::where('id',$cat_id)->where('user_id',$user_id)->delete();
    }
}
