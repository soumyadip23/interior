<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\VehicleContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class VehicleController extends BaseController
{
    /**
     * @var VehicleContract
     */
    protected $vehicleRepository;


    /**
     * PageController constructor.
     * @param VehicleContract >vehicleRepository
     */
    public function __construct(VehicleContract $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $vehicles = $this->vehicleRepository->listVehicles();

        $this->setPageTitle('Vehicle', 'List of all vehicles');
        return view('admin.vehicle.index', compact('vehicles'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Vehicle', 'Create vehicle');
        return view('admin.vehicle.create');
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
        ]);

        $params = $request->except('_token');
        
        $vehicle = $this->vehicleRepository->createVehicle($params);

        if (!$vehicle) {
            return $this->responseRedirectBack('Error occurred while creating vehicle.', 'error', true, true);
        }
        return $this->responseRedirect('admin.vehicle.index', 'Vehicle has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetVehicle = $this->vehicleRepository->findVehicleById($id);
        
        $this->setPageTitle('Vehicle', 'Edit vehicle : '.$targetVehicle->title);
        return view('admin.vehicle.edit', compact('targetVehicle'));
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
        ]);

        $params = $request->except('_token');

        $vehicle = $this->vehicleRepository->updateVehicle($params);

        if (!$vehicle) {
            return $this->responseRedirectBack('Error occurred while updating vehicle.', 'error', true, true);
        }
        return $this->responseRedirectBack('Vehicle has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $vehicle = $this->vehicleRepository->deleteVehicle($id);

        if (!$vehicle) {
            return $this->responseRedirectBack('Error occurred while deleting vehicle.', 'error', true, true);
        }
        return $this->responseRedirect('admin.vehicle.index', 'Vehicle has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $vehicle = $this->vehicleRepository->updateVehicleStatus($params);

        if ($vehicle) {
            return response()->json(array('message'=>'Vehicle status has been successfully updated'));
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
