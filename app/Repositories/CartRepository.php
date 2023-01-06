<?php
namespace App\Repositories;

use App\Models\Cart;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CartContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;


/**
 * Class CartRepository
 *
 * @package \App\Repositories
 */
class CartRepository extends BaseRepository implements CartContract
{
    use UploadAble;

    /**
     * CartRepository constructor.
     * @param Cart $model
     */
    public function __construct(Cart $model)
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
    public function listCarts(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCartById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Cart|mixed
     */
    public function createCart(array $params)
    {
        try {

            $collection = collect($params);

            $cart = new Cart;
            $cart->user_id = $collection['user_id'];
            $cart->device_id = $collection['device_id'];
            $cart->restaurant_id = $collection['restaurant_id'];
            $cart->product_id = $collection['product_id'];
            $cart->product_name = $collection['product_name'];
            $cart->product_description = $collection['product_description'];
            $cart->product_image = $collection['product_image'];
            $cart->price = $collection['price'];
            $cart->quantity = $collection['quantity'];
            $cart->add_on_id = $collection['add_on_id'];
            $cart->add_on_name = $collection['add_on_name'];
            $cart->add_on_price = $collection['add_on_price'];
            $cart->add_on_quantity = $collection['add_on_quantity'];
            $cart->is_cutlery_required = $collection['is_cutlery_required'];
            $cart->cutlery_quantity = $collection['cutlery_quantity'];
            $cart->cutlery_price = $collection['cutlery_price'];
            
            $cart->save();

            return $cart;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCart(array $params)
    {
        $cart = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $cart->product_id = $collection['product_id'];
        $cart->product_name = $collection['product_name'];
        $cart->product_description = $collection['product_description'];
        $cart->product_image = $collection['product_image'];
        $cart->price = $collection['price'];
        $cart->quantity = $collection['quantity'];
        $cart->add_on_id = $collection['add_on_id'];
        $cart->add_on_name = $collection['add_on_name'];
        $cart->add_on_price = $collection['add_on_price'];
        $cart->add_on_quantity = $collection['add_on_quantity'];
        $cart->add_on_id2 = $collection['add_on_id2'];
        $cart->add_on_name2 = $collection['add_on_name2'];
        $cart->add_on_price2 = $collection['add_on_price2'];
        $cart->add_on_quantity2 = $collection['add_on_quantity2'];
        $cart->is_cutlery_required = $collection['is_cutlery_required'];
        $cart->cutlery_quantity = $collection['cutlery_quantity'];
        $cart->cutlery_price = $collection['cutlery_price'];

        $cart->save();

        return $cart;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCart($id)
    {
        Cart::where('id',$id)->delete();
        return true;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCartStatus(array $params){
        $cart = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $cart->status = $collection['check_status'];
        $cart->save();

        return $cart;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsCommission($id){
        
    }

    /**
     * @param $userId
     * @return bool
     */
    public function clearCart($userId)
    {
        $carts = Cart::where('user_id',$userId)->get();

        foreach($carts as $cart) 
        {
            $cart->delete();
        }

        return true;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function userWiseCartList($userId){
        $carts = Cart::where("user_id",$userId)->get();

        return $carts;
    }
}