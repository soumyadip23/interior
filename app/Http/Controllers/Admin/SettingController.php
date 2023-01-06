<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\BaseController;

class SettingController extends BaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
		$setting = new Setting();
        $this->setPageTitle('Settings', 'Manage Settings');
        return view('admin.settings.index', compact('setting'));
    }

    /**
     * @param Request $request
     */
    public function update(Request $request)
    {
		$keys = $request->except('_token');
		foreach ($keys as $key => $value)
		{
			Setting::set($key, $value);
		}

	    return $this->responseRedirectBack('Settings updated successfully.', 'success');
    }
}
