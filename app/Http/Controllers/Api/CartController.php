<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\CartContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use DB;

class CartController extends BaseController
{
    /**
     * @var CartContract
     */
    protected $cartRepository;

    /**
     * AddressController constructor.
     * @param CartContract $cartRepository
     */
    public function __construct(CartContract $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * This method is for fetching cart list user wise
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function list($userId){
        $carts = $this->cartRepository->userWiseCartList($userId);

        $amount = 0;

        if(count($carts)>0){
            foreach ($carts as $cart) {
                if($cart->add_on_id>0 && $cart->add_on_id2>0){
                    $amount += (($cart->price*$cart->quantity) + ($cart->add_on_price*$cart->add_on_quantity) + ($cart->add_on_price2*$cart->add_on_quantity2));
                }else if($cart->add_on_id>0 && $cart->add_on_id2==0){
                    $amount += (($cart->price*$cart->quantity) + ($cart->add_on_price*$cart->add_on_quantity));
                }else{
                    $amount += ($cart->price*$cart->quantity);
                }
                
            }
        }else{
            $amount = 0;
        }

        $upsell_items = array();

        $upsell_items_data = DB::select("select * from items where id in (select upsell_id from upsellitems where item_id in (select product_id from carts where user_id='$userId'))");

        foreach($upsell_items_data as $item){
            $item_id = $item->id;
            
            $cartCheck = Cart::where('user_id',$userId)->where('product_id',$item_id)->get();

            if(count($cartCheck)>0){
                $item->quantity = $cartCheck[0]->quantity;
            }else{
                $item->quantity = 0;
            }

            array_push($upsell_items,$item);
        }

        $upsell_items = $upsell_items_data;

        $cart_amount = $amount;
        $discounted_amount = '0';
        $delivery_charge = '20';
        $packing_price = '0';
        $tax_amount = $amount*5/100;
        $total_amount = $amount + $delivery_charge + $packing_price + $tax_amount - $discounted_amount;

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','carts','upsell_items','cart_amount','discounted_amount','delivery_charge','packing_price','tax_amount','total_amount'));
    }

    /**
     * This method is for adding cart data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id'     =>  'required',
            'device_id'     =>  'required',
            'product_name'     =>  'required',
            'price'     =>  'required',
            'quantity'     =>  'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $params = $request->except('_token');

        $cart = $this->cartRepository->createCart($params);

        if (!$cart) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','cart'));
        }
    }

    /**
     * This method is for updating cart data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'product_name'     =>  'required',
            'product_image'      =>  'required',
            'price'     =>  'required',
            'quantity'     =>  'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $params = $request->except('_token');

        $cart = $this->cartRepository->updateCart($params);

        if (!$cart) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','cart'));
        }
    }

    /**
     * This method is to delete cart data
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){
        
        $this->cartRepository->deleteCart($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message'));
    }

    /**
     * This method is to clear cart data
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function clear($userId){
        $this->cartRepository->clearCart($userId);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message'));
    }
}