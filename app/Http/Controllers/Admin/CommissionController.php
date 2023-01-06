<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\CommissionContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class CommissionController extends BaseController
{
    /**
     * @var CommissionContract
     */
    protected $commissionRepository;


    /**
     * CommissionController constructor.
     * @param CommissionContract >commissionRepository
     */
    public function __construct(CommissionContract $commissionRepository)
    {
        $this->commissionRepository = $commissionRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $commissions = $this->commissionRepository->listCommissions();

        $this->setPageTitle('Commission', 'List of all commissions');
        return view('admin.commission.index', compact('commissions'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Commission', 'Create Commission');
        return view('admin.commission.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'      =>  'required',
            'min_order'  =>  'required',
            'max_order'  =>  'required',
            'value'      =>  'required',
        ]);

        $params = $request->except('_token');
        
        $commission = $this->commissionRepository->createCommission($params);

        if (!$commission) {
            return $this->responseRedirectBack('Error occurred while creating commission.', 'error', true, true);
        }
        return $this->responseRedirect('admin.commission.index', 'Commission has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetCommission = $this->commissionRepository->findCommissionById($id);
        
        $this->setPageTitle('Commission', 'Edit Commission : '.$targetCommission->title);
        return view('admin.commission.edit', compact('targetCommission'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'title'      =>  'required',
            'min_order'  =>  'required',
            'max_order'  =>  'required',
            'value'      =>  'required',
        ]);

        $params = $request->except('_token');

        $commission = $this->commissionRepository->updateCommission($params);

        if (!$commission) {
            return $this->responseRedirectBack('Error occurred while updating commission.', 'error', true, true);
        }
        return $this->responseRedirectBack('Commission has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $commission = $this->commissionRepository->deleteCommission($id);

        if (!$commission) {
            return $this->responseRedirectBack('Error occurred while deleting commission.', 'error', true, true);
        }
        return $this->responseRedirect('admin.commission.index', 'Commission has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $commission = $this->commissionRepository->updateCommissionStatus($params);

        if ($commission) {
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
