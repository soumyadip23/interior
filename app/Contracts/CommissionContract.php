<?php

namespace App\Contracts;

/**
 * Interface CommissionContract
 * @package App\Contracts
 */
interface CommissionContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCommissions(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findCommissionById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createCommission(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCommission(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCommission($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsCommission($id);
}