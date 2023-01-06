@extends('admin.app')
@section('title') Dashboard @endsection
@section('content')
@php
$users = App\Models\User::where('status','1')->get();
$new_orders = App\Models\Order::where('status','1')->get();
$ongoing_orders = App\Models\Order::where('status',array('2','3','4'))->get();
$delivered_orders = App\Models\Order::where('status','5')->get();
$cancelled_orders = App\Models\Order::where('status','6')->get();
$restaurants = App\Models\Restaurant::where('status','1')->get();

$orders = App\Models\Order::where('status','1')->where('is_deleted',0)->orderBy('id','desc')->take(10)->get();

$sales_data = array();

$sales_data_result = DB::select("SELECT restaurant_id, round(sum(total_amount)) as t_amount from orders
group by orders.restaurant_id order by t_amount desc limit 10");

foreach($sales_data_result as $sales){
    $restaurant_id = $sales->restaurant_id;

    $restaurant_data_result = DB::select("select * from restaurants where id='$restaurant_id'");

    $restaurant_name = $restaurant_data_result[0]->name;

    $sales->restaurant_name = $restaurant_name;

    array_push($sales_data,$sales);
}

$order_data = array();

$order_data_result = DB::select("SELECT restaurant_id, round(count(id)) as t_order from orders
group by orders.restaurant_id order by t_order desc limit 10");

foreach($order_data_result as $order){
    $restaurant_id = $order->restaurant_id;

    $restaurant_data_result = DB::select("select * from restaurants where id='$restaurant_id'");

    $restaurant_name = $restaurant_data_result[0]->name;

    $order->restaurant_name = $restaurant_name;

    array_push($order_data,$order);
}

//print_r($order_data);

@endphp
<style type="text/css">
    .row-md-body.no-nav {
    margin-top: 70px;
}
</style>
<div class="fixed-row">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        </div>
    </div>
</div>
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                    <h4>Active Users</h4>
                    <p><b> {{count($users)}} </b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fa fa-files-o fa-3x"></i>
                <div class="info">
                    <h4>New Orders</h4>
                    <p><b>{{count($new_orders)}} </b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fa fa-files-o fa-3x"></i>
                <div class="info">
                    <h4>Ongoing Orders</h4>
                    <p><b>{{count($ongoing_orders)}} </b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fa fa-files-o fa-3x"></i>
                <div class="info">
                    <h4>Delivered Orders</h4>
                    <p><b>{{count($delivered_orders)}} </b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fa fa-files-o fa-3x"></i>
                <div class="info">
                    <h4>Cancelled Orders</h4>
                    <p><b>{{count($cancelled_orders)}} </b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fa fa-files-o fa-3x"></i>
                <div class="info">
                    <h4>Active Restaurants</h4>
                    <p><b>{{count($restaurants)}} </b></p>
                </div>
            </div>
        </div>
    </div>
    <h4>Latest 10 New Orders</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Order No</th>
                                <th>Order Date</th>
                                <th>Restaurant</th>
                                <th>Customer Details</th>
                                <th>Order Amount </th>
                                
                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $key => $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->unique_id }}</td>
                                    <td>{{ date("d-M-Y h:i a",strtotime($order->created_at))}}</td>
                                    <td>{{ $order->restaurant->name }}</td>
                                    <td>{{ $order->name }}<br>Mobile : <br>{{ $order->mobile }}</td>
                                    <td>Rs. {{ $order->total_amount }}</td>
                                    
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('admin.order.details', $order['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
    <h4>Restaurant Wise Sales & Orders Report</h4>
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-6 col-lg-6">
            <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
        </div>
        <div class="col-md-6 col-lg-6">
            <canvas id="myChart1" style="width:100%;max-width:600px"></canvas>
        </div>
    </div>
    <div class="row section-mg row-md-body no-nav">

        <div class="col-md-6 col-lg-6">
            <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                <thead>
                    <tr>
                        <th>Restaurant</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales_data as $key => $s)
                        <tr>
                            <td>{{$s->restaurant_name}}</td>
                            <td>Rs. {{$s->t_amount}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6 col-lg-6">
            <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                <thead>
                    <tr>
                        <th>Restaurant</th>
                        <th>Total Orders</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order_data as $key => $s)
                        <tr>
                            <td>{{$s->restaurant_name}}</td>
                            <td>{{$s->t_order}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@php
$stores1 = array();
$sales_values1 = array();
foreach($sales_data as $s){
    array_push($stores1,$s->restaurant_name);
    array_push($sales_values1,$s->t_amount);
}

$users1 = array();
$sales_values2 = array();
foreach($order_data as $s){
    array_push($users1,$s->restaurant_name);
    array_push($sales_values2,$s->t_order);
}

@endphp
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
var xValues = [];
var yValues = [];
xValues = <?php echo json_encode($stores1); ?>;
console.log("stores1>>",xValues);
yValues = <?php echo json_encode($sales_values1); ?>;
console.log("stores1>>",yValues);
var barColors = ["red", "green","blue","orange","brown"];


new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Restaurant Wise Sales"
    }
  }
});
</script>
<script>
var xValues1 = [];
var yValues1 = [];
xValues1 = <?php echo json_encode($users1); ?>;
console.log("users1>>",xValues1);
yValues1 = <?php echo json_encode($sales_values2); ?>;
console.log("users1>>",yValues1);
var barColors = ["red", "green","blue","orange","brown"];


new Chart("myChart1", {
  type: "bar",
  data: {
    labels: xValues1,
    datasets: [{
      backgroundColor: barColors,
      data: yValues1
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Staff Wise Sales"
    }
  }
});
</script>
@endsection