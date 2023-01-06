<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\RestaurantContract;
use App\Contracts\OrderContract;
use App\Contracts\CategoryContract;
use App\Contracts\RestaurantCouponContract;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Http\Controllers\BaseController;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\RestaurantDeliveryConfig;
use App\Models\RestaurantTiming;
use App\Models\Item;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Cart;
use App\Models\RestaurantTransaction;
use Illuminate\Support\Facades\Validator;
use DB;

class RestaurantManagementController extends BaseController
{
    /**
     * @var RestaurantContract
     */
    protected $restaurantRepository;
    /**
     * @var OrderContract
     */
    protected $orderRepository;
    /**
     * @var CategoryContract
     */
    protected $categoryRepository;
    /**
     * @var RestaurantCouponContract
     */
    protected $restaurantCouponRepository;


    /**
     * RestaurantManagementController constructor.
     * @param RestaurantContract $restaurantRepository
     * @param OrderContract $orderRepository
     * @param CategoryContract $categoryRepository
     * @param RestaurantCouponContract $restaurantCouponRepository
     */
    public function __construct(RestaurantContract $restaurantRepository,OrderContract $orderRepository, CategoryContract $categoryRepository, RestaurantCouponContract $restaurantCouponRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->orderRepository = $orderRepository;
        $this->categoryRepository = $categoryRepository;
        $this->restaurantCouponRepository = $restaurantCouponRepository;
    }

    /**
     * This method is for restaurant login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $params = $request->except('_token');

        $restaurants = $this->restaurantRepository->restaurantLogin($params);

        if(count($restaurants)>0){
            $error = false;
            $message = 'Success';
            $restaurantData = $restaurants[0];

            return response()->json(compact('error','message','restaurantData'));
        }else{
            $error = true;
            $message = 'You have entered a wrong mobile no and password. Please try with the correct one';

            return response()->json(compact('error','message'));
        }
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
     * This method is for fetching restaurant wise new orders
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function newOrders($id){
        $orders = $this->orderRepository->restaurantWiseNewOrders($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','orders'));
    }

    /**
     * This method is for fetching restaurant wise delivered orders
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deliveredOrders($id){
        $orders = $this->orderRepository->restaurantWiseDeliveredOrders($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','orders'));
    }

    /**
     * This method is for fetching restaurant wise cancelled orders
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelledOrders($id){
        $orders = $this->orderRepository->restaurantWiseCancelledOrders($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','orders'));
    }

    /**
     * This method is for fetching order details
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderDetails($id){
        $orderData = $this->orderRepository->getDetails($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','orderData'));
    }

    /**
     * This method is for fetching restaurant wise ongoing orders
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function ongoingOrders($id){
        $orders = $this->orderRepository->restaurantWiseOngoingOrders($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','orders'));
    }

    /**
     * This method is for restaurant accept order
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptOrder(Request $request){
        $params = $request->except('_token');

        $order = $this->orderRepository->acceptOrder($params);

        $error = false;
        $message = 'Success';
        $orderData = $order;

        return response()->json(compact('error','message','orderData'));
    }

    /**
     * This method is for restaurant cancel order
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelOrder(Request $request){
        $params = $request->except('_token');

        $order = $this->orderRepository->cancelOrder($params);

        $error = false;
        $message = 'Success';
        $orderData = $order;

        return response()->json(compact('error','message','orderData'));
    }

    /**
     * This method is for fetching restaurant dashboard data
     * @param $restaurantId
     * @return \Illuminate\Http\JsonResponse
     */
    public function dashboardData($restaurantId){
        $data = $this->orderRepository->getRestaurantOrderSummary($restaurantId);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','data'));
    }

    /**
     * This method is for fetching restaurant wise notification list
     * @param $restaurantId
     * @return \Illuminate\Http\JsonResponse
     */
    public function notificationList($restaurantId){
        $notifications = Notification::where('restaurant_id',$restaurantId)->get();
        
        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','notifications'));
    }

