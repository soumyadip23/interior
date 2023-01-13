<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect admins after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:vendor')->except('logout');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('vendor.auth.login');
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
      
        $this->validate($request, [
            'email'   => 'required',
            'password' => 'required|min:6'
        ]);

        $remember_me = $request->has('remember') ? true : false;
  
        if(is_numeric($request->get('email'))){
            if (Auth::guard('vendor')->attempt([
                'mobile' => $request->email,
                'password' => $request->password
            ], $remember_me)) {
                return redirect()->route('vendor.dashboard');
            }
        }
        else{
            if (Auth::guard('vendor')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ], $remember_me)) {
                return redirect()->route('vendor.dashboard');
            }
        }
       
        return back()->withInput($request->only('email', 'remember'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();
        $request->session()->invalidate();
        return redirect()->route('vendor.login');
    }
}