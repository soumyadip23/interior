<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\RestaurantContract;
use App\Contracts\CategoryContract;
use App\Contracts\OrderContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Restaurant;

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
     * @var OrderContract
     */
    protected $orderRepository;


    /**
     * RestaurantController constructor.
     * @param RestaurantContract >restaurantRepository
     */
    public function __construct(RestaurantContract $restaurantRepository, CategoryContract $categoryRepository, OrderContract $orderRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
        $mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
        $address = (isset($_GET['address']) && $_GET['address']!='')?$_GET['address']:'';
        $status = (isset($_GET['status']) && $_GET['status']!='')?$_GET['status']:'';

        $restaurants = $this->restaurantRepository->searchRestaurantData($name,$mobile,$address,$status);

        $this->setPageTitle('Restaurant', 'List of all restaurants');
        return view('admin.restaurant.index', compact('restaurants'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Restaurant', 'Create Restaurant');
        return view('admin.restaurant.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required',
            'mobile'     =>  'required',
            'email'     =>  'required',
            'password'      =>  'required',
            'address'     =>  'required',
            'location'     =>  'required',
            'lat'      =>  'required',
            'lng'     =>  'required',
            'start_time'     =>  'required',
            'close_time'      =>  'required',
            'is_pure_veg'     =>  'required',
            'commission_rate'     =>  'required',
            'estimated_delivery_time'     =>  'required',
            'is_not_taking_orders'     =>  'required',
        ]);

        $params = $request->except('_token');
        
        $restaurant = $this->restaurantRepository->createRestaurant($params);

        if (!$restaurant) {
            return $this->responseRedirectBack('Error occurred while creating restaurant.', 'error', true, true);
        }
        return $this->responseRedirect('admin.restaurant.index', 'Restaurant has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetRestaurant = $this->restaurantRepository->findRestaurantById($id);
        
        $this->setPageTitle('Restaurant', 'Edit Restaurant : '.$targetRestaurant->name);
        return view('admin.restaurant.edit', compact('targetRestaurant'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required',
            'mobile'     =>  'required',
            'email'     =>  'required',
            'address'     =>  'required',
            'location'     =>  'required',
            'lat'      =>  'required',
            'lng'     =>  'required',
            'start_time'     =>  'required',
            'close_time'      =>  'required',
            'is_pure_veg'     =>  'required',
            'commission_rate'     =>  'required',
            'estimated_delivery_time'     =>  'required',
            'is_not_taking_orders'     =>  'required',
        ]);


        $params = $request->except('_token');

        $restaurant = $this->restaurantRepository->updateRestaurant($params);

        if (!$restaurant) {
            return $this->responseRedirectBack('Error occurred while updating restaurant.', 'error', true, true);
        }
        return $this->responseRedirectBack('Restaurant has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $restaurant = $this->restaurantRepository->deleteRestaurant($id);

        if (!$restaurant) {
            return $this->responseRedirectBack('Error occurred while deleting restaurant.', 'error', true, true);
        }
        return $this->responseRedirect('admin.restaurant.index', 'Restaurant has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $restaurant = $this->restaurantRepository->updateRestaurantStatus($params);

        if ($restaurant) {
            return response()->json(array('message'=>'Restaurant status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $restaurants = $this->restaurantRepository->detailsRestaurant($id);
        $restaurant = $restaurants[0];
        
        $this->setPageTitle('Restaurant', 'Restaurant Details : '.$restaurant->name);
        return view('admin.restaurant.details', compact('restaurant'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function items($id)
    {
        $restaurants = $this->restaurantRepository->detailsRestaurant($id);
        $restaurant = $restaurants[0];

        $items = $this->restaurantRepository->restaurantWiseItems($id);
        
        $this->setPageTitle('Restaurant', 'Item List : '.$restaurant->name);
        return view('admin.restaurant.items', compact('items','restaurant'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemcreate($id){
        $categories = $this->categoryRepository->restaurantWiseCategories($id);

        $items = $this->restaurantRepository->restaurantWiseActiveItems($id);

        $this->setPageTitle('Items', 'Add Item');
        return view('admin.restaurant.itemcreate', compact('categories','id','items'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function itemstore(Request $request)
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
        
        $item = $this->restaurantRepository->createItem($params);

        if (!$item) {
            return $this->responseRedirectBack('Error occurred while creating item.', 'error', true, true);
        }
        return $this->responseRedirectBack('Item has been created successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemedit($id){
        $targetItem = $this->restaurantRepository->findItemById($id);

        $categories = $this->categoryRepository->listCategories();
        
        $this->setPageTitle('Item', 'Edit Item : '.$targetItem->name);
        return view('admin.restaurant.itemedit', compact('targetItem','categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function itemupdate(Request $request)
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

        $item = $this->restaurantRepository->updateItem($params);

        if (!$item) {
            return $this->responseRedirectBack('Error occurred while updating item.', 'error', true, true);
        }
        return $this->responseRedirectBack('Item has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function itemdelete($id,$itemId){
        $item = $this->restaurantRepository->deleteItem($itemId);

        if (!$item) {
            return $this->responseRedirectBack('Error occurred while deleting item.', 'error', true, true);
        }
        return $this->responseRedirectBack('Item has been deleted successfully.', 'error', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateItemStatus(Request $request){
        $params = $request->except('_token');

        $item = $this->restaurantRepository->updateItemStatus($params);

        if ($item) {
            return response()->json(array('message'=>'Item status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function transactions($id)
    {
        $restaurants = $this->restaurantRepository->detailsRestaurant($id);
        $restaurant = $restaurants[0];

        $transactions = $this->restaurantRepository->restaurantTransactions($id);
        
        $this->setPageTitle('Restaurant', 'Transaction log : '.$restaurant->name);
        return view('admin.restaurant.transactions', compact('transactions','restaurant'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders($id)
    {
        $restaurants = $this->restaurantRepository->detailsRestaurant($id);
        $restaurant = $restaurants[0];

        $orders = $this->orderRepository->restaurantWiseOrders($id);
        
        $this->setPageTitle('Restaurant', 'Order list : '.$restaurant->name);
        return view('admin.restaurant.orders', compact('orders','restaurant'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reviews($id)
    {
        $restaurants = $this->restaurantRepository->detailsRestaurant($id);
        $restaurant = $restaurants[0];

        $reviews = $this->restaurantRepository->restaurantReviews($id);
        
        $this->setPageTitle('Restaurant', 'All reviews : '.$restaurant->name);
        return view('admin.restaurant.reviews', compact('reviews','restaurant'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function change_password($id)
    {
        $targetRestaurant = $this->restaurantRepository->findRestaurantById($id);
        
        $this->setPageTitle('Restaurant', 'Change Password Restaurant : '.$targetRestaurant->name);
        return view('admin.restaurant.change_password', compact('targetRestaurant'));
    }

    public function updatePassword(Request $request){
        $params = $request->except('_token');

        $restaurant_id = $params['id'];
        $restaurant = Restaurant::find($restaurant_id);

        $restaurant->password = md5($params['password']);

        $restaurant->save();

        if (!$restaurant) {
            return $this->responseRedirectBack('Error occurred while updating password for restaurant.', 'error', true, true);
        }
        return $this->responseRedirect('admin.restaurant.index', 'Restaurant password has been updated successfully' ,'success',false, false);
    }
}
