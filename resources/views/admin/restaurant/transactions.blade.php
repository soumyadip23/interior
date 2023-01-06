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
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Sr No</th>
                                <th> Date </th>
                                <th> Type </th>
                                <th> Note </th>
                                <th> Amount </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $srNo=1; 
                            $totalDeduction = 0;
                            $totalCredit = 0;
                            @endphp
                            @foreach($transactions as $key => $item)
                            @php
                            if($item->type==2){
                                $totalDeduction+=$item->amount;
                            }else{
                                $totalCredit+=$item->amount;
                            }
                            @endphp
                                <tr>
                                    <td>{{ $item->id }} </td>
                                    <td>{{ date("d-M-Y h:i a",strtotime($item->created_at)) }}</td>
                                    <td>
                                        @if($item->type==2)
                                        Deduction
                                        @else
                                        Credit
                                        @endif
                                    </td>
                                    <td>{{ $item->note }}</td>
                                    <td>
                                        @if($item->type==2)
                                        <span style="color:#FF0000">(-) {{$item->amount}}</span>
                                        @else
                                        <span style="color:#179C6A">(+) {{$item->amount}}</span>
                                        @endif
                                    </td>
                                </tr>
                            @php $srNo++; @endphp
                            @endforeach
                            <tr>
                                <td colspan="4">Total Balance</td>
                                <td>
                                    @if($totalDeduction>$totalCredit)
                                    <span style="color:#FF0000">(-) {{$totalDeduction}}</span>
                                    @else
                                    <span style="color:#179C6A">(+) {{$totalCredit}}</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection