@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@php
$delivery_boy_id = $id;
$earnings = DB::select("select * from delivery_boy_earnings where delivery_boy_id='$delivery_boy_id'");
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
                                <th> Sr No</th>
                                <th> Date </th>
                                <th> Type </th>
                                <th> Order Count </th>
                                <th> Amount </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $srNo=1; 
                            @endphp
                            @foreach($earnings as $key => $item)
                                <tr>
                                    <td>{{ $item->id }} </td>
                                    <td>{{ date("d-M-Y",strtotime($item->created_at)) }}</td>
                                    <td>
                                        @if($item->type==2)
                                        Incentive
                                        @else
                                        Payment for order delivery
                                        @endif
                                    </td>
                                    <td>{{ $item->no_of_orders }}</td>
                                    <td>Rs. {{ $item->amount }}</td>
                                </tr>
                            @php $srNo++; @endphp
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection