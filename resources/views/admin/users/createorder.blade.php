@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@php
$restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';
@endphp
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
                <form action="" role="form" enctype="multipart/form-data">
                    
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Choose Restaurant <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="restaurant_id">
                                <option value="">Select Restaurant</option>
                                @foreach($restaurants as $restaurant)
                                <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                        &nbsp;&nbsp;&nbsp;
                        
                    </div>
                </form>
            </div>
            <div class="details_badge_list d-flex flex-wrap mb-3 mb-lg-3">
                @if(count($restaurantData)>0)
                @php
                /*echo "<pre>";
                    print_r($restaurantData);
                    die();*/
                
                @endphp
                @foreach($restaurantData['categories'] as $category)
                 <a href="{{url('admin/users/'.$user['id'].'/createorder?restaurant_id='.$restaurant_id.'&category='.$category->id)}}" class="details_badge_item btn btn-primary">{{$category->title}}</a>
                @endforeach
                @endif
               
            </div>
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <thead>
                            <tr>
                                <th> Name</th>
                                <th> Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->offer_price}}</td>
                            <td><form action="{{ route('admin.users.addUserCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{$user['id']}}">
                                <input type="hidden" name="device_id" value="{{$user['id']}}">
                                <input type="hidden" name="restaurant_id" value="{{$restaurant_id}}">
                                <input type="hidden" name="product_id" value="{{$item->id}}">
                                <input type="hidden" name="product_name" value="{{$item->name}}">
                                <input type="hidden" name="product_image" value="test">
                                <input type="hidden" name="price" value="{{$item->offer_price}}">
                                <input type="number" name="quantity" value="{{$item->quantity}}">
                                <input type="hidden" name="is_cutlery_required" value="0">
                                <input type="hidden" name="cutlery_quantity" value="0">
                                <input type="hidden" name="cutlery_price" value="0">
                                <button type="submit">Add</button>
                            </form></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{url('admin/users/'.$user['id'].'/usercart/'.$restaurant_id)}}" class="details_badge_item btn btn-primary">Continue To Cart</a>
        </div>
    </div>
@endsection