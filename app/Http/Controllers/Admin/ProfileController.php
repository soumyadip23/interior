<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Admin;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Admin\AdminService;

class ProfileController extends BaseController
{
    protected $adminService;
    
    /**
     * ProfileController constructor
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
		$profile = $this->adminService->fetchProfile(Auth::user()->id);
        $this->setPageTitle('Profile', 'Manage Profile');
        return view('admin.profile.index', compact('profile'));
    }

    /**
     * @param Request $request
     */
    public function update(Request $request)
    {
        $updateRequest = $request->all();
        $id = Auth::user()->id;

        $this->adminService->updateProfile($updateRequest, $id);
        return $this->responseRedirectBack('Profile updated successfully.', 'success');
    }

    /**
     * @param Request $request
     */
    public function changePassword(Request $request) {
        $id = Auth::user()->id;
        $info = $this->adminService->changePassword($request, $id);

        if ($info['type'] == 'error') {
            return $this->responseRedirectBack($info['message'], $info['type'], true, true, '#password');
        } else {
            return $this->responseRedirectBack($info['message'], $info['type'], false, false, '#password');
        }
    }
}
