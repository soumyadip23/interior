<?php
namespace App\Repositories;

use App\Models\Item;
use App\Models\ItemVariation;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\ItemContract;
use App\Contracts\QuatationContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Auth;
use App\Models\LeadFeedback;
use App\Models\Quatation;
use App\Models\QuatationDetails;

/**
 * Class LeadRepository
 *
 * @package \App\Repositories
 */
class QuatationRepository extends BaseRepository implements QuatationContract
{
    use UploadAble;

    /**
     * LeadRepository constructor.
     * @param Quatation $model
     */
    public function __construct(Quatation $model)
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
    public function createQuatation(array $params)
    {
        try {

            $collection = collect($params);

            //dd($collection);

            $qut = new Quatation;
            $qut->lead_id = $collection['lead_id'];
            $qut->form_date = $collection['form_date'];
            $qut->created_by = auth()->user()->id;
            $qut->status = 'new';
            $qut->expiry_date = $collection['expiry_date'];
            $qut->notes = $collection['notes'];
            $qut->tax = $collection['tax'];
            $qut->discount = $collection['discount'];
            $qut->labour_cost = $collection['labour_cost'];
            $qut->total = $collection['quote_final_total'];


            $qut->save();
            if($qut){
                            for ($i = 0; $i < count($collection['item_id']); $i ++){
                                $item_variation_id = $collection['variation'][$i];
                                $quantity = $collection['quantity'][$i];
                                $sub_total = $collection['sub_total'][$i];
                                $unit_price = $collection['unit_price'][$i];

                                // add product variations  in quatation_details table
                                $itemDetails = new QuatationDetails;
                                $itemDetails->quatation_id = $qut->id;
                                $itemDetails->item_variation_id = $item_variation_id;
                                $itemDetails->quantity = $quantity;
                                $itemDetails->unit_price = $unit_price;
                                $itemDetails->price = $sub_total;
                                $itemDetails->save();
                               
                            }
                    }
            return $qut;
            
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

        $items = Quatation::with('quatationDetails')->where('id',$id)->first();


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