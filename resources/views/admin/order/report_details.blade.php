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
                            <td>Delivery Agent</td>
                            <td>@if($order->delivery_boy_id!='0'){{ $order->boy->name }}@else{{"NA"}}@endif</td>
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
                            <td>Transaction Id</td>
                            <td>{{ $order->transaction_id }}</td>
                        </tr>
                        <tr>
                            <td>Order Creation Date</td>
                            <td>{{ date("d-M-Y h:i a",strtotime($order->created_at))}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3>Status Log</h3>
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Order Placed</td>
                            <td>0000-00-00 00:00:00</td>
                        </tr>
                        <tr>
                            <td>Order Accepted</td>
                            <td>0000-00-00 00:00:00</td>
                        </tr>
                        <tr>
                            <td>Delivery Agent Assigned</td>
                            <td>0000-00-00 00:00:00</td>
                        </tr>
                        <tr>
                            <td>Order On Process</td>
                            <td>0000-00-00 00:00:00</td>
                        </tr>
                        <tr>
                            <td>Rider Started Towards Restaurant</td>
                            <td>0000-00-00 00:00:00</td>
                        </tr>
                        <tr>
                            <td>Rider Reached Restaurant</td>
                            <td>0000-00-00 00:00:00</td>
                        </tr>
                        <tr>
                            <td>Order Picked</td>
                            <td>0000-00-00 00:00:00</td>
                        </tr>
                        <tr>
                            <td>Order Delivered</td>
                            <td>0000-00-00 00:00:00</td>
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
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->price}}</td>
                            <td>{{$item->price*$item->quantity}}</td>
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