<?php
namespace App\Repositories;

use App\Models\Incentive;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\IncentiveContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class IncentiveRepository
 *
 * @package \App\Repositories
 */
class IncentiveRepository extends BaseRepository implements IncentiveContract
{
    use UploadAble;

    /**
     * IncentiveRepository constructor.
     * @param Incentive $model
     */
    public function __construct(Incentive $model)
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
    public function listIncentives(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findIncentiveById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Incentive|mixed
     */
    public function createIncentive(array $params)
    {
        try {

            $collection = collect($params);

            $incentive = new Incentive;
            $incentive->title = $collection['title'];
            $incentive->min_order = $collection['min_order'];
            $incentive->max_order = $collection['max_order'];
            $incentive->value = $collection['value'];
            
            $incentive->save();

            return $incentive;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateIncentive(array $params)
    {
        $incentive = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $incentive->title = $collection['title'];
        $incentive->min_order = $collection['min_order'];
        $incentive->max_order = $collection['max_order'];
        $incentive->value = $collection['value'];

        $incentive->save();

        return $incentive;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteIncentive($id)
    {
        $incentive = $this->findOneOrFail($id);
        $incentive->delete();
        return $incentive;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateIncentiveStatus(array $params){
        $incentive = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $incentive->status = $collection['check_status'];
        $incentive->save();

        return $incentive;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsIncentive($id){
        
    }
}