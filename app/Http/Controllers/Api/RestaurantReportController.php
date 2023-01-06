<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use DB;

class RestaurantReportController extends BaseController
{
	public function __construct(){

	}

	public function dateWiseReport(Request $request){
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		$restaurant_id = $request->restaurant_id;

		$orders = DB::select("select * from orders where created_at>='$start_date' and created_at<='$end_date' and restaurant_id='$restaurant_id'");

		$orderAmount = DB::select("select sum(total_amount) as order_total from orders where created_at>='$start_date' and created_at<='$end_date' and restaurant_id='$restaurant_id'");

		$total_order_count = count($orders);
		$total_order_amount = $orderAmount[0]->order_total;

		$error = false;
        $message = 'Success';

        return response()->json(compact('error','message','total_order_count','total_order_amount','orders'));
	}

	public function dateWiseTransactionReport(Request $request){
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		$restaurant_id = $request->restaurant_id;

		$transactions = DB::select("select * from restaurant_transactions where created_at>='$start_date' and created_at<='$end_date' and restaurant_id='$restaurant_id'");

		$error = false;
        $message = 'Success';

        return response()->json(compact('error','message','transactions'));
	}

	public function itemWiseReport(Request $request){
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		$restaurant_id = $request->restaurant_id;

		$items = array();

		$itemData = DB::select("select * from items where restaurant_id='$restaurant_id'");

		foreach($itemData as $item){
			$name = $item->name;

			$total_order_count = DB::select("select ifnull(sum(quantity),0) as total_q from orderitems where created_at>='$start_date' and created_at<='$end_date' and product_name='$name'");

			$total_order_amount = DB::select("select ifnull(sum(price*quantity),0) as total_p from orderitems where created_at>='$start_date' and created_at<='$end_date' and product_name='$name'");

			$item->total_order_count = $total_order_count[0]->total_q;
			$item->total_order_amount = $total_order_amount[0]->total_p;

			array_push($items, $item);
		}

		$error = false;
        $message = 'Success';

        return response()->json(compact('error','message','items'));
	}
}