    /**
     * This method is for fetching restaurant wise details and items
     * @param $restaurantId
     * @return \Illuminate\Http\JsonResponse
     */
    public function restaurantWiseItems($restaurantId){
        $categories = array();
        $categoryDatas = Category::where('restaurant_id',$restaurantId)->get();

        foreach($categoryDatas as $category){
            $category_id = $category->id;
            $items = array();
            $itemDatas = Item::where('category_id',$category_id)->where('status','1')->get();

            foreach($itemDatas as $item){
                $item_id = $item->id;
                
                $item->quantity = 0;

                array_push($items,$item);
            }

            $category->items = $items;

            array_push($categories,$category);
        }

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','categories'));
    }

    /**
     * This method is for fetching restaurant wise details and items
     * @param $restaurantId
     * @return \Illuminate\Http\JsonResponse
     */
    public function restaurantWiseCategories($restaurantId){
        //$categories = Category::where('restaurant_id',$restaurantId)->get();
        $categories = array();
        $categoryDatas = Category::where('restaurant_id',$restaurantId)->get();

        foreach($categoryDatas as $category){
            $category_id = $category->id;
            $items = array();
            $itemDatas = Item::where('category_id',$category_id)->where('status','1')->get();

            foreach($itemDatas as $item){
                $item_id = $item->id;
                
                $item->quantity = 0;

                array_push($items,$item);
            }

            $category->items = $items;

            array_push($categories,$category);
        }

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','categories'));
    }

    /**
     * This method is for adding item
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addItem(Request $request)
    {
        $this->validate($request, [
            'category_id'      =>  'required',
            'name'     =>  'required',
            'price'     =>  'required',
            'offer_price'      =>  'required',
            'is_veg'     =>  'required',
            'is_cutlery_required'     =>  'required',
            'in_stock'      =>  'required',
        ]);

        $params = $request->except('_token');
        
        $item = new Item;
        $item->restaurant_id = $params['restaurant_id'];
        $item->category_id = $params['category_id'];
        $item->name = $params['name'];
        $item->description = $params['description'];
        $item->price = $params['price'];
        $item->offer_price = $params['offer_price'];
        $item->is_veg = $params['is_veg'];
        $item->is_cutlery_required = $params['is_cutlery_required'];
        $item->min_item_for_cutlery = $params['min_item_for_cutlery'];
        $item->in_stock = $params['in_stock'];
        $item->image = $params['image'];
        $item->is_special = $params['is_special'];
        $item->is_add_on = $params['is_add_on'];
        $item->add_on_item_id = $params['add_on_item_id'];

        $item->save();

         if (!$item) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','item'));
        }
    }

    /**
     * This method is for adding item
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateItem(Request $request)
    {
        $this->validate($request, [
            'category_id'      =>  'required',
            'name'     =>  'required',
            'price'     =>  'required',
            'offer_price'      =>  'required',
            'is_veg'     =>  'required',
            'is_cutlery_required'     =>  'required',
            'in_stock'      =>  'required',
        ]);

        $params = $request->except('_token');
        
        $item_id = $params['item_id'];
        $item = Item::find($item_id);

        $item->category_id = $params['category_id'];
        $item->name = $params['name'];
        $item->description = $params['description'];
        $item->price = $params['price'];
        $item->offer_price = $params['offer_price'];
        $item->is_veg = $params['is_veg'];
        $item->is_cutlery_required = $params['is_cutlery_required'];
        $item->min_item_for_cutlery = $params['min_item_for_cutlery'];
        $item->in_stock = $params['in_stock'];
        $item->image = $params['image'];

        $item->save();

         if (!$item) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','item'));
        }
    }

    /**
     * This method is for deleting an item
     * @param $itemId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteItem($itemId){
        $item = Item::find($itemId);
        $item->delete();

        $error = false;
        $message = 'This item has been deleted successfully';

        return response()->json(compact('error','message'));
    }

    /**
     * This method is for searching user with mobile no
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findUserWithMobile(Request $request){
        $mobile = $request->mobile;

        $users = User::where('mobile',$mobile)->get();
        $user = $users[0];
        $addresses = UserAddress::where('user_id',$user->id)->get();

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','user','addresses'));
    }

    /**
     * This method is for getting item list to create order
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function itemListForOrder(Request $request){
        $restaurant_id = $request->restaurant_id;
        $user_id = $request->user_id;

        $restaurants = Restaurant::where('id',$restaurant_id)->get();
        $restaurant = $restaurants[0];

        $categories = array();
        $categoryDatas = Category::where('restaurant_id',$restaurant_id)->get();

        foreach($categoryDatas as $category){
            $category_id = $category->id;
            $items = array();
            $itemDatas = Item::where('category_id',$category_id)->where('status','1')->get();

            foreach($itemDatas as $item){
                $item_id = $item->id;
                
                $cartCheck = Cart::where('user_id',$user_id)->where('product_id',$item_id)->get();

                if(count($cartCheck)>0){
                    $item->quantity = $cartCheck[0]->quantity;
                }else{
                    $item->quantity = 0;
                }

                array_push($items,$item);
            }

            $category->items = $items;

            array_push($categories,$category);
        }

        $restaurantData = array(
            'restaurant' => $restaurant,
            'categories' => $categories,
        );

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','restaurantData'));
    }

    /**
     * This method is for creating an order for restaurant
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrder(Request $request){
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
     * This method is for adding restaurant offer
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOffer(Request $request){
        $validator = Validator::make($request->all(), [
            'restaurant_id'     =>  'required',
            'title'     =>  'required',
            'code'     =>  'required',
            'type'      =>  'required',
            'rate'     =>  'required',
            'maximum_offer_rate'     =>  'required',
            'start_date'     =>  'required',
            'end_date'     =>  'required',
            'maximum_time_of_use'     =>  'required',
            'maximum_time_user_can_use'     =>  'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $params = $request->except('_token');

        $offer = $this->restaurantCouponRepository->createCoupon($params);

        if (!$offer) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','offer'));
        }
    }

    /**
     * This method is for updating restaurant offer
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOffer(Request $request){
        $validator = Validator::make($request->all(), [
            'id'     =>  'required',
            'title'     =>  'required',
            'code'     =>  'required',
            'type'      =>  'required',
            'rate'     =>  'required',
            'maximum_offer_rate'     =>  'required',
            'start_date'     =>  'required',
            'end_date'     =>  'required',
            'maximum_time_of_use'     =>  'required',
            'maximum_time_user_can_use'     =>  'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $params = $request->except('_token');

        $offer = $this->restaurantCouponRepository->updateCoupon($params);

        if (!$offer) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','offer'));
        }
    }

    /**
     * This method is to delete restaurant offer
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOffer($id){
        $offer = $this->restaurantCouponRepository->deleteCoupon($id);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message'));
    }

    /**
     * This method is for fetching restaurant offer list
     * @param $restaurantId
     * @return \Illuminate\Http\JsonResponse
     */
    public function offerList($restaurantId){
        $offers = $this->restaurantCouponRepository->activeCouponsByRestaurant($restaurantId);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','offers'));
    }

