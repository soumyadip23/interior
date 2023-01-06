<?php

namespace App\Contracts;

/**
 * Interface NotificationContract
 * @package App\Contracts
 */
interface NotificationContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listNotifications(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findNotificationById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createNotification(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateNotification(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteNotification($id);

    /**
     * @return mixed
     */
    public function sosNotifications();
}