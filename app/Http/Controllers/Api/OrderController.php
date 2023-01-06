<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\OrderContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController
{
    /**
     * @var OrderContract
     */
    protected $orderRepository;


    /**
     * PageController constructor.
     * @param OrderContract $orderRepository
     */
    public function __construct(OrderContract $orderRepository)
    {
        $this->orderRepository = $orderRepository;
        
    }

    /**
     * This method is for fetching order list
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function list($userId){
        $orders = $this->orderRepository->userWiseOrders($userId);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','orders'));
    }

    /**
     * This method is for fetching order details
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function details($id){
        $orderData = $this->orderRepository->getDetails($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','orderData'));
    }

    /**
     * This method is for creating an order
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id'     =>  'required',
            'restaurant_id'     =>  'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $params = $request->except('_token');

        $order = $this->orderRepository->createOrder($params);

        if (!$order) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','order'));
        }
    }

    /**
     * This method is for restaurant cancel order
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelOrder(Request $request){
        $params = $request->except('_token');

        $order = $this->orderRepository->customerCancelOrder($params);

        $error = false;
        $message = 'Success';
        $orderData = $order;

        return response()->json(compact('error','message','orderData'));
    }
}