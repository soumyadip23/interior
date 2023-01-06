<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\DeliveryBoyContract;
use App\Contracts\OrderContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

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
}