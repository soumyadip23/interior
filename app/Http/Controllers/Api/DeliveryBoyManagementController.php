<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\DeliveryBoyContract;
use App\Contracts\OrderContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\DeliveryBoy;
use App\Models\SosNotification;
use App\Models\BoyNotification;
use App\Models\DeliveryBoyEarning;

class DeliveryBoyManagementController extends BaseController
{
    /**
     * @var DeliveryBoyContract
     */
    protected $deliveryBoyRepository;
    /**
     * @var OrderContract
     */
    protected $orderRepository;


    /**
     * DeliveryBoyManagementController constructor.
     * @param DeliveryBoyContract >deliveryBoyRepository
     * @param OrderContract $orderRepository
     */
    public function __construct(DeliveryBoyContract $deliveryBoyRepository,OrderContract $orderRepository)
    {
        $this->deliveryBoyRepository = $deliveryBoyRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * This method is for delivery boy login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $params = $request->except('_token');

        $boys = $this->deliveryBoyRepository->boyLogin($params);

        if(count($boys)>0){
            $error = false;
            $message = 'Success';
            $boyData = $boys[0];

            return response()->json(compact('error','message','boyData'));
        }else{
            $error = true;
            $message = 'You have entered a wrong mobile no and password. Please try with the correct one';

            return response()->json(compact('error','message'));
        }
    }

    /**
     * This method is for delivery boy register
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $params = $request->except('_token');

        $boy = new DeliveryBoy;
        $boy->name = $params['name'];
        $boy->email = $params['email'];
        $boy->password = md5($params['password']);
        $boy->mobile = $params['mobile'];
        $boy->country = $params['country'];
        $boy->city = $params['city'];
        $boy->address = $params['address'];
        $boy->pin = $params['pin'];
        $boy->vehicle_type = '1';
        $boy->gender = 'Male';
        //$boy->date_of_birth = '0000-00-00';
        $boy->status = 0;
        $boy->is_deleted = 0;

        $boy->save();

        if($boy){
            $error = false;
            $message = 'Success';
            $boyData = $boy;

            return response()->json(compact('error','message'));
        }else{
            $error = true;
            $message = 'You have entered a wrong mobile no and password. Please try with the correct one';

            return response()->json(compact('error','message'));
        }
    }

    /**
     * This method is for fetching delivery boy details
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function details($id){
        $boyData = $this->deliveryBoyRepository->detailsDeliveryBoy($id)[0];

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','boyData'));
    }

    /**
     * This method is for fetching new orders for delivery boy
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchNewOrders($id){
        $orders = $this->orderRepository->searchOrderForDeliveryBoys($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','orders'));
    }

    /**
     * This method is for fetching ongoing orders for delivery boy
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function ongoingOrders($id){
        $orders = $this->orderRepository->ongoingOrdersForDeliveryBoys($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','orders'));
    }

    /**
     * This method is for fetching ongoing orders for delivery boy
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deliveredOrders($id){
        $orders = $this->orderRepository->deliveredOrdersForDeliveryBoys($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','orders'));
    }

    /**
     * This method is for rider start
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function riderStarted(Request $request){
        $params = $request->except('_token');

        $order = $this->orderRepository->riderStarted($params);

        $error = false;
        $message = 'Success';
        $orderData = $order;

        return response()->json(compact('error','message','orderData'));
    }

    /**
     * This method is for rider reached restaurant
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reachedRestaurant(Request $request){
        $params = $request->except('_token');

        $order = $this->orderRepository->reachedRestaurant($params);

        $error = false;
        $message = 'Success';
        $orderData = $order;

        return response()->json(compact('error','message','orderData'));
    }

    /**
     * This method is for rider picked the order
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderPicked(Request $request){
        $params = $request->except('_token');

        $order = $this->orderRepository->orderPicked($params);

        $error = false;
        $message = 'Success';
        $orderData = $order;

        return response()->json(compact('error','message','orderData'));
    }

    /**
     * This method is for rider delivered the order
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderDelivered(Request $request){
        $params = $request->except('_token');

        $order = $this->orderRepository->orderDelivered($params);

        $error = false;
        $message = 'Success';
        $orderData = $order;

        return response()->json(compact('error','message','orderData'));
    }

    /**
     * This method is for adding SOS notification
     * @param $boyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function sosNotify($boyId){
        $boys = DeliveryBoy::where('id',$boyId)->get();
        $boy = $boys[0];
        $msg = $boy->name." is in an emergency situation. Please contact at ".$boy->mobile;

        $sosNotification = new SosNotification;
        $sosNotification->delivery_boy_id = $boy->id;
        $sosNotification->notification = $msg;
        $sosNotification->save();

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message'));
    }

    /**
     * This method is for fetching notifications
     * @param $boyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function notifications($boyId){
        $notifications = BoyNotification::where('delivery_boy_id',$boyId)->get();

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','notifications'));
    }

    /**
     * This method is for set rider availibility
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAvailibility(Request $request){
        $params = $request->except('_token');

        $boy_id = $params['boy_id'];
        $is_available = $params['is_available'];

        $deliveryBoy = DeliveryBoy::find($boy_id);

        $deliveryBoy->is_available = $is_available;
        $deliveryBoy->save();

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message'));
    }

    /**
     * This method is for fetching earnings
     * @param $boyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function earnings($boyId){
        $earnings = DeliveryBoyEarning::where('delivery_boy_id',$boyId)->get();

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','earnings'));
    }

    /**
     * This method is for set rider profile update
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request){
        $params = $request->except('_token');

        $boy_id = $params['boy_id'];
        $name = $params['name'];
        $email = $params['email'];
        $country = $params['country'];
        $city = $params['city'];
        $address = $params['address'];
        $pin = $params['pin'];
        $vehicle_type = $params['vehicle_type'];
        $vehicle_no = $params['vehicle_no'];
        $model_name = $params['model_name'];
        $driving_license = $params['driving_license'];
        $image = $params['image'];

        $deliveryBoy = DeliveryBoy::find($boy_id);

        $deliveryBoy->name = $name;
        $deliveryBoy->email = $email;
        $deliveryBoy->country = $country;
        $deliveryBoy->city = $city;
        $deliveryBoy->address = $address;
        $deliveryBoy->pin = $pin;
        $deliveryBoy->vehicle_type = $vehicle_type;
        $deliveryBoy->vehicle_no = $vehicle_no;
        $deliveryBoy->model_name = $model_name;
        $deliveryBoy->driving_license = $driving_license;
        $deliveryBoy->image = $image;
        $deliveryBoy->save();

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message'));
    }

    /**
     * This method is for set rider password update
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request){
        $params = $request->except('_token');

        $boy_id = $params['boy_id'];

        $deliveryBoy = DeliveryBoy::find($boy_id);

        $deliveryBoy->password = md5($params['password']);
        $deliveryBoy->save();

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message'));
    }
}