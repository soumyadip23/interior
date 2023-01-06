<?php

namespace App\Contracts;

/**
 * Interface OrderContract
 * @package App\Contracts
 */
interface OrderContract
{
    /**
     * @return mixed
     */
    public function allOrders();

    /**
     * @param $id
     * @return mixed
     */
    public function getDetails($id);

    /**
     * @return mixed
     */
    public function newOrders();

    /**
     * @return mixed
     */
    public function ongoingOrders();

    /**
     * @return mixed
     */
    public function deliveredOrders();

     /**
     * @return mixed
     */
    public function cancelledOrders();

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function restaurantWiseOrders($restaurantId);

    /**
     * @param $userId
     * @return mixed
     */
    public function userWiseOrders($userId);

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function createOrder(array $params);

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function restaurantWiseNewOrders($restaurantId);

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function restaurantWiseOngoingOrders($restaurantId);

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function restaurantWiseDeliveredOrders($restaurantId);

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function restaurantWiseCancelledOrders($restaurantId);

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function acceptOrder(array $params);

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function cancelOrder(array $params);

    /**
     * @param $restaurantId
     * @return mixed
     */
    public function getRestaurantOrderSummary($restaurantId);

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function assignDeliveryBoy(array $params);

    /**
     * @param $boyId
     * @return Order|mixed
     */
    public function searchOrderForDeliveryBoys($boyId);

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function riderStarted(array $params);

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function reachedRestaurant(array $params);

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function orderPicked(array $params);

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function orderDelivered(array $params);
}