    /**
     * This method is for updating restaurant data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRestaurantProfile(Request $request){
        $this->validate($request, [
            'restaurant_id' => 'required',
            'name'      =>  'required',
            'mobile'     =>  'required',
        ]);

        $params = $request->except('_token');

        $restaurant_id = $params['restaurant_id'];
        $restaurant = Restaurant::find($restaurant_id);

        $restaurant->name = $params['name'];
        $restaurant->email = $params['email'];
        $restaurant->mobile = $params['mobile'];
        $restaurant->image = $params['image'];
        $restaurant->logo = $params['logo'];
        $restaurant->description = $params['description'];
        $restaurant->address = $params['address'];
        $restaurant->location = $params['location'];
        $restaurant->lat = $params['lat'];
        $restaurant->lng = $params['lng'];
        $restaurant->start_time = $params['start_time'];
        $restaurant->close_time = $params['close_time'];
        $restaurant->is_pure_veg = $params['is_pure_veg'];
        $restaurant->commission_rate = $params['commission_rate'];
        $restaurant->estimated_delivery_time = $params['estimated_delivery_time'];
        $restaurant->is_not_taking_orders = $params['is_not_taking_orders'];

        $restaurant->save();

        if (!$restaurant) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','restaurant'));
        }
    }

    /**
     * This method is for updating restaurant data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordUpdate(Request $request){
        $this->validate($request, [
            'restaurant_id' => 'required',
            'password'      =>  'required',
        ]);

        $params = $request->except('_token');

        $restaurant_id = $params['restaurant_id'];
        $restaurant = Restaurant::find($restaurant_id);

        $restaurant->password = md5($params['password']);

        $restaurant->save();

        if (!$restaurant) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Password has been updated successfully';

            return response()->json(compact('error','message','restaurant'));
        }
    }

    /**
     * This method is for updating restaurant settings data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRestaurantSettingsData(Request $request){
        $this->validate($request, [
            'restaurant_id' => 'required',
        ]);

        $params = $request->except('_token');

        $restaurant_id = $params['restaurant_id'];
        $restaurant = Restaurant::find($restaurant_id);

        $restaurant->including_tax = $params['including_tax'];
        $restaurant->tax_rate = $params['tax_rate'];
        $restaurant->minimum_order_amount = $params['minimum_order_amount'];
        $restaurant->order_preparation_time = $params['order_preparation_time'];
        $restaurant->show_out_of_stock_products_in_app = $params['show_out_of_stock_products_in_app'];

        $restaurant->save();

        if (!$restaurant) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','restaurant'));
        }
    }


    /**
     * This method is for fetching restaurant wise categories
     * @param $restaurantId
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoryList($restaurantId){
        $categories = $this->categoryRepository->restaurantWiseCategories($restaurantId);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','categories'));
    }

    public function addCategory(Request $request){
        $this->validate($request, [
            'restaurant_id' => 'required',
            'title'      =>  'required',
        ]);

        $params = $request->except('_token');

        $category = new Category;
        $category->title = $params['title'];
        $category->restaurant_id = $params['restaurant_id'];
        $category->description = $params['description'];
        $category->image = '';
        $category->status = '1';

        $category->save();

        if (!$category) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','category'));
        }
    }

    public function updateCategory(Request $request){
        $this->validate($request, [
            'id' => 'required',
            'title'      =>  'required',
        ]);

        $params = $request->except('_token');

        $category = Category::find($params['id']);
        $category->title = $params['title'];
        $category->description = $params['description'];
        $category->image = '';
        $category->status = '1';

        $category->save();

        if (!$category) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','category'));
        }
    }

    /**
     * This method is for deleting an category
     * @param $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCategory($categoryId){
        $category = Category::find($categoryId);
        $category->delete();

        $error = false;
        $message = 'This category has been deleted successfully';

        return response()->json(compact('error','message'));
    }

    public function categoryWiseItems($category_id){
        $items = array();
        $itemDatas = Item::where('category_id',$category_id)->where('status','1')->get();

        foreach($itemDatas as $item){
            $item_id = $item->id;
            
            $item->quantity = 0;

            array_push($items,$item);
        }

        $error = false;
        $message = 'This category has been deleted successfully';

        return response()->json(compact('error','message','items'));
    }

    public function setupDeliveryConfig(Request $request){
        $this->validate($request, [
            'restaurant_id' => 'required',
        ]);

        $params = $request->except('_token');

        $restaurant_id = $params['restaurant_id'];
        $delivery_types = $params['delivery_types'];

        $delivery_types_arr = explode("*",$delivery_types);

        if(count($delivery_types_arr)>0){
            DB::delete("delete from restaurant_delivery_configs where restaurant_id='$restaurant_id'");

            foreach($delivery_types_arr as $delivery_type){
                $restaurantDeliveryConfig = new RestaurantDeliveryConfig;
                $restaurantDeliveryConfig->restaurant_id = $restaurant_id;
                $restaurantDeliveryConfig->delivery_type = $delivery_type;
                $restaurantDeliveryConfig->save();
            }
        }

        $error = false;
        $message = 'Data has been updated successfully';

        return response()->json(compact('error','message'));
    }

    public function restaurantWiseDeliveryConfig($restaurantId){
        $data = RestaurantDeliveryConfig::where('restaurant_id',$restaurantId)->get();

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','data'));
    }

    public function restaurantWiseTimings($restaurantId){
        $data = RestaurantTiming::where('resturant_id',$restaurantId)->get();

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','data'));
    }

    public function setupTiming(Request $request){
        $this->validate($request, [
            'restaurant_id' => 'required',
        ]);

        $params = $request->except('_token');

        $restaurant_id = $params['restaurant_id'];
        $days = $params['days'];
        $start_times = $params['start_times'];
        $end_times = $params['end_times'];

        $days_arr = explode("*",$days);
        $start_times_arr = explode("*",$start_times);
        $end_times_arr = explode("*",$end_times);

        if(count($days_arr)>0){
            DB::delete("delete from restaurant_timings where resturant_id='$restaurant_id'");

            for($i=0;$i<count($days_arr);$i++){
                $restaurantTiming = new RestaurantTiming;
                $restaurantTiming->resturant_id = $restaurant_id;
                $restaurantTiming->day = $days_arr[$i];
                $restaurantTiming->start_time = $start_times_arr[$i];
                $restaurantTiming->end_time = $end_times_arr[$i];
                $restaurantTiming->save();
            }
        }

        $error = false;
        $message = 'Data has been updated successfully';

        $data = RestaurantTiming::where('resturant_id',$restaurant_id)->get();

        return response()->json(compact('error','message','data'));
    }

    public function restaurantPayments($restaurantId){
        $data = RestaurantTransaction::where('restaurant_id',$restaurantId)->where('type','1')->get();

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','data'));
    }

    public function monthlyOrderReport($restaurantId){
        $aug_start_date = '2022-08-01';
        $aug_end_date = '2022-08-31';
        $sep_start_date = '2022-09-01';
        $sep_end_date = '2022-09-31';
        $oct_start_date = '2022-10-01';
        $oct_end_date = '2022-10-31';
        $nov_start_date = '2022-11-01';
        $nov_end_date = '2022-11-31';
        $dec_start_date = '2022-12-01';
        $dec_end_date = '2022-12-31';
        $jan_start_date = date("Y").'-01-01';
        $jan_end_date = date("Y").'-01-31';

        $aug_result = DB::select("SELECT count(id) as total_value FROM `orders` WHERE created_at >= '$aug_start_date' and created_at<='$aug_end_date' and restaurant_id='$restaurantId'");
        $sep_result = DB::select("SELECT count(id) as total_value FROM `orders` WHERE created_at >= '$sep_start_date' and created_at<='$sep_end_date' and restaurant_id='$restaurantId'");
        $oct_result = DB::select("SELECT count(id) as total_value FROM `orders` WHERE created_at >= '$oct_start_date' and created_at<='$oct_end_date' and restaurant_id='$restaurantId'");
        $nov_result = DB::select("SELECT count(id) as total_value FROM `orders` WHERE created_at >= '$nov_start_date' and created_at<='$nov_end_date' and restaurant_id='$restaurantId'");
        $dec_result = DB::select("SELECT count(id) as total_value FROM `orders` WHERE created_at >= '$dec_start_date' and created_at<='$dec_end_date' and restaurant_id='$restaurantId'");
        $jan_result = DB::select("SELECT count(id) as total_value FROM `orders` WHERE created_at >= '$jan_start_date' and created_at<='$jan_end_date' and restaurant_id='$restaurantId'");

        if($aug_result[0]->total_value!=''){
          $aug = $aug_result[0]->total_value;
        }else{
          $aug = 0;
        }
        if($sep_result[0]->total_value!=''){
          $sep = $sep_result[0]->total_value;
        }else{
          $sep = 0;
        }
        if($oct_result[0]->total_value!=''){
          $oct = $oct_result[0]->total_value;
        }else{
          $oct = 0;
        }
        if($nov_result[0]->total_value!=''){
          $nov = $nov_result[0]->total_value;
        }else{
          $nov = 0;
        }
        if($dec_result[0]->total_value!=''){
          $dec = $dec_result[0]->total_value;
        }else{
          $dec = 0;
        }
        if($jan_result[0]->total_value!=''){
          $jan = $jan_result[0]->total_value;
        }else{
          $jan = 0;
        }

        $data = array();

        $aug_data = array(
            'month'=>'Aug 2022',
            'value'=>$aug
        );

        $sep_data = array(
            'month'=>'Sep 2022',
            'value'=>$sep
        );

        $oct_data = array(
            'month'=>'Oct 2022',
            'value'=>$oct
        );

        $nov_data = array(
            'month'=>'Nov 2022',
            'value'=>$nov
        );

        $dec_data = array(
            'month'=>'Dec 2022',
            'value'=>$dec
        );

        $jan_data = array(
            'month'=>'Jan 2023',
            'value'=>$jan
        );

        array_push($data,$aug_data);
        array_push($data,$sep_data);
        array_push($data,$oct_data);
        array_push($data,$nov_data);
        array_push($data,$dec_data);
        array_push($data,$jan_data);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','data'));
    }

    public function monthlySalesReport($restaurantId){
        $aug_start_date = '2022-08-01';
        $aug_end_date = '2022-08-31';
        $sep_start_date = '2022-09-01';
        $sep_end_date = '2022-09-31';
        $oct_start_date = '2022-10-01';
        $oct_end_date = '2022-10-31';
        $nov_start_date = '2022-11-01';
        $nov_end_date = '2022-11-31';
        $dec_start_date = '2022-12-01';
        $dec_end_date = '2022-12-31';
        $jan_start_date = date("Y").'-01-01';
        $jan_end_date = date("Y").'-01-31';

        $aug_result = DB::select("SELECT sum(amount) as total_value FROM `orders` WHERE created_at >= '$aug_start_date' and created_at<='$aug_end_date' and restaurant_id='$restaurantId'");
        $sep_result = DB::select("SELECT sum(amount) as total_value FROM `orders` WHERE created_at >= '$sep_start_date' and created_at<='$sep_end_date' and restaurant_id='$restaurantId'");
        $oct_result = DB::select("SELECT sum(amount) as total_value FROM `orders` WHERE created_at >= '$oct_start_date' and created_at<='$oct_end_date' and restaurant_id='$restaurantId'");
        $nov_result = DB::select("SELECT sum(amount) as total_value FROM `orders` WHERE created_at >= '$nov_start_date' and created_at<='$nov_end_date' and restaurant_id='$restaurantId'");
        $dec_result = DB::select("SELECT sum(amount) as total_value FROM `orders` WHERE created_at >= '$dec_start_date' and created_at<='$dec_end_date' and restaurant_id='$restaurantId'");
        $jan_result = DB::select("SELECT sum(amount) as total_value FROM `orders` WHERE created_at >= '$jan_start_date' and created_at<='$jan_end_date' and restaurant_id='$restaurantId'");

        if($aug_result[0]->total_value!=''){
          $aug = $aug_result[0]->total_value;
        }else{
          $aug = 0;
        }
        if($sep_result[0]->total_value!=''){
          $sep = $sep_result[0]->total_value;
        }else{
          $sep = 0;
        }
        if($oct_result[0]->total_value!=''){
          $oct = $oct_result[0]->total_value;
        }else{
          $oct = 0;
        }
        if($nov_result[0]->total_value!=''){
          $nov = $nov_result[0]->total_value;
        }else{
          $nov = 0;
        }
        if($dec_result[0]->total_value!=''){
          $dec = $dec_result[0]->total_value;
        }else{
          $dec = 0;
        }
        if($jan_result[0]->total_value!=''){
          $jan = $jan_result[0]->total_value;
        }else{
          $jan = 0;
        }

        $data = array();

        $aug_data = array(
            'month'=>'Aug 2022',
            'value'=>$aug
        );

        $sep_data = array(
            'month'=>'Sep 2022',
            'value'=>$sep
        );

        $oct_data = array(
            'month'=>'Oct 2022',
            'value'=>$oct
        );

        $nov_data = array(
            'month'=>'Nov 2022',
            'value'=>$nov
        );

        $dec_data = array(
            'month'=>'Dec 2022',
            'value'=>$dec
        );

        $jan_data = array(
            'month'=>'Jan 2023',
            'value'=>$jan
        );

        array_push($data,$aug_data);
        array_push($data,$sep_data);
        array_push($data,$oct_data);
        array_push($data,$nov_data);
        array_push($data,$dec_data);
        array_push($data,$jan_data);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','data'));
    }
}