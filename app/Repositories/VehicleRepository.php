<?php
namespace App\Repositories;

use App\Models\Vehicle;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\VehicleContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class VehicleRepository
 *
 * @package \App\Repositories
 */
class VehicleRepository extends BaseRepository implements VehicleContract
{
    use UploadAble;

    /**
     * VehicleRepository constructor.
     * @param Vehicle $model
     */
    public function __construct(Vehicle $model)
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
    public function listVehicles(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findVehicleById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Vehicle|mixed
     */
    public function createVehicle(array $params)
    {
        try {

            $collection = collect($params);

            $vehicle = new Vehicle;
            $vehicle->name = $collection['name'];
            
            $vehicle->save();

            return $vehicle;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateVehicle(array $params)
    {
        $vehicle = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $vehicle->name = $collection['name'];

        $vehicle->save();

        return $vehicle;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteVehicle($id)
    {
        $vehicle = $this->findOneOrFail($id);
        $vehicle->delete();
        return $vehicle;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateVehicleStatus(array $params){
        $vehicle = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $vehicle->status = $collection['check_status'];
        $vehicle->save();

        return $vehicle;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsVehicle($id){
        
    }
}