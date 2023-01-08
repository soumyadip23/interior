<?php

namespace App\Contracts;

/**
 * Interface LeadContract
 * @package App\Contracts
 */
interface LeadContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listLeads(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findLeadById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createLead(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateLead(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteLead($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsLead($id);

    /**
     * @return mixed
     */
    public function getLeads();

    /**
     * @return mixed
     */
    public function getBlogcategories();

    /**
     * @return mixed
     */
    public function latestBlogs();

    /**
     * @return mixed
     */
    public function getBlogtags();

    /**
     * @param $categoryId
     * @param $id
     * @return mixed
     */
    public function getRelatedBlogs($categoryId,$id);

    /**
     * @param $categoryId
     * @return mixed
     */
    public function categoryWiseBlogs($categoryId);
}