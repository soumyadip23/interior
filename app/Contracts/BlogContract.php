<?php

namespace App\Contracts;

/**
 * Interface BlogContract
 * @package App\Contracts
 */
interface BlogContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBlogs(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findBlogById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createBlog(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBlog(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteBlog($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsBlog($id);

    /**
     * @return mixed
     */
    public function getBlogs();

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