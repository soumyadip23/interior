<?php

namespace App\Services\Admin;

use App\Contracts\AdminContract;
use App\Models\AdPackages;
use Illuminate\Support\Facades\Hash;
use Auth;

class AdminService
{
    protected $adminRepository;

    /**
     * class AdminService constructor
     */
    public function __construct(AdminContract $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Fetch Admin profile details
     * @param int $id
     * @return Admin|mixed
     */
    public function fetchProfile($id) {
        return $this->adminRepository->findAdminById($id);
    }

    /**
     * Fetch Admin update profile
     * @param Request $request, int $id
     * @return Admin|mixed
     */
    public function updateProfile($request, $id) {
        return $this->adminRepository->updateProfile($request, $id);
    }

    /**
     * Fetch Admin change password
     * @param Request $request, int $id
     * @return mixed
     */
    public function changePassword($request, $id) {

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
            
            $this->adminRepository->updatePassword($request->all(), $id);

            $info['message'] = 'Password updated successfully.';
            $info['type'] = 'success';
            $info['redirect'] = '#password';
            return $info;
        }
    }

    /**
     * Fetch List of Users
     * @return mixed
     */
    public function fetchUsers() {
        return $this->userRepository->listUsers();
    }

    /**
     * Fetch individual User
     * @param int $id
     * @return mixed
     */
    public function fetchUserById($id) {
        $user = $this->profileRepository->showProfileById($id);
        //$ads = $this->adsRepository->fetchAdsByUser($id);
        $ads = array();
        $adDatas = $this->adsRepository->fetchAdsByUser($id);

        foreach($adDatas as $ad){
            $packages = $ad->packages;

            $package_name = '';
            $package_expire_date = '';
            $add_on_name = '';
            $add_on_expire_date = '';
            foreach ($packages as $p) {
                if($p->package_type=='basic_package'){
                    $package_name = $this->packageRepository->findPackageById($p->package_id)->name;
                    $package_expire_date = $p->expiry_date;
                }

                if($p->package_type=='add_on'){
                    $add_on_name = $this->packageRepository->findPackageById($p->package_id)->name;
                    $add_on_expire_date = $p->expiry_date;
                }
            }

            $ad->package_name = $package_name;
            $ad->package_expire_date = $package_expire_date;
            $ad->add_on_name = $add_on_name;
            $ad->add_on_expire_date = $add_on_expire_date;
            array_push($ads, $ad);
        }
        //$payments = $this->paymentRepository->getPaymentListByUserId($id);

        $payments = array();
        $paymentsData = $this->paymentRepository->getPaymentListByUserId($id);

        foreach($paymentsData as $payment){
            $packages = AdPackages::with('package')->where('ad_id',$payment->ad_id)->get();

            $package_name = '';
            $package_expire_date = '';
            $add_on_name = '';
            $add_on_expire_date = '';
            foreach ($packages as $p) {
                if($p->package_type=='basic_package'){
                    $package_name = $this->packageRepository->findPackageById($p->package_id)->name;
                    $package_expire_date = $p->expiry_date;
                }

                if($p->package_type=='add_on'){
                    $add_on_name = $this->packageRepository->findPackageById($p->package_id)->name;
                    $add_on_expire_date = $p->expiry_date;
                }
            }

            $payment->package_name = $package_name;
            $payment->package_expire_date = $package_expire_date;
            $payment->add_on_name = $add_on_name;
            $payment->add_on_expire_date = $add_on_expire_date;

            array_push($payments, $payment);
        }
        $userDetails = User::where('id',$id)->first();

        return array('user'=>$user, 'ads'=>$ads,'userDetails'=>$userDetails,'payments'=>$payments);
    }

    /**
     * Block individual User
     * @param int $id
     * @param int $is_block
     * @return boolean
     */
    public function blockUser($id,$is_block){

        return $this->userRepository->blockUser($id,$is_block);
    }

    /**
     * Fetch payment details
     * @param int $id
     * @return mixed
     */
    public function fetchPaymentDetails($id){
        return $this->paymentRepository->getPaymentDetails($id);
    }
}