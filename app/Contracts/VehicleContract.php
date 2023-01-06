<?php

namespace App\Contracts;

/**
 * Interface VehicleContract
 * @package App\Contracts
 */
interface VehicleContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listVehicles(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findVehicleById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createVehicle(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateVehicle(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteVehicle($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsVehicle($id);
}