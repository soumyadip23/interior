<?php
namespace App\Repositories;

use App\Models\RestaurantCoupon;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\RestaurantCouponContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class RestaurantCouponRepository
 *
 * @package \App\Repositories
 */
class RestaurantCouponRepository extends BaseRepository implements RestaurantCouponContract
{
    use UploadAble;

    /**
     * RestaurantCouponRepository constructor.
     * @param RestaurantCoupon $model
     */
    public function __construct(RestaurantCoupon $model)
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
    public function listCoupons(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCouponById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Coupon|mixed
     */
    public function createCoupon(array $params)
    {
        try {

            $collection = collect($params);

            $coupon = new RestaurantCoupon;
            $coupon->restaurant_id = $collection['restaurant_id'];
            $coupon->title = $collection['title'];
            $coupon->description = $collection['description'];
            $coupon->code = $collection['code'];
            $coupon->type = $collection['type'];
            $coupon->rate = $collection['rate'];
            $coupon->maximum_offer_rate = $collection['maximum_offer_rate'];
            $coupon->start_date = $collection['start_date'];
            $coupon->end_date = $collection['end_date'];
            $coupon->maximum_time_of_use = $collection['maximum_time_of_use'];
            $coupon->maximum_time_user_can_use = $collection['maximum_time_user_can_use'];
            
            $coupon->save();

            return $coupon;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCoupon(array $params)
    {
        $coupon = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $coupon->restaurant_id = $collection['restaurant_id'];
        $coupon->title = $collection['title'];
        $coupon->description = $collection['description'];
        $coupon->code = $collection['code'];
        $coupon->type = $collection['type'];
        $coupon->rate = $collection['rate'];
        $coupon->maximum_offer_rate = $collection['maximum_offer_rate'];
        $coupon->start_date = $collection['start_date'];
        $coupon->end_date = $collection['end_date'];
        $coupon->maximum_time_of_use = $collection['maximum_time_of_use'];
        $coupon->maximum_time_user_can_use = $collection['maximum_time_user_can_use'];

        $coupon->save();

        return $coupon;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCoupon($id)
    {
        $coupon = $this->findOneOrFail($id);
        $coupon->delete();
        return $coupon;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCouponStatus(array $params){
        $coupon = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $coupon->status = $collection['check_status'];
        $coupon->save();

        return $coupon;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsCoupon($id)
    {
        
    }

    /**
     * @return mixed
     */
    public function activeCoupons(){
        $today = date("Y-m-d");
        $coupons =  RestaurantCoupon::where('start_date','<=',$today)->where('end_date','>=',$today)->get();

        return $coupons;
    }

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function activeCouponsByRestaurant($restaurantId){
        $today = date("Y-m-d");
        $coupons =  RestaurantCoupon::where('restaurant_id',$restaurantId)->where('start_date','<=',$today)->where('end_date','>=',$today)->get();

        return $coupons;
    }
}