<?php

namespace App\Http\Controllers\Admin;

use App\Models\DeliveryBoy;
use App\Contracts\DeliveryBoyContract;
use App\Contracts\VehicleContract;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Session;

class DeliveryBoyController extends BaseController
{

    protected $deliveryBoyRepository;
    protected $vehicleRepository;

    /**
     * DeliveryBoyController constructor.
     * @param deliveryBoyRepository $deliveryBoyRepository
     */

    public function __construct(DeliveryBoyContract $deliveryBoyRepository, VehicleContract $vehicleRepository)
    {
        $this->deliveryBoyRepository = $deliveryBoyRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * List all the users
     */
    public function index()
    {
    	$boys = $this->deliveryBoyRepository->getAllBoys();
    	$this->setPageTitle('Delivery Boys', 'List of all delivery boys');
    	return view('admin.boys.index',compact('boys'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $vehicles = $this->vehicleRepository->listVehicles();

        $this->setPageTitle('Delivery Boy', 'Create Delivery Boy');

        return view('admin.boys.create',compact('vehicles'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:50',
            'email'     =>  'required',
            'password'  =>  'required',
            'mobile'    =>  'required|numeric',
            'gender'    =>  'required',
        ]);

        $params = $request->except('_token');
        
        $boy = $this->deliveryBoyRepository->createDeliveryBoy($params);

        if (!$boy) {
            return $this->responseRedirectBack('Error occurred while creating boy.', 'error', true, true);
        }
        return $this->responseRedirect('admin.boys.index', 'New delivery boy has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetBoy = $this->deliveryBoyRepository->findDeliveryBoyById($id);

        $vehicles = $this->vehicleRepository->listVehicles();
        
        $this->setPageTitle('Delivery Boy', 'Edit delivery boy : '.$targetBoy->name);
        return view('admin.boys.edit', compact('targetBoy','vehicles'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
         $this->validate($request, [
            'name'      =>  'required|max:50',
            'email'     =>  'required',
            'gender'    =>  'required',
        ]);

        $params = $request->except('_token');

        $boy = $this->deliveryBoyRepository->updateDeliveryBoy($params);

        if (!$boy) {
            return $this->responseRedirectBack('Error occurred while updating boy.', 'error', true, true);
        }
        return $this->responseRedirectBack('Delivery boy has been updated successfully' ,'success',false, false);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $boy = $this->deliveryBoyRepository->deleteDeliveryBoy($id);

        if (!$boy) {
            return $this->responseRedirectBack('Error occurred while deleting boy.', 'error', true, true);
        }
        return $this->responseRedirect('admin.boys.index', 'Delivery boy has been deleted successfully' ,'success',false, false);
    }


    /**
     * Update boy with approve or block status
     * @param Request $request 
     */    
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $boy = $this->deliveryBoyRepository->updateDeliveryBoyStatus($params);

        if ($boy) {
            return response()->json(array('message'=>'Delivery boy status successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $boys = $this->deliveryBoyRepository->detailsDeliveryBoy($id);
        $boy = $boys[0];
        
        $this->setPageTitle('Delivery Boy', 'Boy Details : '.$boy->name);
        return view('admin.boys.details', compact('boy'));
    }

    public function locations($id)
    {
        $boys = $this->deliveryBoyRepository->detailsDeliveryBoy($id);
        $boy = $boys[0];
        
        $this->setPageTitle('Delivery Boy', 'Boy Details : '.$boy->name);
        return view('admin.boys.details', compact('boy'));
    }
}
