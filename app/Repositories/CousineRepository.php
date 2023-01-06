<?php
namespace App\Repositories;

use App\Models\Cuisine;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CousineContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use DB;

/**
 * Class CousineRepository
 *
 * @package \App\Repositories
 */
class CousineRepository extends BaseRepository implements CousineContract
{
    use UploadAble;

    /**
     * CousineRepository constructor.
     * @param Cuisine $model
     */
    public function __construct(Cuisine $model)
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
    public function listCousines(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCousineById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Cousine|mixed
     */
    public function createCousine(array $params)
    {
        try {

            $collection = collect($params);

            $cousine = new Cuisine;
            $cousine->title = $collection['title'];

            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("cousines/",$imageName);
            $uploadedImage = $imageName;
            $cousine->image = $uploadedImage;
            
            $cousine->save();

            return $cousine;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCousine(array $params)
    {
        $cousine = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $cousine->title = $collection['title'];

        $profile_image = $collection['image'];
        $imageName = time().".".$profile_image->getClientOriginalName();
        $profile_image->move("categories/",$imageName);
        $uploadedImage = $imageName;
        $cousine->image = $uploadedImage;

        $cousine->save();

        return $cousine;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCousine($id)
    {
        $cousine = $this->findOneOrFail($id);
        $cousine->delete();
        return $cousine;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCousineStatus(array $params){
        $cousine = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $cousine->status = $collection['check_status'];
        $cousine->save();

        return $cousine;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsCousine($id)
    {
        
    }

    /**
     * @return mixed
     */
    public function getCuisineList(){
        $cuisines = Cuisine::where('title','!=','')->get();

        return $cuisines;
    }

    /**
     * @return mixed
     */
    public function getTrendingCuisineList(){
        $cuisines = Cuisine::where('title','!=','')->where('is_trending','=','1')->get();

        return $cuisines;
    }

    /**
     * @param $keyword
     * @return Cousine|mixed
     */
    public function searchCuisines($keyword){
        $cuisines = DB::select("select * from cuisines where title like '%$keyword%'");

        return $cuisines;
    }
}