<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    function ReportPage(){
        return view('pages.dashboard.report-page');
    }

    function SalesReport(Request $request){
        $user_id=$request->header('id');
        $FormDate=date('Y-m-d',strtotime($request->FormDate));
        $ToDate=date('Y-m-d',strtotime($request->ToDate));

        $total=Sale::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('total');
        $vat=Sale::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('vat');
        $sd = Sale::where('user_id', $user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('sd');
        $payable=Sale::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('payable');
        $discount=Sale::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('discount');

        $list = DB::table('sales')
        ->join('customers', 'sales.cus_id', '=', 'customers.id')
        ->where('sales.user_id', '=', $user_id)
        ->whereBetween('sales.created_at', [$FormDate, $ToDate])
        ->select('sales.*','customers.cus_name','customers.mobile','customers.email')
        ->get();

        // $list=Sale::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->with('customer')->get();

        $data=['payable'=> $payable,'discount'=>$discount, 'total'=> $total, 'vat'=> $vat, 'sd'=> $sd, 'list'=>$list,'FormDate'=>$request->FormDate,'ToDate'=>$request->FormDate];
        $pdf = Pdf::loadView('report.SalesReport',$data);
        return $pdf->download('invoice.pdf');

    }
}
