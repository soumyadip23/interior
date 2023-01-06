<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\BlogContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class BlogController extends BaseController
{
    /**
     * @var BlogContract
     */
    protected $blogRepository;


    /**
     * PageController constructor.
     * @param BlogContract $blogRepository
     */
    public function __construct(BlogContract $blogRepository)
    {
        $this->blogRepository = $blogRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $blogs = $this->blogRepository->listBlogs();

        $this->setPageTitle('Blog', 'List of all blogs');
        return view('admin.blog.index', compact('blogs'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Blog', 'Create Blog');
        return view('admin.blog.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'      =>  'required|max:191',
            'image'     =>  'required|mimes:jpg,jpeg,png|max:1000',
            'description'     =>  'required',
        ]);

        $params = $request->except('_token');
        
        $blog = $this->blogRepository->createBlog($params);

        if (!$blog) {
            return $this->responseRedirectBack('Error occurred while creating blog.', 'error', true, true);
        }
        return $this->responseRedirect('admin.blog.index', 'Blog has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetBlog = $this->blogRepository->findBlogById($id);
        
        $this->setPageTitle('Blog', 'Edit Blog : '.$targetBlog->title);
        return view('admin.blog.edit', compact('targetBlog'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'title'      =>  'required|max:191',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000',
            'description'     =>  'required',
        ]);

        $params = $request->except('_token');

        $blog = $this->blogRepository->updateBlog($params);

        if (!$blog) {
            return $this->responseRedirectBack('Error occurred while updating blog.', 'error', true, true);
        }
        return $this->responseRedirectBack('Blog has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $blog = $this->blogRepository->deleteBlog($id);

        if (!$blog) {
            return $this->responseRedirectBack('Error occurred while deleting blog.', 'error', true, true);
        }
        return $this->responseRedirect('admin.blog.index', 'Blog has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $blog = $this->blogRepository->updateBlogStatus($params);

        if ($blog) {
            return response()->json(array('message'=>'Blog status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $blogs = $this->blogRepository->detailsBlog($id);
        $blog = $blogs[0];

        $this->setPageTitle('Blog', 'Blog Details : '.$blog->title);
        return view('admin.blog.details', compact('blog'));
    }
}
