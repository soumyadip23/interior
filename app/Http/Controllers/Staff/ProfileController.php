<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Admin;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Admin\AdminService;
use App\Models\Vendor;
use App\Models\DeliveryBoy;

class ProfileController extends BaseController
{
    protected $adminService;
    
    /**
     * ProfileController constructor
     */
    public function __construct(AdminService $adminService)
    {
      //  $this->adminService = $adminService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //echo Auth::user()->id; die;
		//$profile = $this->adminService->fetchProfile(Auth::user()->id);

        $profile = DeliveryBoy::where('id', Auth::user()->id)->first();

        //dd($profile); 
        $this->setPageTitle('Profile', 'Manage Profile');
        return view('vendor.profile.index', compact('profile'));
    }

    /**
     * @param Request $request
     */
    public function update(Request $request)
    {
        $updateRequest = $request->all();
        $id = Auth::user()->id;

        //$this->adminService->updateProfile($updateRequest, $id);

        $vendor = Vendor::where('id', Auth::user()->id)->first();
        $collection = collect($updateRequest)->except('_token');
        if ($collection->has('name')) {
            $vendor->name = $collection['name'];
            $vendor->save();
        }

        return $this->responseRedirectBack('Profile updated successfully.', 'success');
    }

    /**
     * @param Request $request
     */
    public function changePassword(Request $request) {
        $id = Auth::user()->id;
        //$info = $this->adminService->changePassword($request, $id);

        $info = array();
        if ($request->has('current_password') && $request->has('new_password')) {

            if (!(Hash::check($request->current_password, Auth::user()->password))) {
                // The passwords matches
                $info['message'] = 'Your current password does not matches with the password you provided. Please try again.';
                $info['type'] = 'error';
                $info['redirect'] = '#password';
                return $info;
            }
    
            if(strcmp($request->current_password, $request->new_password) == 0){
                //Current password and new password are same
                $info['message'] = 'New Password cannot be same as your current password. Please choose a different password.';
                $info['type'] = 'error';
                $info['redirect'] = '#password';
                return $info;
            }

            if(strcmp($request->new_password, $request->new_confirm_password) != 0){
                //Current password and new password are same
                $info['message'] = 'New Password and confirm password must be same. Please try again.';
                $info['type'] = 'error';
                $info['redirect'] = '#password';
                return $info;
            }
            
         
            $vendor = Vendor::where('id', Auth::user()->id)->first();

            $collection = collect($request->all())->except('_token');
            if ($collection->has('current_password')) {
                $vendor->update(['password'=> Hash::make($collection['new_password'])]);
            }

            $info['message'] = 'Password updated successfully.';
            $info['type'] = 'success';
            $info['redirect'] = '#password';
            return $info;
        }

        if ($info['type'] == 'error') {
            return $this->responseRedirectBack($info['message'], $info['type'], true, true, '#password');
        } else {
            return $this->responseRedirectBack($info['message'], $info['type'], false, false, '#password');
        }
    }
}
