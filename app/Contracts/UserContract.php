<?php

namespace App\Contracts;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface UserContract
{
	/**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listUsers(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createUser(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateUser(array $params);

     /**
     * @param array $params
     * @return User|mixed
     */
    public function updateDeviceDetails(array $params);

    /**
     * @param int $id
     * @return mixed
     */
    public function getUserDetails(int $id);

    public function blockUser($id,$is_block);
    public function verify($id,$is_verified);
    public function updateUserStatus(array $params);
    /**
     * @param $id
     * @return bool
     */
    public function deleteUser($id);

    /**
     * @param $id
     * @return mixed
     */
    public function userReviews($id);

    /**
     * @param array $params
     * @return User|mixed
     */
    public function userRegistration(array $params);

    /**
     * @param $userId
     * @return mixed
     */
    public function adddressList($userId);

    /**
     * @param array $params
     * @return UserAddress|mixed
     */
    public function addAddress(array $params);

    /**
     * @param array $params
     * @return UserAddress|mixed
     */
    public function updateAddress(array $params);

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteAddress($id);

    /**
     * @param $name
     * @param $mobile
     * @param $email
     * @param $status
     * @param $order_placed
     * @return mixed
     */
    public function searchUserData($name,$mobile,$email,$status,$order_placed);
}