<?php
namespace App\Repositories;

use App\Models\Restaurant;
use App\Models\Item;
use App\Models\Category;
use App\Models\RestaurantTransaction;
use App\Models\RestaurantReview;
use App\Models\RestaurantCoupon;
use App\Models\CuisineRestaurant;
use App\Models\RestaurantTiming;
use App\Models\Upsellitem;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\RestaurantContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use DB;
use URL;

/**
 * Class RestaurantRepository
 *
 * @package \App\Repositories
 */
class RestaurantRepository extends BaseRepository implements RestaurantContract
{
    use UploadAble;

    /**
     * RestaurantRepository constructor.
     * @param Restaurant $model
     */
    public function __construct(Restaurant $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listRestaurants(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findRestaurantById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Restaurant|mixed
     */
    public function createRestaurant(array $params)
    {
        try {

            $collection = collect($params);

            $restaurant = new Restaurant;
            $restaurant->name = $collection['name'];
            $restaurant->email = $collection['email'];
            $restaurant->password = md5($params['password']);
            $restaurant->mobile = $collection['mobile'];
            $restaurant->description = $collection['description'];
            $restaurant->address = $collection['address'];
            $restaurant->location = $collection['location'];
            $restaurant->lat = $collection['lat'];
            $restaurant->lng = $collection['lng'];
            $restaurant->start_time = $collection['start_time'];
            $restaurant->close_time = $collection['close_time'];
            $restaurant->is_pure_veg = $collection['is_pure_veg'];
            $restaurant->commission_rate = $collection['commission_rate'];
            $restaurant->estimated_delivery_time = $collection['estimated_delivery_time'];
            $restaurant->is_not_taking_orders = $collection['is_not_taking_orders'];
            $restaurant->is_pocket_friendly = 0;
            $restaurant->device_id = '';
            $restaurant->device_token = '';
            $restaurant->including_tax = $collection['including_tax'];
            $restaurant->tax_rate = $collection['tax_rate'];
            $restaurant->minimum_order_amount = $collection['minimum_order_amount'];
            $restaurant->order_preparation_time = $collection['order_preparation_time'];
            $restaurant->show_out_of_stock_products_in_app = $collection['show_out_of_stock_products_in_app'];

            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("restaurants/",$imageName);
            $uploadedImage = $imageName;
            $restaurant->image = URL::to('/').'/restaurants/'.$uploadedImage;

            $profile_image1 = $collection['logo'];
            $imageName1 = time().".".$profile_image1->getClientOriginalName();
            $profile_image1->move("restaurants/",$imageName1);
            $uploadedImage1 = $imageName1;
            $restaurant->logo = URL::to('/').'/restaurants/'.$uploadedImage1;
            
            $restaurant->save();

            $restaurant_id = $restaurant->id;

            if(count($params['cuisines'])>0){

                foreach($params['cuisines'] as $cuisine){
                    $cuisine_id = $cuisine;
                    $cuisineRestaurant = new CuisineRestaurant;
                    $cuisineRestaurant->restaurant_id = $restaurant->id;
                    $cuisineRestaurant->cuisine_id = $cuisine_id;
                    $cuisineRestaurant->save();
                }
            }

            if(count($params['days'])>0){
                //DB::delete("delete from restaurant_timings where resturant_id='$restaurant_id'");

                for($i=0;$i<count($params['days']);$i++){
                    $restaurantTiming = new RestaurantTiming;
                    $restaurantTiming->resturant_id = $restaurant_id;
                    $restaurantTiming->day = $params['days'][$i];
                    $restaurantTiming->start_time = $params['start_times'][$i];
                    $restaurantTiming->end_time = $params['end_times'][$i];
                    $restaurantTiming->save();
                }
            }

            return $restaurant;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateRestaurant(array $params)
    {
        $restaurant = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        // echo "<pre>";
        // print_r($params);
        // die();
        $restaurant_id = $params['id'];

        $restaurant->name = $collection['name'];
        $restaurant->email = $collection['email'];
        $restaurant->mobile = $collection['mobile'];
        $restaurant->description = $collection['description'];
        $restaurant->address = $collection['address'];
        $restaurant->location = $collection['location'];
        $restaurant->lat = $collection['lat'];
        $restaurant->lng = $collection['lng'];
        $restaurant->start_time = $collection['start_time'];
        $restaurant->close_time = $collection['close_time'];
        $restaurant->is_pure_veg = $collection['is_pure_veg'];
        $restaurant->commission_rate = $collection['commission_rate'];
        $restaurant->estimated_delivery_time = $collection['estimated_delivery_time'];
        $restaurant->is_not_taking_orders = $collection['is_not_taking_orders'];
        $restaurant->including_tax = $collection['including_tax'];
        $restaurant->tax_rate = $collection['tax_rate'];
        $restaurant->minimum_order_amount = $collection['minimum_order_amount'];
        $restaurant->order_preparation_time = $collection['order_preparation_time'];
        $restaurant->show_out_of_stock_products_in_app = $collection['show_out_of_stock_products_in_app'];

        if(isset($collection['image'])){
            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("restaurants/",$imageName);
            $uploadedImage = $imageName;
            $restaurant->image = URL::to('/').'/restaurants/'.$uploadedImage;
        }

        if(isset($collection['logo'])){
            $profile_image1 = $collection['logo'];
            $imageName1 = time().".".$profile_image1->getClientOriginalName();
            $profile_image1->move("restaurants/",$imageName1);
            $uploadedImage1 = $imageName1;
            $restaurant->logo = URL::to('/').'/restaurants/'.$uploadedImage1;
        }

        $restaurant->save();

        if(count($params['cuisines'])>0){
            DB::delete("delete from cuisine_restaurants where restaurant_id='$restaurant_id'");

            foreach($params['cuisines'] as $cuisine){
                $cuisine_id = $cuisine;
                $cuisineRestaurant = new CuisineRestaurant;
                $cuisineRestaurant->restaurant_id = $restaurant_id;
                $cuisineRestaurant->cuisine_id = $cuisine_id;
                $cuisineRestaurant->save();
            }
        }

        if(count($params['days'])>0){
            DB::delete("delete from restaurant_timings where resturant_id='$restaurant_id'");

            for($i=0;$i<count($params['days']);$i++){
                $restaurantTiming = new RestaurantTiming;
                $restaurantTiming->resturant_id = $restaurant_id;
                $restaurantTiming->day = $params['days'][$i];
                $restaurantTiming->start_time = $params['start_times'][$i];
                $restaurantTiming->end_time = $params['end_times'][$i];
                $restaurantTiming->save();
            }
        }

        return $restaurant;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteRestaurant($id)
    {
        $restaurant = $this->findOneOrFail($id);
        $restaurant->delete();
        return $restaurant;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateRestaurantStatus(array $params){
        $restaurant = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $restaurant->status = $collection['check_status'];
        $restaurant->save();

        return $restaurant;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsRestaurant($id){
        $restaurant =  Restaurant::where('id',$id)->get();

        return $restaurant;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function restaurantWiseItems($id){
        $items =  Item::where('restaurant_id',$id)->get();

        return $items;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function restaurantWiseActiveItems($id){
        $items =  Item::where('restaurant_id',$id)->where('status','1')->get();

        return $items;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findItemById(int $id)
    {
        try {
            return Item::find($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Item|mixed
     */
    public function createItem(array $params)
    {
        try {

            $collection = collect($params);

            $item = new Item;
            $item->restaurant_id = $params['restaurant_id'];
            $item->category_id = $collection['category_id'];
            $item->name = $collection['name'];
            $item->description = $collection['description'];
            $item->price = $params['price'];
            $item->offer_price = $collection['offer_price'];
            $item->is_veg = $collection['is_veg'];
            $item->is_cutlery_required = $collection['is_cutlery_required'];
            $item->min_item_for_cutlery = $collection['min_item_for_cutlery'];
            $item->in_stock = $collection['in_stock'];
            $item->is_special = $collection['is_special'];
            $item->is_add_on = $collection['is_add_on'];
            $item->add_on_item_id = $collection['add_on_item_id'];

            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("items/",$imageName);
            $uploadedImage = $imageName;
            $item->image = URL::to('/').'/items/'.$uploadedImage;

            $item->save();

            $item_id = $item->id;
            
            if(count($params['upsell_ids'])>0){
                //DB::delete("delete from restaurant_timings where resturant_id='$restaurant_id'");

                for($i=0;$i<count($params['upsell_ids']);$i++){
                    if($params['upsell_ids'][$i]!=''){
                        $upsellitem = new Upsellitem;
                        $upsellitem->item_id = $item_id;
                        $upsellitem->upsell_id = $params['upsell_ids'][$i];
                        $upsellitem->save();
                    }
                }
            }

            return $item;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Item|mixed
     */
    public function updateItem(array $params){
        $item = Item::find($params['id']);
        $collection = collect($params)->except('_token'); 

        $item->category_id = $collection['category_id'];
        $item->name = $collection['name'];
        $item->description = $collection['description'];
        $item->price = $params['price'];
        $item->offer_price = $collection['offer_price'];
        $item->is_veg = $collection['is_veg'];
        $item->is_cutlery_required = $collection['is_cutlery_required'];
        $item->min_item_for_cutlery = $collection['min_item_for_cutlery'];
        $item->in_stock = $collection['in_stock'];
        
        $item->save();

        return $item;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateItemStatus(array $params){
        $item = Item::find($params['id']);
        $collection = collect($params)->except('_token');
        $item->status = $collection['check_status'];
        $item->save();

        return $item;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteItem($id)
    {
        $item = Item::find($id);
        $item->delete();
        return $item;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function restaurantTransactions($id){
        $transactions =  RestaurantTransaction::where('restaurant_id',$id)->get();

        return $transactions;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function restaurantReviews($id){
        $reviews =  RestaurantReview::with('user')->where('restaurant_id',$id)->get();

        return $reviews;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function restaurantDetails($id){
        $restaurant =  Restaurant::where('id',$id)->get();

        $reviews =  RestaurantReview::with('user')->where('restaurant_id',$id)->get();

        $categories = Category::with('items')->where('restaurant_id',$id)->get();

        $coupons = RestaurantCoupon::where('restaurant_id',$id)->get();

        $data = array(
            'restaurant' => $restaurant[0],
            'categories' => $categories,
            'reviews'    => $reviews,
            'coupons'    => $coupons
        );

        return $data;
    }

    /**
     * @param array $params
     * @return Restaurant|mixed
     */
    public function restaurantLogin(array $params){
        try {

            $collection = collect($params);

            $mobile = $collection['mobile'];
            $password = md5($params['password']);
            
            $restaurants = Restaurant::where('mobile',$mobile)->where('password',$password)->get();

            return $restaurants;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param $cuisineId
     * @param double $lat
     * @param double $lng
     * @return Restaurant|mixed
     */
    public function cuisineWiseRestaurants($cuisineId,$lat,$lng){
        $restaurants = array();

        $restaurantDatas = DB::select("select * from restaurants where id in (select restaurant_id from cuisine_restaurants where cuisine_id='$cuisineId')");

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

            $restaurant_lat = $restaurant->lat;
            $restaurant_lng = $restaurant->lng;

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

            $rating_result = DB::select("SELECT ifnull(AVG(rating),0) as rating from restaurant_reviews where restaurant_id = $restaurant_id");

            $rating = $rating_result[0]->rating;
            $restaurant->rating = $rating;

            array_push($restaurants, $restaurant);
        }

        return $restaurants;
    }

    /**
     * @param double $lat
     * @param double $lng
     * @return mixed
     */
    public function getTrendingRestaurantList($lat,$lng){
        $restaurants = array();

        $restaurantDatas =  Restaurant::where('is_trending','1')->get();

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

            $restaurant_lat = $restaurant->lat;
            $restaurant_lng = $restaurant->lng;

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

            $rating_result = DB::select("SELECT ifnull(AVG(rating),0) as rating from restaurant_reviews where restaurant_id = $restaurant_id");

            $rating = $rating_result[0]->rating;
            $restaurant->rating = $rating;

            array_push($restaurants, $restaurant);
        }

        return $restaurants;
    }

    /**
     * @param double $lat
     * @param double $lng
     * @return mixed
     */
    public function getPocketFriendlyRestaurantList($lat,$lng){
        $restaurants = array();

        $restaurantDatas =  Restaurant::where('is_pocket_friendly','1')->where('status','1')->get();

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

            $restaurant_lat = $restaurant->lat;
            $restaurant_lng = $restaurant->lng;

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

            $rating_result = DB::select("SELECT ifnull(AVG(rating),0) as rating from restaurant_reviews where restaurant_id = $restaurant_id");

            $rating = $rating_result[0]->rating;
            $restaurant->rating = $rating;

            array_push($restaurants, $restaurant);
        }

        return $restaurants;
    }

    /**
     * @param array $params
     * @return RestaurantReview|mixed
     */
    public function addRestaurantReview(array $params){
        try {
            $collection = collect($params);

            $restaurantReview = new RestaurantReview;
            $restaurantReview->restaurant_id = $params['restaurant_id'];
            $restaurantReview->user_id = $collection['user_id'];
            $restaurantReview->order_ref_id = $collection['order_ref_id'];
            $restaurantReview->rating = $collection['rating'];
            $restaurantReview->review = $params['review'];
            
            $restaurantReview->save();

            return $restaurantReview;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param $keyword
     * @return Restaurant|mixed
     */
    public function searchRestaurants($keyword){
        $restaurants = DB::select("select * from restaurants where name like '%$keyword%' and status=1");

        return $restaurants;
    }

    /**
     * @return mixed
     */
    public function getActiveRestaurants(){
        $restaurants =  Restaurant::where('status','1')->get();

        return $restaurants;
    }

    /**
     * @param $name
     * @param $mobile
     * @param $address
     * @param $status
     * @return mixed
     */
    public function searchRestaurantData($name,$mobile,$address,$status){
        $restaurants = Restaurant::orderBy('id','desc')
                ->when($name, function($query) use ($name){
                    $query->where('name', 'like', '%' . $name .'%');
                })
                ->when($mobile, function($query) use ($mobile){
                    $query->where('mobile', 'like', '%' . $mobile .'%');
                })
                ->when($address, function($query) use ($address){
                    $query->where('address', 'like', '%' . $address .'%');
                })
                ->when($status, function($query) use ($status){
                    $query->where('status', '=', $status);
                })
                ->paginate(50);

        return $restaurants;
    }
}