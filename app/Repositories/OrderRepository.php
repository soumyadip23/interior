<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Orderitem;
use App\Models\Restaurant;
use App\Models\DeliveryBoy;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\OrderContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use DB;

/**
 * Class OrderRepository
 *
 * @package \App\Repositories
 */
class OrderRepository extends BaseRepository implements OrderContract
{
    use UploadAble;

    /**
     * OrderRepository constructor.
     * @param Order $model
     */
    public function __construct(Order $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @param $status
     * @return mixed
     */
    public function allOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id,$status){
        //$orders = Order::with('restaurant')->where('is_deleted',0)->get();

        $orders = Order::orderBy('id','desc')
                ->when($order_id, function($query) use ($order_id){
                    $query->where('unique_id', '=', $order_id);
                })
                ->when($name, function($query) use ($name){
                    $query->where('name', 'like', '%' . $name .'%');
                })
                ->when($mobile, function($query) use ($mobile){
                    $query->where('mobile', 'like', '%' . $mobile .'%');
                })
                ->when($start_date, function($query) use ($start_date){
                    $query->where('created_at', '>=', $start_date);
                })
                ->when($end_date, function($query) use ($end_date){
                    $query->where('created_at', '<=', $end_date);
                })
                ->when($restaurant_id, function($query) use ($restaurant_id){
                    $query->where('restaurant_id', '=', $restaurant_id);
                })
                ->when($status, function($query) use ($status){
                    $query->where('status', '=', $status);
                })
                ->paginate(50);

        return $orders;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getDetails($id){
        $orders = Order::with('restaurant')->with('items')->with('boy')->where('id',$id)->get();

        return $orders[0];
    }

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @return mixed
     */
    public function newOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id){
        //$orders = Order::with('restaurant')->where('status','1')->where('is_deleted',0)->get();

        $orders = Order::with('restaurant')->where('status','1')->where('is_deleted',0)->orderBy('id','desc')
                ->when($order_id, function($query) use ($order_id){
                    $query->where('unique_id', '=', $order_id);
                })
                ->when($name, function($query) use ($name){
                    $query->where('name', 'like', '%' . $name .'%');
                })
                ->when($mobile, function($query) use ($mobile){
                    $query->where('mobile', 'like', '%' . $mobile .'%');
                })
                ->when($start_date, function($query) use ($start_date){
                    $query->where('created_at', '>=', $start_date);
                })
                ->when($end_date, function($query) use ($end_date){
                    $query->where('created_at', '<=', $end_date);
                })
                ->when($restaurant_id, function($query) use ($restaurant_id){
                    $query->where('restaurant_id', '=', $restaurant_id);
                })
                ->paginate(50);

        return $orders;
    }

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @return mixed
     */
    public function ongoingOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id){
        //$orders = Order::with('restaurant')->whereIn('status',array('2','3','4','5','6','7'))->where('is_deleted',0)->get();

        $orders = Order::with('restaurant')->with('boy')->whereIn('status',array('2','3','4','5','6','7'))->where('is_deleted',0)->orderBy('id','desc')
                ->when($order_id, function($query) use ($order_id){
                    $query->where('unique_id', '=', $order_id);
                })
                ->when($name, function($query) use ($name){
                    $query->where('name', 'like', '%' . $name .'%');
                })
                ->when($mobile, function($query) use ($mobile){
                    $query->where('mobile', 'like', '%' . $mobile .'%');
                })
                ->when($start_date, function($query) use ($start_date){
                    $query->where('created_at', '>=', $start_date);
                })
                ->when($end_date, function($query) use ($end_date){
                    $query->where('created_at', '<=', $end_date);
                })
                ->when($restaurant_id, function($query) use ($restaurant_id){
                    $query->where('restaurant_id', '=', $restaurant_id);
                })
                ->paginate(50);

        return $orders;
    }

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @return mixed
     */
    public function deliveredOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id){
        //$orders = Order::with('restaurant')->where('status','8')->where('is_deleted',0)->get();

        $orders = Order::with('restaurant')->where('status','8')->where('is_deleted',0)->orderBy('id','desc')
                ->when($order_id, function($query) use ($order_id){
                    $query->where('unique_id', '=', $order_id);
                })
                ->when($name, function($query) use ($name){
                    $query->where('name', 'like', '%' . $name .'%');
                })
                ->when($mobile, function($query) use ($mobile){
                    $query->where('mobile', 'like', '%' . $mobile .'%');
                })
                ->when($start_date, function($query) use ($start_date){
                    $query->where('created_at', '>=', $start_date);
                })
                ->when($end_date, function($query) use ($end_date){
                    $query->where('created_at', '<=', $end_date);
                })
                ->when($restaurant_id, function($query) use ($restaurant_id){
                    $query->where('restaurant_id', '=', $restaurant_id);
                })
                ->paginate(50);

        return $orders;
    }

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @param $cancelled_by
     * @return mixed
     */
    public function cancelledOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id,$cancelled_by){
        $orders = Order::with('restaurant')->where('status','10')->where('is_deleted',0)->orderBy('id','desc')
                ->when($order_id, function($query) use ($order_id){
                    $query->where('unique_id', '=', $order_id);
                })
                ->when($name, function($query) use ($name){
                    $query->where('name', 'like', '%' . $name .'%');
                })
                ->when($mobile, function($query) use ($mobile){
                    $query->where('mobile', 'like', '%' . $mobile .'%');
                })
                ->when($start_date, function($query) use ($start_date){
                    $query->where('created_at', '>=', $start_date);
                })
                ->when($end_date, function($query) use ($end_date){
                    $query->where('created_at', '<=', $end_date);
                })
                ->when($restaurant_id, function($query) use ($restaurant_id){
                    $query->where('restaurant_id', '=', $restaurant_id);
                })
                ->when($cancelled_by, function($query) use ($cancelled_by){
                    $query->where('cancelled_by', '=', $cancelled_by);
                })
                ->paginate(50);

        return $orders;
    }

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function restaurantWiseOrders($restaurantId){
        $orders = Order::where('restaurant_id',$restaurantId)->where('is_deleted',0)->get();

        return $orders;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function userWiseOrders($userId){
        $orders = Order::with('restaurant')->where('user_id',$userId)->where('is_deleted',0)->get();

        return $orders;
    }

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function createOrder(array $params){
        try {

            $collection = collect($params);

            $restaurantId = $collection['restaurant_id'];

            $restaurants = Restaurant::where('id',$restaurantId)->get();
            $restaurant_device_token = $restaurants[0]->device_token;

            $amount = $collection['amount'];
            $discounted_amount = $collection['discounted_amount'];
            $delivery_charge = '20';
            $packing_price = '0';
            $tax_amount = $amount*5/100;
            $total_amount = $amount + $delivery_charge + $packing_price + $tax_amount - $discounted_amount;

            $order = new Order;
            $order->unique_id = 'FDX-'.rand(100000,999999);
            $order->restaurant_id = $collection['restaurant_id'];
            $order->user_id = $collection['user_id'];
            $order->delivery_boy_id = '0';
            $order->name = $collection['name'];
            $order->mobile = $collection['mobile'];
            $order->email = $collection['email'];
            $order->delivery_address = $collection['delivery_address'];
            $order->delivery_landmark = $collection['delivery_landmark'];
            $order->delivery_country = $collection['delivery_country'];
            $order->delivery_city = $collection['delivery_city'];
            $order->delivery_pin = $collection['delivery_pin'];
            $order->delivery_lat = $collection['delivery_lat'];
            $order->delivery_lng = $collection['delivery_lng'];
            $order->amount = $amount;
            $order->coupon_code = $collection['coupon_code'];
            $order->discounted_amount = $discounted_amount;
            $order->delivery_charge = $delivery_charge;
            $order->packing_price = $packing_price;
            $order->tax_amount = $tax_amount;
            $order->total_amount = $total_amount;
            $order->status = '1';
            $order->preparation_time = 0;
            $order->cancellation_reason = '';
            $order->transaction_id = $collection['transaction_id'];
            $order->payment_status = '1';
            
            $order->save();

            $orderId = $order->id;

            $userId = $collection['user_id'];
            $carts = Cart::where("user_id",$userId)->get();

            foreach($carts as $cart){
                $orderItem = new Orderitem;
                $orderItem->order_id = $orderId;
                $orderItem->product_name = $cart->product_name;
                $orderItem->product_image = $cart->product_image;
                $orderItem->price = $cart->price;
                $orderItem->quantity = $cart->quantity;

                $orderItem->save();
            }

            $carts = Cart::where('user_id',$userId)->get();

            foreach($carts as $cart) 
            {
                $cart->delete();
            }

            //Restaurant push notification
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $restaurant_device_token;
            $serverKey = 'AAAA22HBWio:APA91bFrQkxlWVP_itvN89T7dpJ0vJ89xLXa3BZjufxdAfYnNZ7yQw-qGhxXN7zPMtPSvZZp0Bzdw0GUDqL9HvRPt-NaDmalp42zfhY56Xs_9EpJyYLGz9ed1vjyVtOvojoeyX8AMncO';
            $title = "New Order Received";
            $body = "A new order has been received. Order Id : ".$order->unique_id;
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //Send the request
            $response = curl_exec($ch);
            //Close request
            if ($response === FALSE) {
                
            }

            return $order;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function restaurantWiseNewOrders($restaurantId){
        $orders = Order::with('restaurant')->where('restaurant_id',$restaurantId)->where('status','1')->where('is_deleted',0)->get();

        return $orders;
    }

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function restaurantWiseOngoingOrders($restaurantId){
        $orders = Order::with('restaurant')->where('restaurant_id',$restaurantId)->whereIn('status',array('2','3','4','5','6','7'))->where('is_deleted',0)->get();

        return $orders;
    }

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function restaurantWiseDeliveredOrders($restaurantId){
        $orders = Order::with('restaurant')->where('restaurant_id',$restaurantId)->where('status','8')->where('is_deleted',0)->get();

        return $orders;
    }

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function restaurantWiseCancelledOrders($restaurantId){
        $orders = Order::with('restaurant')->where('restaurant_id',$restaurantId)->where('status','10')->where('is_deleted',0)->get();

        return $orders;
    }

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function acceptOrder(array $params){
        try {
            $order = Order::find($params['id']);
            $collection = collect($params);

            $user_id = $order->user_id;
            $users = User::where('id',$user_id)->get();
            $user_device_token = $users[0]->device_token;

            $order->preparation_time = $collection['preparation_time'];
            $order->status = '2';

            $order->save();

            //User push notification
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $user_device_token;
            $serverKey = 'AAAAg79GpNs:APA91bGkLg3UY3Yrv4vdxZ61pjfAhWa0-kqMfLHz4CdlZG9O1l2fCPn7vvHpFIjDDHV7whAOBGV5xB2TsRYrvqglvwCDoxrpOQQwAm2d1GXlK4iKstpA5oByMd0PC4rS1rFW82T4EE8i';
            $title = "Order accepted";
            $body = "Restaurant has accepted your order. Order Id : ".$order->unique_id;
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //Send the request
            $response = curl_exec($ch);
            //echo $response;
            //Close request
            if ($response === FALSE) {
                
            }

            return $order;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function cancelOrder(array $params){
        try {
            $order = Order::find($params['id']);
            $collection = collect($params);

            $user_id = $order->user_id;
            $users = User::where('id',$user_id)->get();
            $user_device_token = $users[0]->device_token;

            $order->cancellation_reason = $collection['cancellation_reason'];
            $order->status = '10';
            $order->cancelled_by = '1';

            $order->save();

            //User push notification
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $user_device_token;
            $serverKey = 'AAAAg79GpNs:APA91bGkLg3UY3Yrv4vdxZ61pjfAhWa0-kqMfLHz4CdlZG9O1l2fCPn7vvHpFIjDDHV7whAOBGV5xB2TsRYrvqglvwCDoxrpOQQwAm2d1GXlK4iKstpA5oByMd0PC4rS1rFW82T4EE8i';
            $title = "Order rejected";
            $body = "Restaurant has rejected your order. Order Id : ".$order->unique_id;
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //Send the request
            $response = curl_exec($ch);
            //echo $response;
            //Close request
            if ($response === FALSE) {
                
            }

            return $order;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function getRestaurantOrderSummary($restaurantId){
        $new_orders = Order::where('status','1')->where('restaurant_id',$restaurantId)->get();
        $ongoing_orders = Order::where('status',array('2','3','4','5','6','7'))->where('restaurant_id',$restaurantId)->get();
        $delivered_orders = Order::where('status','8')->where('restaurant_id',$restaurantId)->get();
        $cancelled_orders = Order::where('status','10')->where('restaurant_id',$restaurantId)->get();

        $today = date("Y-m-d");
        $todays_orders = DB::select("select * from orders where restaurant_id='$restaurantId' and created_at like '$today%'");

        $todays_order_amount_result = DB::select("select ifnull(sum(amount),0) as order_amount from orders where restaurant_id='$restaurantId' and created_at like '$today%'");

        $todays_restaurant_commission_result = DB::select("select ifnull(sum(restaurant_commission),0) as order_restaurant_commission from orders where restaurant_id='$restaurantId' and created_at like '$today%'");

        $today_order_count = count($todays_orders);
        $todays_order_amount = $todays_order_amount_result[0]->order_amount;
        $todays_restaurant_commission = $todays_restaurant_commission_result[0]->order_restaurant_commission;

        $new_order_count = count($new_orders);
        $ongoing_order_count = count($ongoing_orders);
        $delivered_order_count = count($delivered_orders);
        $cancelled_order_count = count($cancelled_orders);

        $data = array(
            'todays_orders'=>$todays_orders,
            'new_order_count'=>$new_order_count,
            'ongoing_order_count'=>$ongoing_order_count,
            'delivered_order_count'=>$delivered_order_count,
            'cancelled_order_count'=>$cancelled_order_count,
            'today_order_count'=>$today_order_count,
            'todays_order_amount'=>$todays_order_amount,
            'todays_restaurant_commission'=>$todays_restaurant_commission  
        );

        return $data;
    }

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function assignDeliveryBoy(array $params){
        try {
            $order = Order::find($params['id']);
            $collection = collect($params);

            $delivery_boy_id = $params['delivery_boy_id'];
            $boys = DeliveryBoy::where('id',$delivery_boy_id)->get();
            $boy_name = $boys[0]->name;
            $boy_mobile = $boys[0]->mobile;

            $user_id = $order->user_id;
            $users = User::where('id',$user_id)->get();
            $user_device_token = $users[0]->device_token;

            $restaurant_id = $order->restaurant_id;
            $restaurants = Restaurant::where('id',$restaurant_id)->get();
            $restaurant_device_token = $restaurants[0]->device_token;

            $order->delivery_boy_id = $collection['delivery_boy_id'];
            $order->status = '3';

            $order->save();

            //User push notification
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $user_device_token;
            $serverKey = 'AAAAg79GpNs:APA91bGkLg3UY3Yrv4vdxZ61pjfAhWa0-kqMfLHz4CdlZG9O1l2fCPn7vvHpFIjDDHV7whAOBGV5xB2TsRYrvqglvwCDoxrpOQQwAm2d1GXlK4iKstpA5oByMd0PC4rS1rFW82T4EE8i';
            $title = "Delivery Boy Assigned";
            $body = "Delivery boy has been assigned for your order, id : ".$order->unique_id.". Your delivery partner is $boy_name($boy_mobile)";
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //Send the request
            $response = curl_exec($ch);
            //echo $response;
            //Close request
            if ($response === FALSE) {
                
            }

            //Restaurant push notification
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $restaurant_device_token;
            $serverKey = 'AAAA22HBWio:APA91bFrQkxlWVP_itvN89T7dpJ0vJ89xLXa3BZjufxdAfYnNZ7yQw-qGhxXN7zPMtPSvZZp0Bzdw0GUDqL9HvRPt-NaDmalp42zfhY56Xs_9EpJyYLGz9ed1vjyVtOvojoeyX8AMncO';
            $title = "Delivery Boy Assigned";
            $body = "$boy_name($boy_mobile) has been assigned for order id : ".$order->unique_id;
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //Send the request
            $response = curl_exec($ch);
            //Close request
            if ($response === FALSE) {
                
            }

            return $order;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param $boyId
     * @return Order|mixed
     */
    public function searchOrderForDeliveryBoys($boyId){
        $orders = Order::with('restaurant')->with('items')->where('delivery_boy_id',$boyId)->where('status','3')->get();

        return $orders;
    }

    /**
     * @param $boyId
     * @return Order|mixed
     */
    public function ongoingOrdersForDeliveryBoys($boyId){
        $orders = Order::with('restaurant')->with('items')->with('boy')->where('delivery_boy_id',$boyId)->whereIn('status',array('4','5','6','7'))->get();

        return $orders;
    }

    /**
     * @param $boyId
     * @return Order|mixed
     */
    public function deliveredOrdersForDeliveryBoys($boyId){
        $orders = Order::with('restaurant')->with('items')->where('delivery_boy_id',$boyId)->where('status','8')->get();

        return $orders;
    }

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function riderStarted(array $params){
        try {
            $order = Order::find($params['id']);
            $collection = collect($params);

            $delivery_boy_id = $params['delivery_boy_id'];
            $boys = DeliveryBoy::where('id',$delivery_boy_id)->get();
            $boy_name = $boys[0]->name;
            $boy_mobile = $boys[0]->mobile;

            $user_id = $order->user_id;
            $users = User::where('id',$user_id)->get();
            $user_device_token = $users[0]->device_token;

            $restaurant_id = $order->restaurant_id;
            $restaurants = Restaurant::where('id',$restaurant_id)->get();
            $restaurant_device_token = $restaurants[0]->device_token;

            $order->delivery_boy_id = $collection['delivery_boy_id'];
            $order->status = '5';

            $order->save();

            //User push notification
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $user_device_token;
            $serverKey = 'AAAAg79GpNs:APA91bGkLg3UY3Yrv4vdxZ61pjfAhWa0-kqMfLHz4CdlZG9O1l2fCPn7vvHpFIjDDHV7whAOBGV5xB2TsRYrvqglvwCDoxrpOQQwAm2d1GXlK4iKstpA5oByMd0PC4rS1rFW82T4EE8i';
            $title = "Rider started to pick order";
            $body = "Delivery boy has started towards restaurant to pick your order, id : ".$order->unique_id.". Your delivery partner is $boy_name($boy_mobile)";
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //Send the request
            $response = curl_exec($ch);
            //echo $response;
            //Close request
            if ($response === FALSE) {
                
            }

            //Restaurant push notification
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $restaurant_device_token;
            $serverKey = 'AAAA22HBWio:APA91bFrQkxlWVP_itvN89T7dpJ0vJ89xLXa3BZjufxdAfYnNZ7yQw-qGhxXN7zPMtPSvZZp0Bzdw0GUDqL9HvRPt-NaDmalp42zfhY56Xs_9EpJyYLGz9ed1vjyVtOvojoeyX8AMncO';
            $title = "Rider started to pick order";
            $body = "$boy_name($boy_mobile) has started to pick order id : ".$order->unique_id;
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //Send the request
            $response = curl_exec($ch);
            //echo $response;
            //Close request
            if ($response === FALSE) {
                
            }

            return $order;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function reachedRestaurant(array $params){
        try {
            $order = Order::find($params['id']);
            $collection = collect($params);

            $delivery_boy_id = $params['delivery_boy_id'];
            $boys = DeliveryBoy::where('id',$delivery_boy_id)->get();
            $boy_name = $boys[0]->name;
            $boy_mobile = $boys[0]->mobile;

            $user_id = $order->user_id;
            $users = User::where('id',$user_id)->get();
            $user_device_token = $users[0]->device_token;

            $restaurant_id = $order->restaurant_id;
            $restaurants = Restaurant::where('id',$restaurant_id)->get();
            $restaurant_device_token = $restaurants[0]->device_token;

            $order->delivery_boy_id = $collection['delivery_boy_id'];
            $order->status = '6';

            $order->save();

            //User push notification
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $user_device_token;
            $serverKey = 'AAAAg79GpNs:APA91bGkLg3UY3Yrv4vdxZ61pjfAhWa0-kqMfLHz4CdlZG9O1l2fCPn7vvHpFIjDDHV7whAOBGV5xB2TsRYrvqglvwCDoxrpOQQwAm2d1GXlK4iKstpA5oByMd0PC4rS1rFW82T4EE8i';
            $title = "Rider has reached the restaurant";
            $body = "Delivery boy has reached restaurant to pick your order, id : ".$order->unique_id.". Your delivery partner is $boy_name($boy_mobile)";
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //Send the request
            $response = curl_exec($ch);
            //echo $response;
            //Close request
            if ($response === FALSE) {
                
            }

            //Restaurant push notification
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $restaurant_device_token;
            $serverKey = 'AAAA22HBWio:APA91bFrQkxlWVP_itvN89T7dpJ0vJ89xLXa3BZjufxdAfYnNZ7yQw-qGhxXN7zPMtPSvZZp0Bzdw0GUDqL9HvRPt-NaDmalp42zfhY56Xs_9EpJyYLGz9ed1vjyVtOvojoeyX8AMncO';
            $title = "Rider has reached the restaurant";
            $body = "$boy_name($boy_mobile) has reached to pick order id : ".$order->unique_id;
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //Send the request
            $response = curl_exec($ch);
            //echo $response;
            //Close request
            if ($response === FALSE) {
                
            }

            return $order;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function orderPicked(array $params){
        try {
            $order = Order::find($params['id']);
            $collection = collect($params);

            $delivery_boy_id = $params['delivery_boy_id'];
            $boys = DeliveryBoy::where('id',$delivery_boy_id)->get();
            $boy_name = $boys[0]->name;
            $boy_mobile = $boys[0]->mobile;

            $user_id = $order->user_id;
            $users = User::where('id',$user_id)->get();
            $user_device_token = $users[0]->device_token;

            $order->delivery_boy_id = $collection['delivery_boy_id'];
            $order->status = '7';

            $order->save();

            //User push notification
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $user_device_token;
            $serverKey = 'AAAAg79GpNs:APA91bGkLg3UY3Yrv4vdxZ61pjfAhWa0-kqMfLHz4CdlZG9O1l2fCPn7vvHpFIjDDHV7whAOBGV5xB2TsRYrvqglvwCDoxrpOQQwAm2d1GXlK4iKstpA5oByMd0PC4rS1rFW82T4EE8i';
            $title = "Order has been picked";
            $body = "Delivery boy has picked your order from restaurant, id : ".$order->unique_id.". Your delivery partner is $boy_name($boy_mobile)";
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //Send the request
            $response = curl_exec($ch);
            //echo $response;
            //Close request
            if ($response === FALSE) {
                
            }

            return $order;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function orderDelivered(array $params){
        try {
            $order = Order::find($params['id']);
            $collection = collect($params);

            $delivery_boy_id = $params['delivery_boy_id'];
            $boys = DeliveryBoy::where('id',$delivery_boy_id)->get();
            $boy_name = $boys[0]->name;
            $boy_mobile = $boys[0]->mobile;

            $user_id = $order->user_id;
            $users = User::where('id',$user_id)->get();
            $user_device_token = $users[0]->device_token;

            $order->delivery_boy_id = $collection['delivery_boy_id'];
            $order->status = '8';

            $order->save();

            //User push notification
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $user_device_token;
            $serverKey = 'AAAAg79GpNs:APA91bGkLg3UY3Yrv4vdxZ61pjfAhWa0-kqMfLHz4CdlZG9O1l2fCPn7vvHpFIjDDHV7whAOBGV5xB2TsRYrvqglvwCDoxrpOQQwAm2d1GXlK4iKstpA5oByMd0PC4rS1rFW82T4EE8i';
            $title = "Order has been delivered";
            $body = "Rider has delivered your order, id : ".$order->unique_id.". Your delivery partner is $boy_name($boy_mobile)";
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //Send the request
            $response = curl_exec($ch);
            //echo $response;
            //Close request
            if ($response === FALSE) {
                
            }

            return $order;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function customerCancelOrder(array $params){
        try {
            $order = Order::find($params['id']);
            $collection = collect($params);

            $user_id = $order->user_id;
            $users = User::where('id',$user_id)->get();
            $user_device_token = $users[0]->device_token;

            $order->cancellation_reason = $collection['cancellation_reason'];
            $order->status = '10';
            $order->cancelled_by = '2';

            $order->save();

            return $order;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @return mixed
     */
    public function fetchSalesData($start_date,$end_date,$restaurant_id,$status){
        $orders = Order::with('restaurant')->whereIn('status',array('1','2','3','4','5','6','7','8','9','10'))->where('is_deleted',0)->orderBy('id','desc')
                ->when($start_date, function($query) use ($start_date){
                    $query->where('created_at', '>=', $start_date);
                })
                ->when($end_date, function($query) use ($end_date){
                    $query->where('created_at', '<=', $end_date);
                })
                ->when($restaurant_id, function($query) use ($restaurant_id){
                    $query->where('restaurant_id', '=', $restaurant_id);
                })
                 ->when($status, function($query) use ($status){
                    $query->where('status', '=', $status);
                })
                ->get();

        return $orders;
    }

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @param $status
     * @return mixed
     */
    public function onlineTransactions($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id){
        //$orders = Order::with('restaurant')->where('is_deleted',0)->get();

        $orders = Order::where('transaction_id','!=','')->orderBy('id','desc')
                ->when($order_id, function($query) use ($order_id){
                    $query->where('unique_id', '=', $order_id);
                })
                ->when($name, function($query) use ($name){
                    $query->where('name', 'like', '%' . $name .'%');
                })
                ->when($mobile, function($query) use ($mobile){
                    $query->where('mobile', 'like', '%' . $mobile .'%');
                })
                ->when($start_date, function($query) use ($start_date){
                    $query->where('created_at', '>=', $start_date);
                })
                ->when($end_date, function($query) use ($end_date){
                    $query->where('created_at', '<=', $end_date);
                })
                ->when($restaurant_id, function($query) use ($restaurant_id){
                    $query->where('restaurant_id', '=', $restaurant_id);
                })
                ->paginate(50);

        return $orders;
    }

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @param $status
     * @param $delivery_boy_id
     * @param $payment_mode
     * @return mixed
     */
    public function orderReports($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id,$status,$delivery_boy_id,$payment_mode){
        //$orders = Order::with('restaurant')->where('is_deleted',0)->get();

        $orders = Order::with('restaurant')->with('boy')->with('items')->orderBy('id','desc')
                ->when($order_id, function($query) use ($order_id){
                    $query->where('unique_id', '=', $order_id);
                })
                ->when($name, function($query) use ($name){
                    $query->where('name', 'like', '%' . $name .'%');
                })
                ->when($mobile, function($query) use ($mobile){
                    $query->where('mobile', 'like', '%' . $mobile .'%');
                })
                ->when($start_date, function($query) use ($start_date){
                    $query->where('created_at', '>=', $start_date);
                })
                ->when($end_date, function($query) use ($end_date){
                    $query->where('created_at', '<=', $end_date);
                })
                ->when($restaurant_id, function($query) use ($restaurant_id){
                    $query->where('restaurant_id', '=', $restaurant_id);
                })
                ->when($status, function($query) use ($status){
                    $query->where('status', '=', $status);
                })
                ->when($delivery_boy_id, function($query) use ($delivery_boy_id){
                    $query->where('delivery_boy_id', '=', $delivery_boy_id);
                })
                ->paginate(50);

        return $orders;
    }
}