<?php

namespace App\Contracts;

/**
 * Interface RestaurantContract
 * @package App\Contracts
 */
interface RestaurantContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listRestaurants(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findRestaurantById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createRestaurant(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateRestaurant(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteRestaurant($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsRestaurant($id);

    /**
     * @param $id
     * @return mixed
     */
    public function restaurantWiseItems($id);

    /**
     * @param $id
     * @return mixed
     */
    public function restaurantWiseActiveItems($id);

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findItemById(int $id);

    /**
     * @param array $params
     * @return Item|mixed
     */
    public function createItem(array $params);

    /**
     * @param array $params
     * @return Item|mixed
     */
    public function updateItem(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateItemStatus(array $params);

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteItem($id);

    /**
     * @param $id
     * @return mixed
     */
    public function restaurantTransactions($id);

    /**
     * @param $id
     * @return mixed
     */
    public function restaurantReviews($id);

    /**
     * @param $id
     * @return mixed
     */
    public function restaurantDetails($id);

    /**
     * @param array $params
     * @return Restaurant|mixed
     */
    public function restaurantLogin(array $params);

    /**
     * @param $cuisineId
     * @param double $lat
     * @param double $lng
     * @return Restaurant|mixed
     */
    public function cuisineWiseRestaurants($cuisineId,$lat,$lng);

    /**
     * @param double $lat
     * @param double $lng
     * @return mixed
     */
    public function getTrendingRestaurantList($lat,$lng);

    /**
     * @param double $lat
     * @param double $lng
     * @return mixed
     */
    public function getPocketFriendlyRestaurantList($lat,$lng);

    /**
     * @param array $params
     * @return RestaurantReview|mixed
     */
    public function addRestaurantReview(array $params);

    /**
     * @param $keyword
     * @return Restaurant|mixed
     */
    public function searchRestaurants($keyword);

    /**
     * @return mixed
     */
    public function getActiveRestaurants();

    /**
     * @param $name
     * @param $mobile
     * @param $address
     * @param $status
     * @return mixed
     */
    public function searchRestaurantData($name,$mobile,$address,$status);
}