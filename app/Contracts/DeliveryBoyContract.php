<?php

namespace App\Contracts;

/**
 * Interface DeliveryBoyContract
 * @package App\Contracts
 */
interface DeliveryBoyContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listDeliveryBoys(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findDeliveryBoyById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createDeliveryBoy(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateDeliveryBoy(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteDeliveryBoy($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsDeliveryBoy($id);

    /**
     * @return mixed
     */
    public function getAllBoys();

    /**
     * @param array $params
     * @return DeliveryBoy|mixed
     */
    public function boyLogin(array $params);
}