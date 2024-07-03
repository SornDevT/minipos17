<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transection;
use App\Models\Bill;
use App\Models\Bill_list;


class TransectionController extends Controller
{
    //

    public function __construct(){
        $this->middleware("auth:api");
    }


    public function index(Request $request){

        $sort = \Request::get("sort");
        $perpage = \Request::get("perpage");

        $month_type = $request->month_type;
        $dmy = $request->dmy; // 2024-07-03
        $m = explode("-",$dmy)[1];
        $y = explode("-",$dmy)[0];

        if($month_type == "m"){

            $tran = Transection::orderBy("id",$sort)
            ->whereYear("created_at",$y)
            ->whereMonth("created_at",$m)
            ->paginate($perpage)
            ->toArray();

        } else if($month_type == "y"){
            $tran = Transection::orderBy("id",$sort)
            ->whereYear("created_at",$y)
            ->paginate($perpage)
            ->toArray();

        }

        return array_reverse($tran);


    }

    public function add(Request $request){


        try {

            $Bill_ID = "B".date("ym").rand(1000,9999);

            // ບັນທຶກຂໍ້ມູນໃບບິນ
            $bill = new Bill([
                "bill_id"=> $Bill_ID,
                "customer_name"=> $request->customer_name,
                "customer_tel"=> $request->customer_tel
            ]);
            $bill->save();



            foreach($request->listorder as $item){

            
            $tran = new Transection([
                "tran_id" => date('ym').rand(1000,9999), 
                "tran_type" => "income",
                "product_id" => $item["id"],
                "qty" => $item["order_qty"],
                "price" => $item["price_sell"],
                "detail" => $item["name"]
            ]);
            $tran->save();

            /// ບັນທຶກລາຍການໃບບີນ
            $bill_list = new Bill_list([
                "bill_id" => $Bill_ID,
                "name" => $item["name"],
                "qty" => $item["order_qty"],
                "price" => $item['price_sell']
            ]);
            $bill_list->save();

            }


            

 
             $success = true;
             $message = 'ບັນທຶກຂໍ້ມູນ ສຳເລັດ!';
 
         } catch (\Illuminate\Database\QueryException $ex) {
             $success = false;
             $message = $ex->getMessage();
             $Bill_ID = null;
         }
 
         $response = [
             'success' => $success,
             'message' => $message,
             'bill_id' => $Bill_ID
         ];
 
         return response()->json($response);
    }
}
