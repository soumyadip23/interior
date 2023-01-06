<?php

namespace App\Contracts;

/**
 * Interface OrderContract
 * @package App\Contracts
 */
interface OrderContract
{
    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @param $status
     * @return mixed
     */
    public function allOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id,$status);

    /**
     * @param $id
     * @return mixed
     */
    public function getDetails($id);

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @return mixed
     */
    public function newOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id);

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @return mixed
     */
    public function ongoingOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id);

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @return mixed
     */
    public function deliveredOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id);

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @param $cancelled_by
     * @return mixed
     */
    public function cancelledOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id,$cancelled_by);

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
     * @param $boyId
     * @return Order|mixed
     */
    public function ongoingOrdersForDeliveryBoys($boyId);

    /**
     * @param $boyId
     * @return Order|mixed
     */
    public function deliveredOrdersForDeliveryBoys($boyId);

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

    /**
     * @param array $params
     * @return Order|mixed
     */
    public function customerCancelOrder(array $params);

    /**
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @return mixed
     */
    public function fetchSalesData($start_date,$end_date,$restaurant_id,$status);

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @param $status
     * @return mixed
     */
    public function onlineTransactions($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id);

    /**
     * @param $order_id
     * @param $name
     * @param $mobile
     * @param $start_date
     * @param $end_date
     * @param $restaurant_id
     * @param $status
     * @param $delivery_boy_id
     * @param $payment_mode
     * @return mixed
     */
    public function orderReports($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id,$status,$delivery_boy_id,$payment_mode);
}