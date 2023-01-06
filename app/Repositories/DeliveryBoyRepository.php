<?php
namespace App\Repositories;

use App\Models\DeliveryBoy;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\DeliveryBoyContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class DeliveryBoyRepository
 *
 * @package \App\Repositories
 */
class DeliveryBoyRepository extends BaseRepository implements DeliveryBoyContract
{
    use UploadAble;

    /**
     * DeliveryBoyRepository constructor.
     * @param DeliveryBoy $model
     */
    public function __construct(DeliveryBoy $model)
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
    public function listDeliveryBoys(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findDeliveryBoyById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return DeliveryBoy|mixed
     */
    public function createDeliveryBoy(array $params)
    {
        try {

            $collection = collect($params);

            $deliveryBoy = new DeliveryBoy;
            $deliveryBoy->name = $collection['name'];
            $deliveryBoy->email = $collection['email'];
            $deliveryBoy->password = bcrypt($params['password']);
            $deliveryBoy->mobile = $collection['mobile'];
            $deliveryBoy->country = $collection['country'];
            $deliveryBoy->city = $collection['city'];
            $deliveryBoy->address = $collection['address'];
            $deliveryBoy->pin = $collection['pin'];
            $deliveryBoy->gender = $collection['gender'];
            $deliveryBoy->date_of_birth = $collection['date_of_birth'];
            $deliveryBoy->status = 1;
            $deliveryBoy->is_deleted = 0;

            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("delivery_boys/",$imageName);
            $uploadedImage = $imageName;
            $deliveryBoy->image = $uploadedImage;
            
            $deliveryBoy->save();

            return $deliveryBoy;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateDeliveryBoy(array $params)
    {
        $deliveryBoy = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $deliveryBoy->name = $collection['name'];
        $deliveryBoy->email = $collection['email'];
        //$deliveryBoy->password = bcrypt($params['password']);
        //$deliveryBoy->mobile = $collection['mobile'];
        $deliveryBoy->country = $collection['country'];
        $deliveryBoy->city = $collection['city'];
        $deliveryBoy->address = $collection['address'];
        $deliveryBoy->pin = $collection['pin'];
        $deliveryBoy->vehicle_type = $collection['vehicle_type'];
        $deliveryBoy->gender = $collection['gender'];
        $deliveryBoy->date_of_birth = $collection['date_of_birth'];

        // $profile_image = $collection['image'];
        // $imageName = time().".".$profile_image->getClientOriginalName();
        // $profile_image->move("delivery_boys/",$imageName);
        // $uploadedImage = $imageName;
        // $deliveryBoy->image = $uploadedImage;

        $deliveryBoy->save();

        return $deliveryBoy;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteDeliveryBoy($id)
    {
        $deliveryBoy = $this->findOneOrFail($id);
        $deliveryBoy->delete();
        return $deliveryBoy;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateDeliveryBoyStatus(array $params){
        $deliveryBoy = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $deliveryBoy->status = $collection['check_status'];
        $deliveryBoy->save();

        return $deliveryBoy;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsDeliveryBoy($id){
        $deliveryBoy =  DeliveryBoy::where('id',$id)->get();

        return $deliveryBoy;
    }

    /**
     * @return mixed
     */
    public function getAllBoys(){
        $deliveryBoys =  DeliveryBoy::with('vehicle')->get();

        return $deliveryBoys;
    }

    /**
     * @param array $params
     * @return DeliveryBoy|mixed
     */
    public function boyLogin(array $params){
        try {

            $collection = collect($params);

            $mobile = $collection['mobile'];
            $password = md5($params['password']);
            
            $boys = DeliveryBoy::where('mobile',$mobile)->where('password',$password)->get();

            return $boys;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
}