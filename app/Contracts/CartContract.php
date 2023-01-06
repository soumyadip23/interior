<?php

namespace App\Contracts;

/**
 * Interface CartContract
 * @package App\Contracts
 */
interface CartContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCarts(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findCartById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createCart(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCart(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCart($id);

    /**
     * @param $userId
     * @return bool|mixed
     */
    public function clearCart($userId);
}