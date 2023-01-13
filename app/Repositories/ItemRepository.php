<?php
namespace App\Repositories;

use App\Models\Item;
use App\Models\ItemVariation;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\ItemContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Auth;
use App\Models\LeadFeedback;

/**
 * Class LeadRepository
 *
 * @package \App\Repositories
 */
class ItemRepository extends BaseRepository implements ItemContract
{
    use UploadAble;

    /**
     * LeadRepository constructor.
     * @param Item $model
     */
    public function __construct(Item $model)
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
    public function listItems(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findItemById(int $id)
    {
        try {
            return  Item::with('category')->with('itemVariation')->where('id',$id)->first();
        
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Blog|mixed
     */
    public function createItem(array $params)
    {
        try {

            $collection = collect($params);

            $item = new Item;
            $item->category_id = $collection['category_id'];
            $item->name = $collection['name'];
            $item->status = '1';
            $item->description = $collection['description'];
             if(isset($collection['image'])){
                    $profile_image = $collection['image'];
                    $imageName = time().".".$profile_image->getClientOriginalName();
                    $profile_image->move("items/",$imageName);
                    $uploadedImage = $imageName;
                    $item->image = $uploadedImage;
             }
             $item->save();
            if($item){
                            for ($i = 0; $i < count($collection['vname']); $i ++){
                                $name = $collection['vname'][$i];
                                $unit = $collection['unit'][$i];
                                $price = $collection['price'][$i];
                                $in_stock = $collection['in_stock'][$i];

                                // add product variations  in item_details table
                                $itemDetails = new ItemVariation;
                                $itemDetails->item_id = $item->id;
                                $itemDetails->name = $name;
                                $itemDetails->unit = $unit;
                                $itemDetails->price = $price;
                                $itemDetails->in_stock = $in_stock;
                                $itemDetails->save();
                               
                            }
                    }
            return $item;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }



    /**
     * @param array $params
     * @return mixed
     */
    public function updateItem(array $params)
    {
        $item = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $item->category_id = $collection['category_id'];
        $item->name = $collection['name'];
        $item->status = '1';
        $item->description = $collection['description'];
         if(isset($collection['image'])){
                $profile_image = $collection['image'];
                $imageName = time().".".$profile_image->getClientOriginalName();
                $profile_image->move("items/",$imageName);
                $uploadedImage = $imageName;
                $item->image = $uploadedImage;
         }

        $item->save();
        if($item){
                  ItemVariation::where('item_id',$item->id)->delete();
            for ($i = 0; $i < count($collection['vname']); $i ++){
                $name = $collection['vname'][$i];
                $unit = $collection['unit'][$i];
                $price = $collection['price'][$i];
                $in_stock = $collection['in_stock'][$i];

                // add product variations  in item_details table
                $itemDetails = new ItemVariation;
                $itemDetails->item_id = $item->id;
                $itemDetails->name = $name;
                $itemDetails->unit = $unit;
                $itemDetails->price = $price;
                $itemDetails->in_stock = $in_stock;
                $itemDetails->save();
               
            }
    }

        return $item;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteItem($id)
    {
        $lead = $this->findOneOrFail($id);
        $lead->delete();
        return $lead;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateItemStatus(array $params){
        $blog = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $blog->status = $collection['check_status'];
        $blog->save();

        return $blog;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsItem($id){

        $items = Item::with('category')->with('itemVariation')->where('id',$id)->first();

        //dd($items);

        return $items;

    }

    /**
     * @return mixed
     */
    public function getItems(){
        $items = Item::with('category')->get();

        return $items;
    }

    /**
     * @return mixed
     */
    public function getItemcategories(){
        $categories = Blogcategory::get();

        return $categories;
    }

    /**
     * @return mixed
     */
    public function latestitems(){
        $blogs = Blog::orderBy('blog_views','desc')->take(5)->get();
        
        return $blogs;
    }


  
    public function getRelatedItems($categoryId,$id){
        $blogs = Blog::with('category')->where('category_id',$categoryId)->where('id','!=',$id)->get();
        
        return $blogs;
    }

    /**
     * @param $categoryId
     * @return mixed
     */
    public function categoryWiseItems($categoryId){
        //$blogs = Blog::with('category')->where('category_id',$categoryId)->get();
                
        //return $blogs;
    }
}