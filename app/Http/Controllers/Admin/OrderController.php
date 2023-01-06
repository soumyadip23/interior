<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\OrderContract;
use App\Contracts\DeliveryBoyContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class OrderController extends BaseController
{
    /**
     * @var OrderContract
     */
    protected $orderRepository;
    protected $deliveryBoyRepository;


    /**
     * PageController constructor.
     * @param OrderContract $orderRepository
     * @param DeliveryBoyContract $deliveryBoyRepository
     */
    public function __construct(OrderContract $orderRepository, DeliveryBoyContract $deliveryBoyRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->deliveryBoyRepository = $deliveryBoyRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $order_id = (isset($_GET['order_id']) && $_GET['order_id']!='')?$_GET['order_id']:'';
        $name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
        $mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
        $start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'';
        $end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'';
        $restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';
        $status = (isset($_GET['status']) && $_GET['status']!='')?$_GET['status']:'';

        $orders = $this->orderRepository->allOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id,$status);

        $this->setPageTitle('Order List', 'List of all orders');
        return view('admin.order.index', compact('orders'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $order = $this->orderRepository->getDetails($id);

        $boys = $this->deliveryBoyRepository->getAllBoys();
        
        $this->setPageTitle('Order Details', 'Order No : ');
        return view('admin.order.details', compact('order','boys'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {
        $order_id = (isset($_GET['order_id']) && $_GET['order_id']!='')?$_GET['order_id']:'';
        $name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
        $mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
        $start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'';
        $end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'';
        $restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';

        $orders = $this->orderRepository->newOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id);

        $boys = $this->deliveryBoyRepository->getAllBoys();

        $this->setPageTitle('New Orders', 'List of new orders');
        return view('admin.order.new', compact('orders','boys'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ongoing()
    {
        $order_id = (isset($_GET['order_id']) && $_GET['order_id']!='')?$_GET['order_id']:'';
        $name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
        $mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
        $start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'';
        $end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'';
        $restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';
        
        $orders = $this->orderRepository->ongoingOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id);

        $boys = $this->deliveryBoyRepository->getAllBoys();

        $this->setPageTitle('Ongoing Orders', 'List of ongoing orders');
        return view('admin.order.ongoing', compact('orders','boys'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delivered()
    {
        $order_id = (isset($_GET['order_id']) && $_GET['order_id']!='')?$_GET['order_id']:'';
        $name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
        $mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
        $start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'';
        $end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'';
        $restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';
        
        $orders = $this->orderRepository->deliveredOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id);

        $this->setPageTitle('Delivered Orders', 'List of delivered orders');
        return view('admin.order.delivered', compact('orders'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cancelled()
    {
        $order_id = (isset($_GET['order_id']) && $_GET['order_id']!='')?$_GET['order_id']:'';
        $name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
        $mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
        $start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'';
        $end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'';
        $restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';
        $cancelled_by = (isset($_GET['cancelled_by']) && $_GET['cancelled_by']!='')?$_GET['cancelled_by']:'';
        
        $orders = $this->orderRepository->cancelledOrders($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id,$cancelled_by);

        $this->setPageTitle('Cancelled Orders', 'List of cancelled orders');
        return view('admin.order.cancelled', compact('orders'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function assignDeliveryBoy(Request $request)
    {
        $this->validate($request, [
            'id'      =>  'required',
            'delivery_boy_id' => 'required'
        ]);

        $params = $request->except('_token');

        $order = $this->orderRepository->assignDeliveryBoy($params);

        if (!$order) {
            return $this->responseRedirectBack('Error occurred while updating order.', 'error', true, true);
        }
        return $this->responseRedirectBack('Delivery boy has been assigned successfully' ,'success',false, false);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function salesReport()
    {
        $start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:date("Y-m-01");
        $end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:date("Y-m-31");
        $restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';
        $status = (isset($_GET['status']) && $_GET['status']!='')?$_GET['status']:'';

        $orders = $this->orderRepository->fetchSalesData($start_date,$end_date,$restaurant_id,$status);

        $this->setPageTitle('Sales Data', 'List of all sales data');
        return view('admin.order.sales', compact('orders'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function onlineTransactions()
    {
        $order_id = (isset($_GET['order_id']) && $_GET['order_id']!='')?$_GET['order_id']:'';
        $name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
        $mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
        $start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'';
        $end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'';
        $restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';
        $status = (isset($_GET['status']) && $_GET['status']!='')?$_GET['status']:'';

        $orders = $this->orderRepository->onlineTransactions($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id);

        $this->setPageTitle('Online Transactions', 'List of all online transactions');
        return view('admin.order.transaction', compact('orders'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report()
    {
        $order_id = (isset($_GET['order_id']) && $_GET['order_id']!='')?$_GET['order_id']:'';
        $name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
        $mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
        $start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'';
        $end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'';
        $restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';
        $status = (isset($_GET['status']) && $_GET['status']!='')?$_GET['status']:'';
        $delivery_boy_id = (isset($_GET['delivery_boy_id']) && $_GET['delivery_boy_id']!='')?$_GET['delivery_boy_id']:'';
        $payment_mode = (isset($_GET['payment_mode']) && $_GET['payment_mode']!='')?$_GET['payment_mode']:'';

        $orders = $this->orderRepository->orderReports($order_id,$name,$mobile,$start_date,$end_date,$restaurant_id,$status,$delivery_boy_id,$payment_mode);

        $this->setPageTitle('Order List', 'List of all orders');
        return view('admin.order.report', compact('orders'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report_details($id)
    {
        $order = $this->orderRepository->getDetails($id);

        $boys = $this->deliveryBoyRepository->getAllBoys();
        
        $this->setPageTitle('Order Details', 'Order No : ');
        return view('admin.order.report_details', compact('order','boys'));
    }
}
?>