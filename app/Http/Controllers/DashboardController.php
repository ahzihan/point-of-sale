<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function DashboardPage():View{
        return view('pages.dashboard.dashboard-page');
    }

    function Summary(Request $request):array{
        $user_id=$request->header('id');
        $product= Product::where('user_id',$user_id)->count();
        $Category= Category::where('user_id',$user_id)->count();
        $Customer=Customer::where('user_id',$user_id)->count();
        $Sale= Sale::where('user_id',$user_id)->count();
        $total=  Sale::where('user_id',$user_id)->sum('total');
        $vat= Sale::where('user_id',$user_id)->sum('vat');
        $sd= Sale::where('user_id',$user_id)->sum('sd');
        $payable =Sale::where('user_id',$user_id)->sum('payable');

        return[
            'product'=> $product,
            'category'=> $Category,
            'customer'=> $Customer,
            'sale'=> $Sale,
            'total'=> round($total,2),
            'vat'=> round($vat,2),
            'sd'=> round($sd,2),
            'payable'=> round($payable,2)
        ];


    }
}
