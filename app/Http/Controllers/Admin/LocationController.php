<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\LocationContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class LocationController extends BaseController
{
    /**
     * @var LocationContract
     */
    protected $locationRepository;


    /**
     * PageController constructor.
     * @param LocationContract >locationRepository
     */
    public function __construct(LocationContract $locationRepository)
    {
        $this->locationRepository = $locationRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $locations = $this->locationRepository->listLocations();

        $this->setPageTitle('Location', 'List of all locations');
        return view('admin.location.index', compact('locations'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Location', 'Create Location');
        return view('admin.location.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required',
            'lat'     =>  'required',
            'lng'     =>  'required',
        ]);

        $params = $request->except('_token');
        
        $location = $this->locationRepository->createLocation($params);

        if (!$location) {
            return $this->responseRedirectBack('Error occurred while creating location.', 'error', true, true);
        }
        return $this->responseRedirect('admin.location.index', 'Location has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetLocation = $this->locationRepository->findLocationById($id);
        
        $this->setPageTitle('Location', 'Edit Location : '.$targetLocation->title);
        return view('admin.location.edit', compact('targetLocation'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required',
            'lat'     =>  'required',
            'lng'     =>  'required',
        ]);

        $params = $request->except('_token');

        $location = $this->locationRepository->updateLocation($params);

        if (!$location) {
            return $this->responseRedirectBack('Error occurred while updating location.', 'error', true, true);
        }
        return $this->responseRedirectBack('Location has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $location = $this->locationRepository->deleteLocation($id);

        if (!$location) {
            return $this->responseRedirectBack('Error occurred while deleting location.', 'error', true, true);
        }
        return $this->responseRedirect('admin.location.index', 'Location has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $location = $this->locationRepository->updateLocationStatus($params);

        if ($location) {
            return response()->json(array('message'=>'Location status has been successfully updated'));
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
