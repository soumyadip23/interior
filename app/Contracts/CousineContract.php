<?php

namespace App\Contracts;

/**
 * Interface CousineContract
 * @package App\Contracts
 */
interface CousineContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCousines(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findCousineById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createCousine(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCousine(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCousine($id);

     /**
     * @param $id
     * @return mixed
     */
    public function detailsCousine($id);

    /**
     * @return mixed
     */
    public function getCuisineList();

    /**
     * @return mixed
     */
    public function getTrendingCuisineList();

    /**
     * @param $keyword
     * @return Cousine|mixed
     */
    public function searchCuisines($keyword);
}