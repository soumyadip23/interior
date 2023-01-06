<?php

namespace App\Contracts;

/**
 * Interface CouponContract
 * @package App\Contracts
 */
interface CouponContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCoupons(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findCouponById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createCoupon(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCoupon(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCoupon($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsCoupon($id);

    /**
     * @return mixed
     */
    public function activeCoupons();
}