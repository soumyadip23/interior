@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@php
$restaurant_id = $order->restaurant_id;
$items = App\Models\Item::where('status','1')->where('restaurant_id',$restaurant_id)->get();
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
                @if($order->delivery_boy_id==0)
                <form action="{{ route('admin.order.assignboy') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Assign Delivery Boy <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="delivery_boy_id">
                                <option value="">Select Delievry Boy</option>
                                @foreach($boys as $boy)
                                <option value="{{$boy->id}}" @if($order->delivery_boy_id==$boy->id){{"selected"}}@endif>{{$boy->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                        &nbsp;&nbsp;&nbsp;
                        
                    </div>
                </form>
                @else
                Delivery Agent : {{$order->boy->name}}
                @endif
            </div>
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Order No</td>
                            <td>{{ $order->unique_id }}</td>
                        </tr>
                        <tr>
                            <td>Restaurant</td>
                            <td>{{ $order->restaurant->name }}</td>
                        </tr>
                        <tr>
                            <td>Customer Details</td>
                            <td>{{$order->name}}<br>Email : {{$order->email}} <br> Mobile No : {{$order->mobile}}</td>
                        </tr>
                        <tr>
                            <td>Delivery Address</td>
                            <td>{{$order->delivery_address}}<br>Landmark : {{$order->delivery_landmark}}<br>{{$order->delivery_city}} - {{$order->delivery_pin}}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>@if($order->status==1)
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
                        <tr>
                            <td>Total Amount</td>
                            <td>{{ $order->total_amount }}</td>
                        </tr>
                        <tr>
                            <td>Transactio Id</td>
                            <td>{{ $order->transaction_id }}</td>
                        </tr>
                        <tr>
                            <td>Order Creation Date</td>
                            <td>{{ date("d-M-Y h:i a",strtotime($order->created_at))}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h4>Add Item</h4>
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width">
                    <tbody>
                        <tr>
                            <td>Item <br/>
                                    <select class="form-control" name="restaurant_id">
                                        <option value="">Select Item</option>
                                        @foreach($items as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            <td>Quantity<br>
                                <input type="text" class="form-control" name="quantity" value=""/></td>
                            <td><input type="submit" name="btnUpdateQuantity" value="Add"/></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $srNo=1; @endphp
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{$srNo}}</td>
                            <td>{{$item->product_name}}</td>
                            <td><input type="text" name="quantity" value="{{$item->quantity}}"><input type="submit" name="btnUpdateQuantity" value="Update"/></td>
                            <td>{{$item->price}}</td>
                            <td>{{$item->price*$item->quantity}} <a href="">Delete</a></td>
                        </tr>
                        @php $srNo++; @endphp
                        @endforeach
                        <tr>
                            <td colspan="4">Item Total</td>
                            <td><b>{{$order->amount}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4">Discount</td>
                            <td><b>{{$order->discounted_amount}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4">Delivery Charge</td>
                            <td><b>{{$order->delivery_charge}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4">Packing Charge</td>
                            <td><b>{{$order->packing_price}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4">Tax Amount</td>
                            <td><b>{{$order->tax_amount}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4">Total Amount</td>
                            <td><b>{{$order->total_amount}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection