<?php

namespace App\Contracts;

/**
 * Interface IncentiveContract
 * @package App\Contracts
 */
interface IncentiveContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listIncentives(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findIncentiveById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createIncentive(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateIncentive(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteIncentive($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsIncentive($id);
}