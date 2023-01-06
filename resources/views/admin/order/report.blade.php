@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@php
$restaurants = App\Models\Restaurant::where('status','1')->get();
$boys = App\Models\DeliveryBoy::where('status','1')->get();

$order_id = (isset($_GET['order_id']) && $_GET['order_id']!='')?$_GET['order_id']:'';
$name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
$mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
$start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'';
$end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'';
$restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';
$status = (isset($_GET['status']) && $_GET['status']!='')?$_GET['status']:'';
$delivery_boy_id = (isset($_GET['delivery_boy_id']) && $_GET['delivery_boy_id']!='')?$_GET['delivery_boy_id']:'';
$payment_mode = (isset($_GET['payment_mode']) && $_GET['payment_mode']!='')?$_GET['payment_mode']:'';
@endphp
    <style type="text/css">
        .details_badge_item{
            margin-right: 15px;
        }    
    </style>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    @include('admin.partials.flash')
    
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form action="">
                    <table class="table " id="">
                        <tbody>
                            <tr>
                                
                                <td style="padding: 10px 5px;">
                                    Order Id <br/>
                                    <input type="text" class="form-control" name="order_id" placeholder="Order Id" value="{{$order_id}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    Restaurant <br/>
                                    <select class="form-control" name="restaurant_id">
                                        <option value="">Select Restaurant</option>
                                        @foreach($restaurants as $restaurant)
                                        <option value="{{$restaurant->id}}" @if($restaurant_id==$restaurant->id){{"selected"}}@endif>{{$restaurant->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 10px 5px;">
                                    Delivery Agent <br/>
                                    <select class="form-control" name="delivery_boy_id">
                                        <option value="">Select Delivery Agent</option>
                                        @foreach($boys as $boy)
                                        <option value="{{$boy->id}}" @if($delivery_boy_id==$boy->id){{"selected"}}@endif>{{$boy->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 10px 5px;">
                                    Status <br/>
                                    <select class="form-control" name="status">
                                        <option value="">Select Status</option>
                                        <option value="1" @if($status=='1'){{"selected"}}@endif>New Order</option>
                                        <option value="2" @if($status=='2'){{"selected"}}@endif>Order Accepted</option>
                                        <option value="3" @if($status=='3'){{"selected"}}@endif>Agent Assigned</option>
                                        <option value="4" @if($status=='4'){{"selected"}}@endif>Order On Process</option>
                                        <option value="5" @if($status=='5'){{"selected"}}@endif>Rider Started</option>
                                        <option value="6" @if($status=='6'){{"selected"}}@endif>Reached Restaurant</option>
                                        <option value="7" @if($status=='7'){{"selected"}}@endif>Order Picked</option>
                                        <option value="8" @if($status=='8'){{"selected"}}@endif>Order Delivered</option>
                                        <option value="9" @if($status=='10'){{"selected"}}@endif>Order Cancelled</option>
                                    </select>
                                </td>
                                <td style="padding: 10px 5px;">
                                    Payment Mode <br/>
                                    <select class="form-control" name="payment_mode">
                                        <option value="">Select Option</option>
                                        <option value="1" @if($payment_mode=='1'){{"selected"}}@endif>Online</option>
                                        <option value="2" @if($payment_mode=='2'){{"selected"}}@endif>COD</option>
                                        
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 5px;">
                                    Name <br/>
                                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{$name}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    Mobile No <br/>
                                    <input type="text" class="form-control" name="mobile" placeholder="Mobile No" value="{{$mobile}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    Start Date <br/>
                                    <input type="date" class="form-control" name="start_date" placeholder="Start Date" value="{{$start_date}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    End Date <br/>
                                    <input type="date" class="form-control" name="end_date" placeholder="End Date" value="{{$end_date}}">
                                </td>
                                
                                <td style="padding: 10px 5px;">
                                    <button class="btn btn-primary" type="submit" id="btnSave" style="margin-top:20px;"><i class="fa fa-fw fa-lg fa-check-circle" ></i>Search Data</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </form>
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Order No</th>
                                <th>Customer Details</th>
                                <th>Restaurant</th>
                                <th>Delivery Agent</th>
                                <th>Items</th>
                                
                                <th>Order Amount </th>
                                <th>Commission</th>
                                <th>Status</th>
                                <th>Order Date</th>
                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $key => $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->unique_id }}</td>
                                    <td>{{ $order->name }}<br>Mobile : <br>{{ $order->mobile }}</td>
                                    <td>{{ $order->restaurant->name }}</td>
                                    <td>@if($order->delivery_boy_id!='0'){{ $order->boy->name }}@else{{"NA"}}@endif</td>
                                    <td>
                                        @php
                                        $items_str = '';
                                            $items = array();
                                            foreach($order->items as $item){
                                                array_push($items,$item->product_name);
                                            }
                                            $items_str = implode(',',$items);
                                        
                                        echo $items_str;
                                        @endphp
                                    </td>
                                    
                                    <td>Rs. {{ $order->total_amount }}</td>
                                    <td>Rs. {{ $order->restaurant_commission }}</td>
                                    <td><b>
                                        @if($order->status==1)
                                        New Order
                                        @elseif($order->status==2)
                                        Order Accepted
                                        @elseif($order->status==3)
                                        Delivery Boy Assigned
                                        @elseif($order->status==4)
                                        Order On Process
                                        @elseif($order->status==5)
                                        Rider Started Towards Restaurant
                                        @elseif($order->status==6)
                                        Rider Reached Restaurant
                                        @elseif($order->status==7)
                                        Order Picked
                                        @elseif($order->status==8)
                                        Order Delivered
                                        @elseif($order->status==9)
                                        Money Collected
                                        @elseif($order->status==10)
                                        Order Cancelled
                                        @endif
                                        </b>
                                    </td>
                                    <td>{{ date("d/m/Y",strtotime($order->created_at))}}<br/>
                                        {{ date("h:i a",strtotime($order->created_at))}}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('admin.order.report_details', $order['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <!-- <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script> -->

   
@endpush