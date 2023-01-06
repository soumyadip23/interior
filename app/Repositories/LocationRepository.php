<?php
namespace App\Repositories;

use App\Models\Location;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\LocationContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class LocationRepository
 *
 * @package \App\Repositories
 */
class LocationRepository extends BaseRepository implements LocationContract
{
    use UploadAble;

    /**
     * LocationRepository constructor.
     * @param Location $model
     */
    public function __construct(Location $model)
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
    public function listLocations(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findLocationById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Location|mixed
     */
    public function createLocation(array $params)
    {
        try {

            $collection = collect($params);

            $location = new Location;
            $location->name = $collection['name'];
            $location->lat = $collection['lat'];
            $location->lng = $collection['lng'];
            
            $location->save();

            return $location;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateLocation(array $params)
    {
        $location = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $location->name = $collection['name'];
        $location->lat = $collection['lat'];
        $location->lng = $collection['lng'];

        $location->save();

        return $location;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteLocation($id)
    {
        $location = $this->findOneOrFail($id);
        $location->delete();
        return $location;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateLocationStatus(array $params){
        $location = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $location->status = $collection['check_status'];
        $location->save();

        return $location;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsLocation($id){
        
    }
}