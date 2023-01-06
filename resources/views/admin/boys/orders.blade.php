@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@php
$delivery_boy_id = $id;
$orders = DB::select("select * from orders where delivery_boy_id='$delivery_boy_id' order by id desc");
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
    <div class="details_badge_list d-flex flex-wrap mb-3 mb-lg-3">
        <a href="{{ route('admin.boys.details', $boy['id']) }}" class="details_badge_item btn btn-primary">Basic Details</a>
        <a href="{{ route('admin.boys.orders', $boy['id']) }}" class="details_badge_item btn btn-primary">Assigned Tasks</a>
        <a href="{{ route('admin.boys.earnings', $boy['id']) }}" class="details_badge_item btn btn-primary">Earning List</a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Order No</th>
                                <th>Customer Details</th>
                                <th>Order Amount </th>
                                <th>Status</th>
                                <!-- <th style="width:100px; min-width:100px;" class="text-center">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $key => $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->unique_id }}</td>
                                    <td>{{ $order->name }}<br>Mobile : <br>{{ $order->mobile }}</td>
                                    <td>Rs. {{ $order->total_amount }}</td>
                                    <td>
                                        @if($order->status==1)
                                        New Order
                                        @elseif($order->status==2)
                                        Accepted Order
                                        @elseif($order->status==3)
                                        Delivery Boy Assigned
                                        @elseif($order->status==4)
                                        Order On Process
                                        @elseif($order->status==5)
                                        Order Delivered
                                        @elseif($order->status==6)
                                        Order Cancelled
                                        @endif
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection