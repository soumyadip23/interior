<?php
namespace App\Repositories;

use App\Models\Notification;
use App\Models\SosNotification;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\NotificationContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class NotificationRepository
 *
 * @package \App\Repositories
 */
class NotificationRepository extends BaseRepository implements NotificationContract
{
    use UploadAble;

    /**
     * NotificationRepository constructor.
     * @param Notification $model
     */
    public function __construct(Notification $model)
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
    public function listNotifications(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findNotificationById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Notification|mixed
     */
    public function createNotification(array $params)
    {
        try {

            $collection = collect($params);

            $notification = new Notification;
            $notification->title = $collection['title'];
            $notification->description = $collection['description'];
            $notification->type = $collection['type'];
            $notification->customer_type = $collection['customer_type'];
            $notification->restaurant_id = $collection['restaurant_id'];
            
            $notification->save();

            return $notification;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateNotification(array $params)
    {
        $notification = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $notification->title = $collection['title'];
        $notification->description = $collection['description'];
        $notification->type = $collection['type'];

        $notification->save();

        return $notification;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteNotification($id)
    {
        $notification = $this->findOneOrFail($id);
        $notification->delete();
        return $notification;
    }

    /**
     * @return mixed
     */
    public function sosNotifications(){
        $notifications = SosNotification::with('boy')->get();

        return $notifications;
    }
}