<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\CouponContract;
use App\Contracts\CousineContract;
use App\Contracts\BannerContract;
use App\Contracts\RestaurantContract;
use App\Models\Notification;
use App\Models\Suggestion;
use App\Models\UserFavouriteRestaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use DB;

class CommonController extends BaseController
{
    /**
     * @var CouponContract
     */
    protected $couponRepository;
    /**
     * @var CousineContract
     */
    protected $cuisineRepository;
    /**
     * @var BannerContract
     */
    protected $bannerRepository;
    /**
     * @var RestaurantContract
     */
    protected $restaurantRepository;

    /**
     * AddressController constructor.
     * @param CouponContract $couponRepository
     */
    public function __construct(CouponContract $couponRepository, CousineContract $cuisineRepository, BannerContract $bannerRepository, RestaurantContract $restaurantRepository)
    {
        $this->couponRepository = $couponRepository;
        $this->cuisineRepository = $cuisineRepository;
        $this->bannerRepository = $bannerRepository;
        $this->restaurantRepository = $restaurantRepository;
    }

    /**
     * This method is for fetching coupon list
     * @return \Illuminate\Http\JsonResponse
     */
    public function couponList(){
        $coupons = $this->couponRepository->activeCoupons();

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','coupons'));
    }

    /**
     * This method is for fetching cuisine list
     * @return \Illuminate\Http\JsonResponse
     */
    public function cuisineList(){
        $cuisines = $this->cuisineRepository->getCuisineList();

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','cuisines'));
    }

    public function fetchHomeScreenData(){
        $lat = (isset($_GET['lat']) && $_GET['lat']!='')?$_GET['lat']:'0';
        $lng = (isset($_GET['lng']) && $_GET['lng']!='')?$_GET['lng']:'0';

        $banners = $this->bannerRepository->listBanners();
        $cuisines = $this->cuisineRepository->getTrendingCuisineList();
        $restaurants = $this->restaurantRepository->getTrendingRestaurantList($lat,$lng);
        $pocket_frinedly_restaurants = $this->restaurantRepository->getPocketFriendlyRestaurantList($lat,$lng);

        $home_restaurants = array();

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
            array_push($home_restaurants, $restaurant);
        }

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','banners','cuisines','restaurants','pocket_frinedly_restaurants','home_restaurants'));
    }

    public function serachData(Request $request){
        $keyword = $request->keyword;

        $restaurants = $this->restaurantRepository->searchRestaurants($keyword);

        $cuisines = $this->cuisineRepository->searchCuisines($keyword);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','cuisines','restaurants'));
    }

    public function notificationList($userId){
        $notifications = Notification::where('user_id',$userId)->get();
        
        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','notifications'));
    }

    public function addSuggestion(Request $request){
        $user_id = $request->user_id;
        $type = $request->type;
        $name = $request->name;

        $suggestion = new Suggestion;
        $suggestion->user_id = $user_id;
        $suggestion->type = $type;
        $suggestion->name = $name;
        $suggestion->save();
        
        $error = false;
        $message = 'Your suggestion has been submitted successfully';

        return response()->json(compact('error','message'));
    }

    public function addFavouriteRestaurant(Request $request){
        $user_id = $request->user_id;
        $restaurant_id = $request->restaurant_id;

        $userFavouriteRestaurant = new UserFavouriteRestaurant;
        $userFavouriteRestaurant->user_id = $user_id;
        $userFavouriteRestaurant->restaurant_id = $restaurant_id;
        $userFavouriteRestaurant->save();
        
        $error = false;
        $message = 'Favourite restaurant has been saved successfully';

        return response()->json(compact('error','message'));
    }

    public function removeFavouriteRestaurant(Request $request){
        $user_id = $request->user_id;
        $restaurant_id = $request->restaurant_id;

        $data = UserFavouriteRestaurant::where('user_id', $user_id)->where('restaurant_id', $restaurant_id)->delete();
        
        $error = false;
        $message = 'Favourite restaurant has been removed successfully';

        return response()->json(compact('error','message'));
    }

    public function getFavouriteRestaurant($userId){
        $lat = (isset($_GET['lat']) && $_GET['lat']!='')?$_GET['lat']:'0';
        $lng = (isset($_GET['lng']) && $_GET['lng']!='')?$_GET['lng']:'0';

        $restaurants = array();

        $restaurantDatas = DB::select("select * from restaurants where id in (select restaurant_id from user_favourite_restaurants where user_id='$userId')");

        foreach($restaurantDatas as $restaurant){
            $restaurant_id = $restaurant->id;
            $restaurant_lat = $restaurant->lat;
            $restaurant_lng = $restaurant->lng;

            $items = DB::select("select * from items where restaurant_id='$restaurant_id' and is_special=1 limit 3");

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
                $dist = 0;
            }
            
            $restaurant->distance = $dist;
            array_push($restaurants, $restaurant);
        }

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','restaurants'));
    }
}