<?php
namespace App\Repositories;

use App\Models\Category;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CategoryContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class CategoryRepository
 *
 * @package \App\Repositories
 */
class CategoryRepository extends BaseRepository implements CategoryContract
{
    use UploadAble;

    /**
     * CategoryRepository constructor.
     * @param Category $model
     */
    public function __construct(Category $model)
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
    public function listCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCategoryById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Category|mixed
     */
    public function createCategory(array $params)
    {
        try {

            $collection = collect($params);

            $category = new Category;
            $category->title = $collection['title'];
           // $category->restaurant_id = $collection['restaurant_id'];
            $category->description = '';
            $category->status = '1';

            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("categories/",$imageName);
            $uploadedImage = $imageName;
            $category->image = $uploadedImage;
            
            $category->save();

            return $category;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCategory(array $params)
    {
        $category = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $category->title = $collection['title'];

        $profile_image = $collection['image'];
        $imageName = time().".".$profile_image->getClientOriginalName();
        $profile_image->move("categories/",$imageName);
        $uploadedImage = $imageName;
        $category->image = $uploadedImage;

        $category->save();

        return $category;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCategory($id)
    {
        $category = $this->findOneOrFail($id);
        $category->delete();
        return $category;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCategoryStatus(array $params){
        $category = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $category->status = $collection['check_status'];
        $category->save();

        return $category;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsCategory($id)
    {
        $categories = Category::where('id',$id)->get();
        
        return $categories;
    }

    /**
     * @param $restaurant_id
     * @return mixed
     */
    public function restaurantWiseCategories($restaurant_id)
    {
        $categories = Category::where('restaurant_id',$restaurant_id)->get();
        
        return $categories;
    }

    /**
     * @return mixed
     */
    public function allCategoryList()
    {
        $categories = Category::get();
        
        return $categories;
    }
}