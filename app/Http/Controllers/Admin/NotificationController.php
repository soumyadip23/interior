<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\NotificationContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Restaurant;

class NotificationController extends BaseController
{
    /**
     * @var NotificationContract
     */
    protected $notificationRepository;


    /**
     * NotificationController constructor.
     * @param NotificationContract $notificationRepository
     */
    public function __construct(NotificationContract $notificationRepository){
        $this->notificationRepository = $notificationRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $notifications = $this->notificationRepository->listNotifications();

        $restaurants = Restaurant::where('status','1')->get();

        $this->setPageTitle('Notification', 'List of all notifications');
        return view('admin.notification.index', compact('notifications','restaurants'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $restaurants = Restaurant::where('status','1')->get();

        $this->setPageTitle('Notification', 'Create Notification');
        return view('admin.notification.create',compact('restaurants'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'      =>  'required|max:191',
            'description'     =>  'required',
        ]);

        $params = $request->except('_token');
        
        $notification = $this->notificationRepository->createNotification($params);

        if (!$notification) {
            return $this->responseRedirectBack('Error occurred while creating notification.', 'error', true, true);
        }
        return $this->responseRedirect('admin.notification.index', 'Notification has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetNotification = $this->notificationRepository->findBlogById($id);
        
        $this->setPageTitle('Blog', 'Edit Blog : '.$targetNotification->title);
        return view('admin.notification.edit', compact('targetNotification'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'title'      =>  'required|max:191',
            'description'     =>  'required',
        ]);

        $params = $request->except('_token');

        $notification = $this->notificationRepository->updateNotification($params);

        if (!$notification) {
            return $this->responseRedirectBack('Error occurred while updating notification.', 'error', true, true);
        }
        return $this->responseRedirectBack('Notification has been updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $notification = $this->notificationRepository->deleteNotification($id);

        if (!$notification) {
            return $this->responseRedirectBack('Error occurred while deleting notification.', 'error', true, true);
        }
        return $this->responseRedirect('admin.notification.index', 'Notification has been deleted successfully' ,'success',false, false);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sos()
    {
        $notifications = $this->notificationRepository->sosNotifications();

        $this->setPageTitle('SOS Notification', 'List of SOS notifications');
        return view('admin.notification.sos_notifications', compact('notifications'));
    }
}
