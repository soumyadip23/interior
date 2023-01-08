<?php
namespace App\Repositories;

use App\Models\Blog;
use App\Models\Blogcategory;
use App\Models\Blogtag;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\LeadContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class LeadRepository
 *
 * @package \App\Repositories
 */
class LeadRepository extends BaseRepository implements LeadContract
{
    use UploadAble;

    /**
     * BlogRepository constructor.
     * @param Blog $model
     */
    public function __construct(Blog $model)
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

            $blog = new Blog;
            $blog->title = $collection['title'];
            $blog->description = $collection['description'];

            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("Blogs/",$imageName);
            $uploadedImage = $imageName;
            $blog->image = $uploadedImage;
            
            $blog->save();

            return $blog;
            
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
        $blog = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $blog->title = $collection['title'];
        $blog->description = $collection['description'];

        $profile_image = $collection['image'];
        $imageName = time().".".$profile_image->getClientOriginalName();
        $profile_image->move("Blogs/",$imageName);
        $uploadedImage = $imageName;
        $blog->image = $uploadedImage;

        $blog->save();

        return $blog;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteLead($id)
    {
        $blog = $this->findOneOrFail($id);
        $blog->delete();
        return $blog;
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
        $blogs = Blog::with('category')->with('tags')->where('id',$id)->get();
        
        return $blogs;
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