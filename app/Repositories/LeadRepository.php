<?php
namespace App\Repositories;

use App\Models\Lead;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\LeadContract;
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
class LeadRepository extends BaseRepository implements LeadContract
{
    use UploadAble;

    /**
     * LeadRepository constructor.
     * @param Lead $model
     */
    public function __construct(Lead $model)
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
    public function listLeads(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    public function listStaffLeads(int $id)
    {
        $leads = Lead::where('assigned_to',$id)->get(); 
        return $leads;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findLeadById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Blog|mixed
     */
    public function createLead(array $params)
    {
        try {

            $collection = collect($params);

            $lead = new Lead;
            $lead->uid = 'LEAD-' . time();
            $lead->customer_name = $collection['customer_name'];
            $lead->customer_mobile = $collection['customer_mobile'];
            $lead->customer_email = $collection['customer_email'];
            $lead->customer_address	 = $collection['customer_address'];
            $lead->customer_lat = $collection['lat'];
            $lead->customer_long = $collection['long'];
            $lead->requirement = $collection['requirement'];
            $lead->source = $collection['source'];
            $lead->remarks = $collection['remarks'];
            $lead->budget = $collection['budget'];
            $lead->created_by = auth()->user()->id;
            if(isset($collection['assigned_to'])){
                     $lead->assigned_to = $collection['assigned_to'];
            }else{
                     $lead->assigned_to = auth()->user()->id;
            }
            $lead->status = $collection['status'];


            
            $lead->save();

            return $lead;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    public function createFeedback(array $params)
    {
        try {

            $collection = collect($params);

            $lead_feedback  = new LeadFeedback;
            $lead_feedback->lead_id = $collection['lead_id'];
            $lead_feedback->client_comment = $collection['client_comment'];
            $lead_feedback->staff_comment = $collection['staff_comment'];
            $lead_feedback->next_follow_date = $collection['next_follow_date'];
            $lead_feedback->save();

            return $lead_feedback;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateLead(array $params)
    {
        $lead = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $lead->customer_name = $collection['customer_name'];
        $lead->customer_mobile = $collection['customer_mobile'];
        $lead->customer_email = $collection['customer_email'];
        $lead->customer_address	 = $collection['customer_address'];
        if($collection['lat'] != ""){
            $lead->customer_lat = $collection['lat'];
        }
        if($collection['long'] != ""){
            $lead->customer_long = $collection['long'];
        }
        $lead->requirement = $collection['requirement'];
        $lead->source = $collection['source'];
        $lead->remarks = $collection['remarks'];
        $lead->budget = $collection['budget'];
        $lead->created_by = auth()->user()->id;
        $lead->assigned_to = $collection['assigned_to'];
        $lead->status = $collection['status'];

        $lead->save();

        return $lead;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteLead($id)
    {
        $lead = $this->findOneOrFail($id);
        $lead->delete();
        return $lead;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBlogStatus(array $params){
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
    public function detailsLead($id){
        $leads = Lead::where('id',$id)->get();

       
        
        return $leads;
    }

    /**
     * @return mixed
     */
    public function getLeads(){
        $blogs = Blog::with('category')->with('tags')->paginate(5);

        return $blogs;
    }

    /**
     * @return mixed
     */
    public function getBlogcategories(){
        $categories = Blogcategory::get();

        return $categories;
    }

    /**
     * @return mixed
     */
    public function latestBlogs(){
        $blogs = Blog::orderBy('blog_views','desc')->take(5)->get();
        
        return $blogs;
    }

    /**
     * @return mixed
     */
    public function getBlogtags(){
        $tags = Blogtag::select('tag')
                ->groupBy('tag')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(10)
                ->get();

        return $tags;
    }

    /**
     * @param $categoryId
     * @param $id
     * @return mixed
     */
    public function getRelatedBlogs($categoryId,$id){
        $blogs = Blog::with('category')->where('category_id',$categoryId)->where('id','!=',$id)->get();
        
        return $blogs;
    }

    /**
     * @param $categoryId
     * @return mixed
     */
    public function categoryWiseBlogs($categoryId){
//$blogs = Blog::with('category')->where('category_id',$categoryId)->get();
        
//return $blogs;
    }
}