@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
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
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <thead>
                            <tr>
                                <th> Name</th>
                                <th> Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach($carts as $cart)
                        <tr>
                            <td>{{$cart->product_name}}</td>
                            <td>{{$cart->price}}</td>
                            <td><form action="{{ route('admin.users.updateUserCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$cart->id}}">
                                <input type="hidden" name="product_id" value="{{$cart->product_id}}">
                                <input type="hidden" name="product_name" value="{{$cart->product_name}}">
                                <input type="hidden" name="product_image" value="test">
                                <input type="hidden" name="price" value="{{$cart->price}}">
                                <input type="number" name="quantity" value="{{$cart->quantity}}">
                                <input type="hidden" name="is_cutlery_required" value="0">
                                <input type="hidden" name="cutlery_quantity" value="0">
                                <input type="hidden" name="cutlery_price" value="0">
                                <button type="submit">Update</button>
                            </form></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tile">
                <form action="{{ route('admin.users.createUserOrder') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user['id']}}">
                    <input type="hidden" name="restaurant_id" value="{{$restaurantId}}">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Choose Address <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="address_id">
                                <option value="">Select Address</option>
                                @foreach($addresses as $address)
                                <option value="{{$address->id}}">{{$address->address}} , {{$address->location}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Create Order</button>
                        &nbsp;&nbsp;&nbsp;
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection