@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@php
$restaurants = App\Models\Restaurant::where('status','1')->get();

$order_id = (isset($_GET['order_id']) && $_GET['order_id']!='')?$_GET['order_id']:'';
$name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
$mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
$start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'';
$end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'';
$restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';
$status = (isset($_GET['status']) && $_GET['status']!='')?$_GET['status']:'';
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
                    <table class="table table-hover custom-data-table-style table-striped" id="">
                        <tbody>
                            <tr>
                                
                                <td style="padding: 10px 5px;">
                                    Order Id <br/>
                                    <input type="text" class="form-control" name="order_id" placeholder="Order Id" value="{{$order_id}}">
                                </td>
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
                                    Restaurant <br/>
                                    <select class="form-control" name="restaurant_id">
                                        <option value="">Select Restaurant</option>
                                        @foreach($restaurants as $restaurant)
                                        <option value="{{$restaurant->id}}" @if($restaurant_id==$restaurant->id){{"selected"}}@endif>{{$restaurant->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 10px 5px;">
                                    <button class="btn btn-primary" type="submit" id="btnSave"><i class="fa fa-fw fa-lg fa-check-circle"></i>Search</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </form>
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Order Date</th>
                                <th>Restaurant</th>
                                <th>Customer Details</th>
                                <th>Order Amount </th>
                                <th>Transaction Id</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $key => $order)
                                <tr>
                                    <td>{{ $order->unique_id }}</td>
                                    <td>{{ date("d-M-Y h:i a",strtotime($order->created_at))}}</td>
                                    <td>{{ $order->restaurant->name }}</td>
                                    <td>{{ $order->name }}<br>Mobile : <br>{{ $order->mobile }}</td>
                                    <td>Rs. {{ $order->total_amount }}</td>
                                    <td>{{ $order->transaction_id }}</td>
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