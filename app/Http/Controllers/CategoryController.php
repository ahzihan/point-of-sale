<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function CategoryPage():View{
        return view('pages.dashboard.category-page');
    }

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

    function CategoryByID(Request $request){
        $cat_id=$request->input('id');
        $user_id=$request->header('id');
        return Category::where('id',$cat_id)->where('user_id',$user_id)->first();
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
