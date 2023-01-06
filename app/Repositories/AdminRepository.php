<?php
namespace App\Repositories;

use App\Models\Admin;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\AdminContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Hash;

/**
 * Class PageRepository
 *
 * @package \App\Repositories
 */
class AdminRepository extends BaseRepository implements AdminContract
{
    use UploadAble;

    /**
     * AdminRepository constructor.
     * @param Admin $model
     */
    public function __construct(Admin $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listAdmins(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findAdminById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function createAdmin(array $params)
    {

    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateProfile(array $params, int $id)
    {
        $admin = $this->findAdminById($id);
        $collection = collect($params)->except('_token');
        if ($collection->has('name')) {
            $admin->name = $collection['name'];
            $admin->save();
        }
        return $admin;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePassword(array $params, int $id)
    {
        $admin = $this->findAdminById($id);
        $collection = collect($params)->except('_token');
        if ($collection->has('current_password')) {
            $admin->update(['password'=> Hash::make($collection['new_password'])]);
        }
        return $admin;
    }
}