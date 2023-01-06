<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\IncentiveContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class IncentiveController extends BaseController
{
    /**
     * @var IncentiveContract
     */
    protected $incentiveRepository;


    /**
     * IncentiveController constructor.
     * @param IncentiveContract >incentiveRepository
     */
    public function __construct(IncentiveContract $incentiveRepository)
    {
        $this->incentiveRepository = $incentiveRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $incentives = $this->incentiveRepository->listIncentives();

        $this->setPageTitle('Incentive', 'List of all incentives');
        return view('admin.incentive.index', compact('incentives'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Incentive', 'Create incentive');
        return view('admin.incentive.create');
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
        
        $incentives = $this->incentiveRepository->createIncentive($params);

        if (!$incentives) {
            return $this->responseRedirectBack('Error occurred while creating incentives.', 'error', true, true);
        }
        return $this->responseRedirect('admin.incentive.index', 'Incentives has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetIncentive = $this->incentiveRepository->findIncentiveById($id);
        
        $this->setPageTitle('Incentive', 'Edit incentive : '.$targetIncentive->title);
        return view('admin.incentive.edit', compact('targetIncentive'));
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

        $incentive = $this->incentiveRepository->updateIncentive($params);

        if (!$incentive) {
            return $this->responseRedirectBack('Error occurred while updating incentive.', 'error', true, true);
        }
        return $this->responseRedirectBack('Incentive has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $commission = $this->incentiveRepository->deleteCommission($id);

        if (!$commission) {
            return $this->responseRedirectBack('Error occurred while deleting commission.', 'error', true, true);
        }
        return $this->responseRedirect('admin.incentive.index', 'Commission has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $incentive = $this->incentiveRepository->updateIncentiveStatus($params);

        if ($incentive) {
            return response()->json(array('message'=>'Incentive status has been successfully updated'));
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
