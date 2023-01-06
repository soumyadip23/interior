<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\UserContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class AddressController extends BaseController
{
    /**
     * @var UserContract
     */
    protected $userRepository;

    /**
     * AddressController constructor.
     * @param UserContract $userRepository
     */
    public function __construct(UserContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * This method is for fetching address list
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addressList($id){
        $addresses = $this->userRepository->adddressList($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','addresses'));
    }

    /**
     * This method is for adding address
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAddress(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id'     =>  'required',
            'address'     =>  'required',
            'location'     =>  'required',
            'lat'      =>  'required',
            'lng'     =>  'required',
            'country'     =>  'required',
            'state'     =>  'required',
            'city'     =>  'required',
            'pin'     =>  'required',
            'tag'     =>  'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $params = $request->except('_token');

        $address = $this->userRepository->addAddress($params);

        if (!$address) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','address'));
        }
    }

    /**
     * This method is for updating address
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAddress(Request $request){
        $validator = Validator::make($request->all(), [
            'id'     =>  'required',
            'address'     =>  'required',
            'location'     =>  'required',
            'lat'      =>  'required',
            'lng'     =>  'required',
            'country'     =>  'required',
            'state'     =>  'required',
            'city'     =>  'required',
            'pin'     =>  'required',
            'tag'     =>  'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $params = $request->except('_token');

        $address = $this->userRepository->updateAddress($params);

        if (!$address) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','address'));
        }
    }

    /**
     * This method is to delete address
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAddress($id){
        $addresses = $this->userRepository->deleteAddress($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message'));
    }
}