<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\CouponContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class CouponController extends BaseController
{
    /**
     * @var CouponContract
     */
    protected $couponRepository;

    /**
     * PageController constructor.
     * @param CouponContract $couponRepository
     */
    public function __construct(CouponContract $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $coupons = $this->couponRepository->listCoupons();

        $this->setPageTitle('Coupon', 'List of all coupons');
        return view('admin.coupon.index', compact('coupons'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Coupon', 'Create coupon');
        return view('admin.coupon.create');
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
        ]);

        $params = $request->except('_token');
        
        $coupon = $this->couponRepository->createCoupon($params);

        if (!$coupon) {
            return $this->responseRedirectBack('Error occurred while creating coupon.', 'error', true, true);
        }
        return $this->responseRedirect('admin.coupon.index', 'Coupon has been created successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetCoupon = $this->couponRepository->findCouponById($id);
        
        $this->setPageTitle('Coupon', 'Edit Coupon : '.$targetCoupon->title);
        return view('admin.coupon.edit', compact('targetCoupon'));
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
        ]);

        $params = $request->except('_token');

        $coupon = $this->couponRepository->updateCoupon($params);

        if (!$coupon) {
            return $this->responseRedirectBack('Error occurred while updating coupon.', 'error', true, true);
        }
        return $this->responseRedirectBack('Coupon has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $coupon = $this->couponRepository->deleteCoupon($id);

        if (!$coupon) {
            return $this->responseRedirectBack('Error occurred while deleting coupon.', 'error', true, true);
        }
        return $this->responseRedirect('admin.coupon.index', 'Category has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $coupon = $this->couponRepository->updateCouponStatus($params);

        if ($coupon) {
            return response()->json(array('message'=>'Coupon status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        // $categories = $this->couponRepository->detailsCategory($id);
        // $category = $categories[0];

        // $this->setPageTitle('Category', 'Category Details : '.$category->title);
        // return view('admin.category.details', compact('category'));
    }
}
