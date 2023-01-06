<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\RestaurantContract;
use App\Contracts\CategoryContract;
use App\Contracts\OrderContract;
use App\Contracts\RestaurantCouponContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Item;
use App\Models\Cart;
use App\Models\RestaurantReview;
use DB;

class RestaurantController extends BaseController
{
    /**
     * @var RestaurantContract
     */
    protected $restaurantRepository;
    /**
     * @var CategoryContract
     */
    protected $categoryRepository;
    /**
     * @var RestaurantCouponContract
     */
    protected $restaurantCouponRepository;


    /**
     * RestaurantController constructor.
     * @param RestaurantContract >restaurantRepository
     */
    public function __construct(RestaurantContract $restaurantRepository, CategoryContract $categoryRepository, RestaurantCouponContract $restaurantCouponRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->categoryRepository = $categoryRepository;
        $this->restaurantCouponRepository = $restaurantCouponRepository;
    }

    /**
     * This method is for fetching restaurant list
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(){
        $lat = (isset($_GET['lat']) && $_GET['lat']!='')?$_GET['lat']:'0';
        $lng = (isset($_GET['lng']) && $_GET['lng']!='')?$_GET['lng']:'0';

        $restaurants = array();

        //$restaurantDatas = $this->restaurantRepository->listRestaurants();
        $restaurantDatas = DB::select("select * from restaurants where status=1");

        foreach($restaurantDatas as $restaurant){
            $restaurant_id = $restaurant->id;
            $restaurant_lat = $restaurant->lat;
            $restaurant_lng = $restaurant->lng;

            $items = DB::select("select * from items where restaurant_id='$restaurant_id' and is_special=1 limit 5");

            $items_array = array();

            foreach ($items as $item) {
                array_push($items_array, $item->name);
            }

            $restaurant->special_items_string = implode(', ', $items_array);

            $restaurant->special_items = $items;

            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat . "," . $lng . "&destinations=" . $restaurant_lat . "," . $restaurant_lng . "&mode=driving&key=AIzaSyDyQoXQLzc8IJhqDKOgCcvQKU-euh7xTX0";
                
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
    
            //echo $response;
            curl_close($ch);
            $response_a = json_decode($response, true);
            // print_r($response_a);
            // die();
    
            if(count($response_a['rows'])>0){
                $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    
                $total_time = $response_a['rows'][0]['elements'][0]['duration']['value'];
        
                $time = $total_time / 60;
            }else{
                $dist = '0 km';
            }
            
            $restaurant->distance = $dist;
            array_push($restaurants, $restaurant);
        }

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','restaurants'));
    }

    /**
     * This method is for fetching restaurant details
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function details($id){
        $restaurantData = $this->restaurantRepository->restaurantDetails($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','restaurantData'));
    }

    /**
     * This method is for fetching restaurant list cuisine wise
     * @param $cuisineId
     * @return \Illuminate\Http\JsonResponse
     */
    public function cuisineWiseRestaurants($cuisineId){
        $lat = (isset($_GET['lat']) && $_GET['lat']!='')?$_GET['lat']:'0';
        $lng = (isset($_GET['lng']) && $_GET['lng']!='')?$_GET['lng']:'0';

        $restaurants = $this->restaurantRepository->cuisineWiseRestaurants($cuisineId,$lat,$lng);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','restaurants'));
    }

