<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use App\Contracts\UserContract;
use App\Contracts\OrderContract;
use App\Contracts\CartContract;
use App\Contracts\RestaurantContract;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Item;
use App\Models\Cart;
use App\Models\UserAddress;
use Auth;
use Session;
use Illuminate\Support\Facades\Validator;
use App\Contracts\CategoryContract;
use DB;
use App\Models\VendorCategories;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VendorsImport;
use App\Exports\VendorsExport;

class UserManagementController extends BaseController
{

    protected $UserRepository;
    /**
     * @var OrderContract
     */
    protected $orderRepository;
    /**
     * @var RestaurantContract
     */
    protected $restaurantRepository;
    /**
     * @var CartContract
     */
    protected $cartRepository;

    protected $categoryRepository;

    /**
     * UserManagementController constructor.
     * @param UserRepository $UserRepository
     * @param RestaurantContract >restaurantRepository
     * @param OrderContract $orderRepository
     */

    public function __construct(UserContract $UserRepository,OrderContract $orderRepository,CategoryContract $categoryRepository, RestaurantContract $restaurantRepository, CartContract $cartRepository)
    {
        $this->UserRepository = $UserRepository;
        $this->orderRepository = $orderRepository;
        $this->restaurantRepository = $restaurantRepository;
        $this->cartRepository = $cartRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * List all the users
     */
    public function index()
    {
        $name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
        $mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
        $email = (isset($_GET['email']) && $_GET['email']!='')?$_GET['email']:'';
        $location = (isset($_GET['location']) && $_GET['location']!='')?$_GET['location']:'';
        $cat_id = (isset($_GET['cat_id']) && $_GET['cat_id']!='')?$_GET['cat_id']:'';

    	$users = $this->UserRepository->searchUserData($name,$mobile,$email,$location,$cat_id);


        
        $categories = Category::where('parent_id', '=', 0)->get();
    	$this->setPageTitle('vendors', 'List of all vendors');
    	return view('admin.users.index',compact('users','categories','location','cat_id'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::where('parent_id', '=', 0)->get();
        $this->setPageTitle('Vendor', 'Create Vendor');
        //dd($categories);
        return view('admin.users.create', compact('categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:50',
            'email'     =>  'required',
            'mobile'    =>  'required|numeric'
        ]);

        $params = $request->except('_token');
        
        $user = $this->UserRepository->createUser($params);

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while creating user.', 'error', true, true);
        }
        return $this->responseRedirect('admin.users.index', 'New user has been added successfully' ,'success',false, false);
    }

    /**
     * Update user with approve or block status
     * @param Request $request 
     */
    public function updateUser(Request $request)
    {
        $response = $this->UserRepository->blockUser($request->user_id,$request->is_block);

        if($response){
            return response()->json(array('message'=>'Successfully updated'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $user = $this->UserRepository->updateUserStatus($params);

        if ($user) {
            return response()->json(array('message'=>'User status successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetUser = $this->UserRepository->getUserDetails($id)[0];


        $categories = Category::where('parent_id', '=', 0)->get();


        $user_categories =  VendorCategories::select('cat_id')
                           ->where('vendor_id', '=', $id)
                           ->get()->toArray();

        $cat_array = [];

        foreach($user_categories as $u_cat){
            $cat_array[] = $u_cat['cat_id'];
        }
       //dd($cat_array);

        $this->setPageTitle('Vendor', 'Edit Vendor : '.$targetUser->name);
        return view('admin.users.edit', compact('targetUser','categories','cat_array'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
         $this->validate($request, [
            'name'      =>  'required|max:50',
            'email'     =>  'required',
        ]);

        $params = $request->except('_token');

        $user = $this->UserRepository->updateUser($params);

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while updating user.', 'error', true, true);
        }
        return $this->responseRedirectBack('User has been updated successfully' ,'success',false, false);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $user = $this->UserRepository->deleteUser($id);

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while deleting user.', 'error', true, true);
        }
        return $this->responseRedirect('admin.users.index', 'User deleted successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $users = $this->UserRepository->getUserDetails($id);
        $user = $users[0];
        
        $this->setPageTitle('Vendor', 'Vendor Details : '.$user->name);
        return view('admin.users.details', compact('user'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders($id)
    {
        $users = $this->UserRepository->getUserDetails($id);
        $user = $users[0];

        $orders = $this->orderRepository->userWiseOrders($id);
        
        $this->setPageTitle('User', 'Order list : '.$user->name);
        return view('admin.users.orders', compact('orders','user'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reviews($id)
    {
        $users = $this->UserRepository->getUserDetails($id);
        $user = $users[0];

        $reviews = $this->UserRepository->userReviews($id);
        
        $this->setPageTitle('User', 'All reviews : '.$user->name);
        return view('admin.users.reviews', compact('reviews','user'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createOrder($id)
    {
        $restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';
        $category = (isset($_GET['category']) && $_GET['category']!='')?$_GET['category']:'';

        $users = $this->UserRepository->getUserDetails($id);
        $user = $users[0];
        $restaurants = $this->restaurantRepository->getActiveRestaurants();

        if($restaurant_id!=''){
            $restaurantData = $this->restaurantRepository->restaurantDetails($restaurant_id);

            if($category!=''){
                $items = array();
                $itemDatas = Item::where('category_id',$category)->where('status','1')->get();

                foreach($itemDatas as $item){
                    $item_id = $item->id;
                    $user_id = $user->id;
                    $cartCheck = Cart::where('user_id',$user_id)->where('product_id',$item_id)->get();

                    if(count($cartCheck)>0){
                        $item->quantity = $cartCheck[0]->quantity;
                    }else{
                        $item->quantity = 0;
                    }

                    array_push($items,$item);
                }

            }else{
                $category = $restaurantData['categories'][0]->id;
                $items = array();
                $itemDatas = Item::where('category_id',$category)->where('status','1')->get();

                foreach($itemDatas as $item){
                    $item_id = $item->id;
                    $user_id = $user->id;
                    $cartCheck = Cart::where('user_id',$user_id)->where('product_id',$item_id)->get();

                    if(count($cartCheck)>0){
                        $item->quantity = $cartCheck[0]->quantity;
                    }else{
                        $item->quantity = 0;
                    }

                    array_push($items,$item);
                }
            }
        }else{
            $restaurantData = array();
            $items = array();
        }
        
        $this->setPageTitle('Create Order', 'Place Order for : '.$user->name);
        return view('admin.users.createorder', compact('user','restaurants','restaurantData','items'));
    }

    public function addUserCart(Request $request){
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
            return $this->responseRedirectBack('Error occurred while updating cart data.', 'error', true, true);
        }
        return $this->responseRedirectBack('Item has been successfully added to user cart' ,'success',false, false);
    }

    public function userCart($id,$restaurantId)
    {
        $users = $this->UserRepository->getUserDetails($id);
        $user = $users[0];
        $carts = Cart::where('user_id',$id)->get();
        $addresses = $this->UserRepository->adddressList($id);

        $this->setPageTitle('User Cart', 'Cart Details : '.$user->name);
        return view('admin.users.usercart', compact('user','carts','addresses','restaurantId'));
    }

    public function updateUserCart(Request $request){
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
            return $this->responseRedirectBack('Error occurred while updating cart data.', 'error', true, true);
        }
        return $this->responseRedirectBack('Item has been successfully updated in user cart' ,'success',false, false);
    }

    public function createUserOrder(Request $request){
        $user_id = $request->user_id;
        $address_id = $request->address_id;
        $restaurant_id = $request->restaurant_id;

        $users = $this->UserRepository->getUserDetails($user_id);
        $user = $users[0];
        $carts = Cart::where('user_id',$user_id)->get();
        $addresses = UserAddress::where('user_id',$user_id)->get();
        $address = $addresses[0];

        $data['user_id'] = $user_id;
        $data['restaurant_id'] = $restaurant_id;
        $data['name'] = $user['name'];
        $data['mobile'] = $user['mobile'];
        $data['email'] = $user['email'];
        $data['delivery_address'] = $address['address'];
        $data['delivery_landmark'] = $address['location'];
        $data['delivery_country'] = $address['country'];
        $data['delivery_city'] = $address['city'];
        $data['delivery_pin'] = $address['pin'];
        $data['delivery_lat'] = $address['lat'];
        $data['delivery_lng'] = $address['lng'];

        $amount = 0;
        foreach($carts as $cart){
            $amount += ($cart->price*$cart->quantity);
        }
        $data['amount'] = $amount;
        $data['coupon_code'] = '';
        $data['discounted_amount'] = '0';
        $data['transaction_id'] = 'cod-payment';

        $order = $this->orderRepository->createOrder($data);

        if (!$order) {
            return $this->responseRedirectBack('Error occurred while creating order.', 'error', true, true);
        }
        return $this->responseRedirect('admin.users.index', 'New order has been added successfully for the user' ,'success',false, false);
    }

    public function fileImport(Request $request) 
    {
        Excel::import(new VendorsImport, $request->file('file')->store('temp'));
        return back();
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileExport() 
    {
        return Excel::download(new VendorsExport, 'vendors-collection.xlsx');
    } 

    
}
