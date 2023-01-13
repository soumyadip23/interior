<?php

namespace App\Contracts;

/**
 * Interface LeadContract
 * @package App\Contracts
 */
interface ItemContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listItems(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findItemById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createItem(array $params);


    /**
     * @param array $params
     * @return mixed
     */
    public function updateItem(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteItem($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsItem($id);

    /**
     * @return mixed
     */
    public function getItems();

    /**
     * @return mixed
     */
    public function getItemcategories();

    /**
     * @return mixed
     */
    public function latestItems();

    /**
     * @return mixed
     */
   
    /**
     * @param $categoryId
     * @param $id
     * @return mixed
     */
    public function getRelatedItems($categoryId,$id);

    /**
     * @param $categoryId
     * @return mixed
     */
    public function categoryWiseItems($categoryId);
}