    /**
     * This method is for adding restaurant review
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addReview(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id'     =>  'required',
            'restaurant_id'     =>  'required',
            'order_ref_id'     =>  'required',
            'rating'     =>  'required',
            'review'     =>  'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $params = $request->except('_token');

        $review = $this->restaurantRepository->addRestaurantReview($params);

        if (!$review) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','review'));
        }
    }

    public function singleData(Request $request){
        $lat = (isset($_GET['lat']) && $_GET['lat']!='')?$_GET['lat']:'0';
        $lng = (isset($_GET['lng']) && $_GET['lng']!='')?$_GET['lng']:'0';
        $is_veg = (isset($_GET['is_veg']) && $_GET['is_veg']!='')?$_GET['is_veg']:'';

        $restaurant_id = $request->restaurant_id;
        $user_id = $request->user_id;

        $restaurants = Restaurant::where('id',$restaurant_id)->get();
        $restaurant = $restaurants[0];

        $categories = array();
        $categoryDatas = Category::where('restaurant_id',$restaurant_id)->get();

        foreach($categoryDatas as $category){
            $category_id = $category->id;
            $items = array();

            if($is_veg==''){
                $itemDatas = Item::where('category_id',$category_id)->where('status','1')->get();
            }else if($is_veg=='1'){
                $itemDatas = Item::where('category_id',$category_id)->where('is_veg','1')->where('status','1')->get();
            }else if($is_veg=='0'){
                $itemDatas = Item::where('category_id',$category_id)->where('is_veg','0')->where('status','1')->get();
            }
            
            foreach($itemDatas as $item){
                $item_id = $item->id;
                
                $cartCheck = Cart::where('user_id',$user_id)->where('product_id',$item_id)->get();

                if(count($cartCheck)>0){
                    $item->quantity = $cartCheck[0]->quantity;
                }else{
                    $item->quantity = 0;
                }

                $addonItems = Item::where('add_on_item_id',$item_id)->get();

                $item->addonItems = $addonItems;

                array_push($items,$item);


            }

            $category->items = $items;

            if(count($items)>0){
                array_push($categories,$category);
            }
        }

        $reviews = RestaurantReview::where('restaurant_id',$restaurant_id)->get();

        $coupons = $this->restaurantCouponRepository->activeCouponsByRestaurant($restaurant_id);

        $restaurant_id = $restaurant->id;
        $restaurant_lat = $restaurant->lat;
        $restaurant_lng = $restaurant->lng;

        $special_items_datas = DB::select("select * from items where restaurant_id='$restaurant_id' and is_special=1 limit 5");

        $special_items = array();

        foreach($special_items_datas as $item){
            $item_id = $item->id;
            
            $cartCheck = Cart::where('user_id',$user_id)->where('product_id',$item_id)->get();

            if(count($cartCheck)>0){
                $item->quantity = $cartCheck[0]->quantity;
            }else{
                $item->quantity = 0;
            }

            array_push($special_items,$item);
        }

        $restaurant->special_items = $special_items;

        $restaurant_lat = $restaurant->lat;
        $restaurant_lng = $restaurant->lng;

        // $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat . "," . $lng . "&destinations=" . $restaurant_lat . "," . $restaurant_lng . "&mode=driving&key=AIzaSyDyQoXQLzc8IJhqDKOgCcvQKU-euh7xTX0";
            
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // $response = curl_exec($ch);

        // //echo $response;
        // curl_close($ch);
        // $response_a = json_decode($response, true);
        // // print_r($response_a);
        // // die();

        // if(count($response_a['rows'])>0){
        //     $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];

        //     $total_time = $response_a['rows'][0]['elements'][0]['duration']['value'];
    
        //     $time = $total_time / 60;
        // }else{
        //     $dist = 0;
        // }

        $dist = 0;
        
        $restaurant->distance = $dist;

        $rating_result = DB::select("SELECT ifnull(AVG(rating),0) as rating from restaurant_reviews where restaurant_id = $restaurant_id");

        $rating = $rating_result[0]->rating;
        $restaurant->rating = $rating;

        $favoriteResult = DB::select("select * from user_favourite_restaurants where user_id='$user_id' and restaurant_id='$restaurant_id'");

        if(count($favoriteResult)>0){
            $restaurant->is_favorite = 1;
        }else{
            $restaurant->is_favorite = 0;
        }

        $restaurantData = array(
            'restaurant' => $restaurant,
            'categories' => $categories,
            'reviews' => $reviews,
            'coupons' => $coupons
        );

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','restaurantData'));
    }
}