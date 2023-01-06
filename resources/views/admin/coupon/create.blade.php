@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@php
$restaurants = DB::select("select * from restaurants where status=1");
$cuisines = DB::select("select * from cuisines");
@endphp
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Coupon</button>
                        <a class="btn btn-secondary" href="{{ route('admin.coupon.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.coupon.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="lat">Description <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="description" id="description" value="{{ old('description') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="code">Code <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="code" id="code" value="{{ old('code') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="type">Type <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="type">
                                <option value="">Select Type</option>
                                <option value="1">Percentage</option>
                                <option value="2">Flat Offer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="rate">Rate</label>
                            <input class="form-control" type="text" name="rate" id="rate" value="{{ old('rate') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="maximum_offer_rate">Maximum Offer Rate</label>
                            <input class="form-control" type="text" name="maximum_offer_rate" id="maximum_offer_rate" value="{{ old('maximum_offer_rate') }}"/>
                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="email">Select Restaurant <span class="m-l-5 text-danger"> *</span></label><br>
                                @foreach($restaurants as $restaurant)
                                <input type="checkbox" name="restaurants[]" value="{{$restaurant->id}}"> {{$restaurant->name}}
                                @endforeach
                            </div>
                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="email">Select Cuisine <span class="m-l-5 text-danger"> *</span></label><br>
                                @foreach($cuisines as $cuisine)
                                <input type="checkbox" name="cuisines[]" value="{{$cuisine->id}}"> {{$cuisine->title}}
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="start_date">Start Date</label>
                            <input class="form-control" type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="end_date">End Date</label>
                            <input class="form-control" type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="maximum_time_of_use">Maximum Time Of Use</label>
                            <input class="form-control" type="text" name="maximum_time_of_use" id="maximum_time_of_use" value="{{ old('maximum_time_of_use') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="maximum_time_user_can_use">Maximum Time User Can Use</label>
                            <input class="form-control" type="text" name="maximum_time_user_can_use" id="maximum_time_user_can_use" value="{{ old('maximum_time_user_can_use') }}"/>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save coupon</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.coupon.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection