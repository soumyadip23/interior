@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@php
$restaurants = App\Models\Restaurant::where('status','1')->get();

$start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:date("Y-m-01");
$end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:date("Y-m-31");
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
                                    <button class="btn btn-primary" type="submit" id="btnSave"><i class="fa fa-fw fa-lg fa-check-circle"></i>Search</button>
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
                                <th>Order Date</th>
                                <th>Restaurant</th>
                                <th>Order Amount </th>
                                <th>Restaurant Commission </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_order_amount = 0;
                            $total_commission = 0;
                            @endphp
                            @foreach($orders as $key => $order)
                            @php
                            $total_order_amount += $order->total_amount;
                            $total_commission += $order->restaurant_commission;
                            @endphp
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->unique_id }}</td>
                                    <td>{{ date("d-M-Y h:i a",strtotime($order->created_at))}}</td>
                                    <td>{{ $order->restaurant->name }}</td>
                                    <td>Rs. {{ $order->total_amount }}</td>
                                    <td>Rs. {{ $order->restaurant_commission }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4"><b>Total</b></td>
                                <td><b>Rs. {{$total_order_amount}}</b></td>
                                <td><b>Rs. {{$total_commission}}</b></td>
                            </tr>
                        </tbody>
                    </table>
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