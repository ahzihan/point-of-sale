<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    function ProductPage():View{
        return view('pages.dashboard.product-page');
    }


    function ProductCreate(Request $request)
    {
        // dd($request->file('img_url'));
        $user_id=$request->header('id');

        // Prepare File Name & Path

        $img=$request->file('img_url');
        $t=time();
        $file_name=$img->getClientOriginalName();
        $img_name="{$user_id}-{$t}-{$file_name}";
        $img_url="uploads/{$img_name}";

        // Upload File
        $img->move(public_path('uploads'),$img_name);

        // Save To Database
        return Product::create([
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit_id'=>$request->input('unit_id'),
            'cat_id'=>$request->input('cat_id'),
            'img_url'=>$img_url,
            'user_id'=>$user_id
        ]);
    }


    function ProductList(Request $request)
    {
        $user_id=$request->header('id');
        return Product::with('category', 'unit')->where('user_id',$user_id)->get();
    }

    function ProductByID(Request $request)
    {
        $user_id=$request->header('id');
        $product_id = $request->input('id');

        return Product::where('user_id',$user_id)->find($product_id);
    }

    function ProductUpdate(Request $request){

        $user_id=$request->header('id');
        $product_id=$request->input('id');

        if ($request->hasFile('img_url')) {

            // Upload New File
            $img=$request->file('img_url');
            $t=time();
            $file_name=$img->getClientOriginalName();
            $img_name="{$user_id}-{$t}-{$file_name}";
            $img_url="uploads/{$img_name}";
            $img->move(public_path('uploads'),$img_name);

            // Delete Old File
            $filePath=$request->input('file_path');
            File::delete($filePath);

            // Update Product

            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit_id'=>$request->input('unit_id'),
                'cat_id'=>$request->input('cat_id'),
                'img_url'=>$img_url
            ]);

        } else {
            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit_id'=>$request->input('unit_id'),
                'cat_id'=>$request->input('cat_id')
            ]);
        }

    }

    function ProductDelete(Request $request){
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return Product::where('id',$product_id)->where('user_id',$user_id)->delete();

    }
}
