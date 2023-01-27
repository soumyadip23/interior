<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\RestaurantReview;
use App\Models\UserAddress;
use App\Models\Order;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\UserContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use DB;
use App\Models\Vendor;
use App\Models\VendorCategories;
/**
 * Class UserRepository
 *
 * @package \App\Repositories
 */
class UserRepository extends BaseRepository implements UserContract
{
    use UploadAble;

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(Vendor $model)
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
    public function listUsers(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

     /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findUserById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return User|mixed
     */
    public function createUser(array $params)
    {
        try {

            $collection = collect($params);

           // dd($collection['cat_id']);

            $user = new Vendor;
            $user->name = $collection['name'];
            $user->email = $collection['email'];
            $user->password = bcrypt($params['password']);
            $user->account_no = $collection['account_no'];
            $user->mobile = $collection['mobile'];
            $user->otp = 1234;
            $user->country = $collection['country'];
            $user->city = $collection['city'];
            $user->address = $collection['address'];
            $user->lat = $collection['lat'];
            $user->long = $collection['long'];
            $user->contact_person = $collection['contact_person'];
            $user->contact_no = $collection['contact_no'];
           
            $user->device_id = '';
            $user->device_token = '';
            $user->is_verified = 1;
            $user->status = 1;
            $user->is_deleted = 0;
            
            $user->save();

            foreach($collection['cat_id'] as $catg){
                $ven_cat = new VendorCategories; 
                    $ven_cat->vendor_id = $user->id;
                    $ven_cat->cat_id = $catg;
                $ven_cat->save();
            }


            return $user;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return User|mixed
     */
    public function updateUser(array $params){
        //dd($params);
        $user = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $user->name = $collection['name'];
        $user->email = $collection['email'];
        //$user->image = $collection['image'];
         $user->country = $collection['country'];
        // $user->city = $collection['city'];
         $user->account_no = $collection['account_no'];
         $user->address = $collection['address'];
         $user->contact_person = $collection['contact_person'];
         $user->contact_no = $collection['contact_no'];
         $user->lat = $collection['lat'];
         $user->long = $collection['long'];
        //$user->gender = $collection['gender'];
        //$user->date_of_birth = $collection['date_of_birth'];

        $user->save();
        $result = VendorCategories::where('vendor_id','=',$user->id)->delete(); 
        foreach($collection['cat_id'] as $catg){
            $ven_cat = new VendorCategories; 
                $ven_cat->vendor_id = $user->id;
                $ven_cat->cat_id = $catg;
            $ven_cat->save();
        }

        return $user;
    }

    /**
     * @param array $params
     * @return User|mixed
     */
    public function updateDeviceDetails(array $params){
        $user = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $user->device_id = $collection['device_id'];
        $user->device_token = $collection['device_token'];

        $user->save();

        return $user;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function getUserDetails(int $id)
    {
        try {
            $user = Vendor::where('id',$id)->get();
            //return $this->findOneOrFail($id);

            return $user;

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function blockUser($id,$is_block){
        $user = $this->findUserById($id);
        $user->is_block = $is_block;
        $user->save();

        return $user;
    }
    /**
     * @param array $params
     * @return mixed
     */
    public function verify($id,$is_verified){
        $user = $this->findUserById($id);
        $user->is_verified = $is_verified;
        $user->save();

        return $user;
    }

     /**
     * @param array $params
     * @return mixed
     */
    public function updateUserStatus(array $params){
        $user = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $user->status = $collection['check_status'];
        $user->save();

        return $user;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteUser($id)
    {
        $user = $this->findOneOrFail($id);
        $user->delete();
        return $user;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userReviews($id){
        $reviews =  RestaurantReview::with('restaurant')->where('user_id',$id)->get();

        return $reviews;
    }

    /**
     * @param array $params
     * @return User|mixed
     */
    public function userRegistration(array $params)
    {
        try {

            $collection = collect($params);

            $user = new User;
            $user->name = $collection['name'];
            $user->email = $collection['email'];
            $user->password = bcrypt($params['password']);;
            $user->mobile = $collection['mobile'];
            $user->otp = 1234;
            $user->country = '';
            $user->city = '';
            $user->address = '';
            $user->gender = '';
            $user->date_of_birth = '1900-01-01';
            $user->is_verified = 1;
            $user->status = 1;
            $user->is_deleted = 0;
            
            $user->save();

            return $user;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function adddressList($userId){
        $addresses =  UserAddress::with('user')->where('user_id',$userId)->get();

        return $addresses;
    }

    /**
     * @param array $params
     * @return UserAddress|mixed
     */
    public function addAddress(array $params){
        try {

            $collection = collect($params);

            $address = new UserAddress;
            $address->user_id = $collection['user_id'];
            $address->address = $collection['address'];
            $address->location = $collection['location'];
            $address->lat = $collection['lat'];
            $address->lng = $collection['lng'];
            $address->country = $collection['country'];
            $address->state = $collection['state'];
            $address->city = $collection['city'];
            $address->pin = $collection['pin'];
            $address->tag = $collection['tag'];
            
            $address->save();

            return $address;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return UserAddress|mixed
     */
    public function updateAddress(array $params){
        $address = UserAddress::find($params['id']);
        $collection = collect($params)->except('_token'); 

        $address->address = $collection['address'];
        $address->location = $collection['location'];
        $address->lat = $collection['lat'];
        $address->lng = $collection['lng'];
        $address->country = $collection['country'];
        $address->state = $collection['state'];
        $address->city = $collection['city'];
        $address->pin = $collection['pin'];
        $address->tag = $collection['tag'];

        $address->save();

        return $address;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteAddress($id)
    {
        $address = UserAddress::find($id);
        $address->delete();
        return $address;
    }

    /**
     * @param $name
     * @param $mobile
     * @param $email
     * @param $status
     * @param $order_placed
     * @return mixed
     */
    public function searchUserData($name,$mobile,$email,$location,$cat_id){

        $users = array();

        
        if(isset($cat_id) && $cat_id!=""){
            $result = VendorCategories::select('vendor_id')->whereIN('cat_id',$cat_id)->get()->unique('vendor_id'); 
            $result_array = array();
            foreach($result as $res){
                $result_array[] = $res->vendor_id;
            }
            //dd($result_array );
            $usersData = Vendor::orderBy('id','desc')
                        ->when($name, function($query) use ($name){
                            $query->where('name', 'like', '%' . $name .'%');
                        })
                        ->when($mobile, function($query) use ($mobile){
                            $query->where('mobile', 'like', '%' . $mobile .'%');
                        })
                        ->when($email, function($query) use ($email){
                            $query->where('email', '=', $email);
                        })
                        ->when($location, function($query) use ($location){
                            $query->where('address', 'like', '%' . $location .'%');
                        })
                        ->when($result_array, function($query) use ($result_array){
                            $query->whereIN('id', $result_array);
                        })
                        ->paginate(50);
            
        } else{
                        $usersData = Vendor::orderBy('id','desc')
                        ->when($name, function($query) use ($name){
                            $query->where('name', 'like', '%' . $name .'%');
                        })
                        ->when($mobile, function($query) use ($mobile){
                            $query->where('mobile', 'like', '%' . $mobile .'%');
                        })
                        ->when($email, function($query) use ($email){
                            $query->where('email', '=', $email);
                        })
                        ->when($location, function($query) use ($location){
                            $query->where('address', 'like', '%' . $location .'%');
                        })
                        ->paginate(50);
        }
        

        foreach($usersData as $user){
            $user_id = $user->id;


            $user_categories = DB::select("select cat_id from vendor_categories where vendor_id='$user_id'");

            if($user_categories){

                    //$user_cat_array = array();

                    $user_cat = ''; 

                    foreach($user_categories as $ucat){
                        
                        $opt = DB::select("select title from categories where id='$ucat->cat_id'");
                        //dd($opt);
                        $user_cat  = $user_cat . $opt[0]->title. ",";

                    }
                    $user->user_cat = $user_cat; 
            }

            array_push($users,$user);
        }

        return $users;
    }
}