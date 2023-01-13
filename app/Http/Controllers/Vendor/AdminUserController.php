<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Invitation;
use Illuminate\Support\Collection;

class AdminUserController extends BaseController
{
    public function index() {
        $admins = Admin::where('id', '!=', 1)->orderBy('created_at', 'desc')->get();
        $invite_admin = Invitation::whereNull('registered_at')->get();
        $users = $admins->merge($invite_admin)->toArray();
        $this->setPageTitle('Admin Users', '');
        return view('admin.auth.index', compact('users'));
    }

    /**
     * Update user with approve or block status
     * @param Request $request 
     */
    public function updateAdminUser(Request $request)
    {
    	$user_id = $request->id;
    	$update_array=array();

    	if($request->has('is_block'))
    	{
    		$is_block = $request->is_block;
    		$update_array = ['is_block'=>$is_block];
    	}
    	
    	$updated_id = Admin::where('id',$user_id)->update($update_array);
    	return response()->json(array('message'=>'Successfully updated'));
    }
}
