<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    function ProductCreate(Request $request)
    {
        $user_id=$request->header('id');

        // Prepare File Name & Path

        $img=$request->file('img');
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
        return Product::where('user_id',$user_id)->get();
    }

    function ProductUpdate(Request $request){

        $user_id=$request->header('id');
        $product_id=$request->input('id');

        if ($request->hasFile('img')) {

            // Upload New File
            $img=$request->file('img');
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
