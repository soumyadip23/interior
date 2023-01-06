@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
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
        <a href="{{ route('admin.restaurant.details', $restaurant['id']) }}" class="details_badge_item btn btn-primary">Basic Details</a>
        <a href="{{ route('admin.restaurant.items', $restaurant['id']) }}" class="details_badge_item btn btn-primary">Item List</a>
        <a href="{{ route('admin.restaurant.itemcreate', $restaurant['id']) }}" class="details_badge_item btn btn-primary">Add Item</a>
        <a href="{{ route('admin.restaurant.transactions', $restaurant['id']) }}" class="details_badge_item btn btn-primary">Transaction Log</a>
        <a href="{{ route('admin.restaurant.orders', $restaurant['id']) }}" class="details_badge_item btn btn-primary">Order List</a>
        <a href="{{ route('admin.restaurant.reviews', $restaurant['id']) }}" class="details_badge_item btn btn-primary">Review List</a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ empty($restaurant['name'])? null:$restaurant['name'] }}</td>
                        </tr>
                        <tr>
                            <td>Email Id</td>
                            <td>{{ empty($restaurant['email'])? null:$restaurant['email'] }}</td>
                        </tr>
                        <tr>
                            <td>Mobile No</td>
                            <td>{{ empty($restaurant['mobile'])? null:$restaurant['mobile'] }}</td>
                        </tr>
                        <tr>
                            <td>Image</td>
                            <td>@if($restaurant->image!='')
                                <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/restaurants/'}}{{$restaurant->image}}">
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{!! empty($restaurant['description'])? null:$restaurant['description'] !!}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ empty($restaurant['address'])? null:$restaurant['address'] }}</td>
                        </tr>
                        <tr>
                            <td>Location</td>
                            <td>{{ empty($restaurant['location'])? null:$restaurant['location'] }}</td>
                        </tr>
                        <tr>
                            <td>Start Time</td>
                            <td>{{ empty($restaurant['start_time'])? null:$restaurant['start_time'] }}</td>
                        </tr>
                        <tr>
                            <td>Close Time</td>
                            <td>{{ empty($restaurant['close_time'])? null:$restaurant['close_time'] }}</td>
                        </tr>
                        <tr>
                            <td>Commission Rate</td>
                            <td>{{ empty($restaurant['commission_rate'])? null:$restaurant['commission_rate'] }}%</td>
                        </tr>
                        <tr>
                            <td>Estimated Delivery Time</td>
                            <td>{{ empty($restaurant['estimated_delivery_time'])? null:$restaurant['estimated_delivery_time'] }} Mins</td>
                        </tr>
                        <tr>
                            <td>Pure Veg?</td>
                            <td>@if($restaurant['pure_veg']==1){{"Yes"}}@else{{"No"}}@endif</td>
                        </tr>
                        <tr>
                            <td>Not Taking Orders?</td>
                            <td>@if($restaurant['is_not_taking_orders']==1){{"Yes"}}@else{{"No"}}@endif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection