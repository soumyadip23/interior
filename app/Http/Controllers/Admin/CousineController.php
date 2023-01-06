<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\CousineContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class CousineController extends BaseController
{
    /**
     * @var CousineContract
     */
    protected $cousineRepository;


    /**
     * CategoryController constructor.
     * @param CousineContract $cousineRepository
     */
    public function __construct(CousineContract $cousineRepository)
    {
        $this->cousineRepository = $cousineRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $cousines = $this->cousineRepository->listCousines();

        $this->setPageTitle('Cuisine', 'List of all cuisines');
        return view('admin.cousine.index', compact('cousines'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Cuisine', 'Create cuisine');
        return view('admin.cousine.create');
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
        ]);

        $params = $request->except('_token');
        
        $cousine = $this->cousineRepository->createCousine($params);

        if (!$cousine) {
            return $this->responseRedirectBack('Error occurred while creating cousine.', 'error', true, true);
        }
        return $this->responseRedirect('admin.cousine.index', 'Cousine has been created successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetCousine = $this->cousineRepository->findCousineById($id);
        
        $this->setPageTitle('Cuisine', 'Edit cuisine : '.$targetCousine->title);
        return view('admin.cousine.edit', compact('targetCousine'));
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
        ]);

        $params = $request->except('_token');

        $cousine = $this->cousineRepository->updateCousine($params);

        if (!$cousine) {
            return $this->responseRedirectBack('Error occurred while updating cousine.', 'error', true, true);
        }
        return $this->responseRedirectBack('Cousine has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $cousine = $this->cousineRepository->deleteCousine($id);

        if (!$cousine) {
            return $this->responseRedirectBack('Error occurred while deleting cousine.', 'error', true, true);
        }
        return $this->responseRedirect('admin.cousine.index', 'Cousine has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $cousine = $this->cousineRepository->updateCousineStatus($params);

        if ($cousine) {
            return response()->json(array('message'=>'Cousine status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        
    }
}
