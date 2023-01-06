<?php

namespace App\Contracts;

/**
 * Interface LocationContract
 * @package App\Contracts
 */
interface LocationContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listLocations(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findLocationById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createLocation(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateLocation(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteLocation($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsLocation($id);
}