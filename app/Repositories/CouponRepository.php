<?php
namespace App\Repositories;

use App\Models\Coupon;
use App\Models\RestaurantCoupon;
use App\Models\CuisineCoupon;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CouponContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use DB;

/**
 * Class CouponRepository
 *
 * @package \App\Repositories
 */
class CouponRepository extends BaseRepository implements CouponContract
{
    use UploadAble;

    /**
     * CouponRepository constructor.
     * @param Coupon $model
     */
    public function __construct(Coupon $model)
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

            $coupon = new Coupon;
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

            if(count($params['restaurants'])>0){
                foreach($params['restaurants'] as $restaurant){
                    $rescoupon = new RestaurantCoupon;
                    $rescoupon->restaurant_id = $restaurant;
                    $rescoupon->title = $collection['title'];
                    $rescoupon->description = $collection['description'];
                    $rescoupon->code = $collection['code'];
                    $rescoupon->type = $collection['type'];
                    $rescoupon->rate = $collection['rate'];
                    $rescoupon->maximum_offer_rate = $collection['maximum_offer_rate'];
                    $rescoupon->start_date = $collection['start_date'];
                    $rescoupon->end_date = $collection['end_date'];
                    $rescoupon->maximum_time_of_use = $collection['maximum_time_of_use'];
                    $rescoupon->maximum_time_user_can_use = $collection['maximum_time_user_can_use'];
                    
                    $rescoupon->save();
                }
            }

            if(count($params['cuisines'])>0){
                foreach($params['cuisines'] as $cuisine){
                    $cscoupon = new CuisineCoupon;
                    $cscoupon->cuisine_id = $cuisine;
                    $cscoupon->title = $collection['title'];
                    $cscoupon->description = $collection['description'];
                    $cscoupon->code = $collection['code'];
                    $cscoupon->type = $collection['type'];
                    $cscoupon->rate = $collection['rate'];
                    $cscoupon->maximum_offer_rate = $collection['maximum_offer_rate'];
                    $cscoupon->start_date = $collection['start_date'];
                    $cscoupon->end_date = $collection['end_date'];
                    $cscoupon->maximum_time_of_use = $collection['maximum_time_of_use'];
                    $cscoupon->maximum_time_user_can_use = $collection['maximum_time_user_can_use'];
                    
                    $cscoupon->save();
                }
            }

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

        $code = $collection['code'];

        if(count($params['restaurants'])>0){
            DB::delete("delete from restaurant_coupons where code='$code'");
            foreach($params['restaurants'] as $restaurant){
                $rescoupon = new RestaurantCoupon;
                $rescoupon->restaurant_id = $restaurant;
                $rescoupon->title = $collection['title'];
                $rescoupon->description = $collection['description'];
                $rescoupon->code = $collection['code'];
                $rescoupon->type = $collection['type'];
                $rescoupon->rate = $collection['rate'];
                $rescoupon->maximum_offer_rate = $collection['maximum_offer_rate'];
                $rescoupon->start_date = $collection['start_date'];
                $rescoupon->end_date = $collection['end_date'];
                $rescoupon->maximum_time_of_use = $collection['maximum_time_of_use'];
                $rescoupon->maximum_time_user_can_use = $collection['maximum_time_user_can_use'];
                
                $rescoupon->save();
            }
        }

        if(count($params['cuisines'])>0){
            DB::delete("delete from cuisine_coupons where code='$code'");
            foreach($params['cuisines'] as $cuisine){
                $cscoupon = new CuisineCoupon;
                $cscoupon->cuisine_id = $cuisine;
                $cscoupon->title = $collection['title'];
                $cscoupon->description = $collection['description'];
                $cscoupon->code = $collection['code'];
                $cscoupon->type = $collection['type'];
                $cscoupon->rate = $collection['rate'];
                $cscoupon->maximum_offer_rate = $collection['maximum_offer_rate'];
                $cscoupon->start_date = $collection['start_date'];
                $cscoupon->end_date = $collection['end_date'];
                $cscoupon->maximum_time_of_use = $collection['maximum_time_of_use'];
                $cscoupon->maximum_time_user_can_use = $collection['maximum_time_user_can_use'];
                
                $cscoupon->save();
            }
        }

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
        $coupons =  Coupon::where('start_date','<=',$today)->where('end_date','>=',$today)->get();

        return $coupons;
    }
}