<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleDetail;
use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{

    function SalePage():View{
        return view('pages.dashboard.sale-page');
    }

    function SaleDetailPage():View{
        return view('pages.dashboard.sale-detail-page');
    }


    function SaleCreate(Request $request){

        DB::beginTransaction();

        try{
            $user_id=$request->header('id');
            $total=$request->input('total');
            $discount=$request->input('discount');
            $vat=$request->input('vat');
            $sd=$request->input('sd');
            $payable=$request->input('payable');
            $cus_id=$request->input('cus_id');

            $sale= Sale::create([
                'total'=>$total,
                'discount'=>$discount,
                'vat'=>$vat,
                'sd'=>$sd,
                'payable'=>$payable,
                'user_id'=>$user_id,
                'cus_id'=>$cus_id
            ]);

            $saleID = $sale->id;

            $products = $request->input('products');

            foreach ($products as $item) {
                SaleDetail::create([
                    'sale_id' => $saleID,
                    'product_id' => $item['product_id'],
                    'qty' =>  $item['qty'],
                    'sale_price'=>  $item['sale_price']
                ]);
            }

        DB::commit();
        return 1;
        }
        catch(Exception $e){
            DB::rollBack();
            return 0;
        }
    }

    function SaleSelect(Request $request){
        $user_id=$request->header('id');
        return Sale::where('user_id',$user_id)->with('customer')->get();
    }

    function SaleDetails(Request $request){
        $user_id=$request->header('id');
        $customerDetails=Customer::where('user_id',$user_id)->where('id',$request->input('cus_id'))->first();
        $saleTotal=Sale::where('user_id',$user_id)->where('id',$request->input('sale_id'))->first();
        $saleProduct=SaleDetail::where('sale_id',$request->input('sale_id'))->get();

        return array(
            'customer'=>$customerDetails,
            'sale'=>$saleTotal,
            'product'=>$saleProduct,
        );
    }

    function SaleDelete(Request $request){
        DB::beginTransaction();

        try{
            SaleDetail::where('sale_id',$request->input('sale_id'))->delete();
            Sale::where('id',$request->input('sale_id'))->delete();

            DB::commit();
            return 1;
        }
        catch(Exception $e){
            DB::rollBack();
            return 0;
        }
    }
}