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
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="details_badge_list d-flex flex-wrap mb-3 mb-lg-3">
        <a href="{{ route('admin.restaurant.details', $targetItem->restaurant_id) }}" class="details_badge_item btn btn-primary">Basic Details</a>
        <a href="{{ route('admin.restaurant.items', $targetItem->restaurant_id) }}" class="details_badge_item btn btn-primary">Item List</a>
        <a href="{{ route('admin.restaurant.itemcreate', $targetItem->restaurant_id) }}" class="details_badge_item btn btn-primary">Add Item</a>
        <a href="{{ route('admin.restaurant.transactions', $targetItem->restaurant_id) }}" class="details_badge_item btn btn-primary">Transaction Log</a>
        <a href="{{ route('admin.restaurant.orders', $targetItem->restaurant_id) }}" class="details_badge_item btn btn-primary">Order List</a>
    </div>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.restaurant.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.restaurant.itemupdate') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$targetItem->id}}">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="category">Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($targetItem->category_id==$category->id){{"selected"}}@endif>{{$category->title}}</option>
                                @endforeach
                            </select>
                            @error('category_id') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name',$targetItem->name) }}"/>
                            @error('name') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description',$targetItem->description) }}</textarea>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="price">Price</label>
                            <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" id="price" value="{{ old('price',$targetItem->price) }}"/>
                            @error('price') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="offer_price">Offer Price</label>
                            <input class="form-control @error('offer_price') is-invalid @enderror" type="text" name="offer_price" id="offer_price" value="{{ old('offer_price',$targetItem->offer_price) }}"/>
                            @error('offer_price') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="is_veg">Veg? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="is_veg">
                                <option value="">Select Type</option>
                                <option value="1" @if($targetItem->is_veg==1){{"selected"}}@endif>Yes</option>
                                <option value="0" @if($targetItem->is_veg==0){{"selected"}}@endif>No</option>
                            </select>
                            @error('is_veg') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="is_cutlery_required">Cutlery Required? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="is_cutlery_required">
                                <option value="">Select Type</option>
                                <option value="1" @if($targetItem->is_cutlery_required==1){{"selected"}}@endif>Yes</option>
                                <option value="0" @if($targetItem->is_cutlery_required==0){{"selected"}}@endif>No</option>
                            </select>
                            @error('is_cutlery_required') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="min_item_for_cutlery">Min Items For Cutlery</label>
                            <input class="form-control" type="text" name="min_item_for_cutlery" id="min_item_for_cutlery" value="{{ old('min_item_for_cutlery',$targetItem->min_item_for_cutlery) }}"/>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="in_stock">In Stock? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="in_stock">
                                <option value="">Select Type</option>
                                <option value="1" @if($targetItem->in_stock==1){{"selected"}}@endif>Yes</option>
                                <option value="0" @if($targetItem->in_stock==0){{"selected"}}@endif>No</option>
                            </select>
                            @error('in_stock') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Item</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.restaurant.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection