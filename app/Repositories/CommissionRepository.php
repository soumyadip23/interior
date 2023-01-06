<?php
namespace App\Repositories;

use App\Models\Commission;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CommissionContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class CommissionRepository
 *
 * @package \App\Repositories
 */
class CommissionRepository extends BaseRepository implements CommissionContract
{
    use UploadAble;

    /**
     * CommissionRepository constructor.
     * @param Commission $model
     */
    public function __construct(Commission $model)
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
    public function listCommissions(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCommissionById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Commission|mixed
     */
    public function createCommission(array $params)
    {
        try {

            $collection = collect($params);

            $commission = new Commission;
            $commission->title = $collection['title'];
            $commission->min_order = $collection['min_order'];
            $commission->max_order = $collection['max_order'];
            $commission->value = $collection['value'];
            
            $commission->save();

            return $commission;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCommission(array $params)
    {
        $commission = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $commission->title = $collection['title'];
        $commission->min_order = $collection['min_order'];
        $commission->max_order = $collection['max_order'];
        $commission->value = $collection['value'];

        $commission->save();

        return $commission;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deletecommission($id)
    {
        $commission = $this->findOneOrFail($id);
        $commission->delete();
        return $commission;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCommissionStatus(array $params){
        $commission = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $commission->status = $collection['check_status'];
        $commission->save();

        return $commission;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsCommission($id){
        
    }
}