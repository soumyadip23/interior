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
        <a href="{{ route('admin.restaurant.details', $id) }}" class="details_badge_item btn btn-primary">Basic Details</a>
        <a href="{{ route('admin.restaurant.items', $id) }}" class="details_badge_item btn btn-primary">Item List</a>
        <a href="{{ route('admin.restaurant.itemcreate', $id) }}" class="details_badge_item btn btn-primary">Add Item</a>
        <a href="{{ route('admin.restaurant.transactions', $id) }}" class="details_badge_item btn btn-primary">Transaction Log</a>
        <a href="{{ route('admin.restaurant.orders', $id) }}" class="details_badge_item btn btn-primary">Order List</a>
        <a href="{{ route('admin.restaurant.reviews', $id) }}" class="details_badge_item btn btn-primary">Review List</a>
    </div>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Item</button>
                        <a class="btn btn-secondary" href="{{ route('admin.restaurant.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.restaurant.itemstore') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="restaurant_id" value="{{$id}}">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="category">Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                            @error('category_id') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}"/>
                            @error('name') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label">Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="price">Price</label>
                            <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" id="price" value="{{ old('price') }}"/>
                            @error('price') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="offer_price">Offer Price</label>
                            <input class="form-control @error('offer_price') is-invalid @enderror" type="text" name="offer_price" id="offer_price" value="{{ old('offer_price') }}"/>
                            @error('offer_price') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="is_veg">Veg? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="is_veg">
                                <option value="">Select Type</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('is_veg') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="is_cutlery_required">Cutlery Required? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="is_cutlery_required">
                                <option value="">Select Type</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('is_cutlery_required') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="min_item_for_cutlery">Min Items For Cutlery</label>
                            <input class="form-control" type="text" name="min_item_for_cutlery" id="min_item_for_cutlery" value="{{ old('min_item_for_cutlery') }}"/>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="is_add_on">Is Add On? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="is_add_on">
                                <option value="">Select Type</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('is_add_on') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="add_on_item_id">Add On Related To <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="add_on_item_id">
                                <option value="">Select Type</option>
                                @foreach($items as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('add_on_item_id') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="in_stock">In Stock? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="in_stock">
                                <option value="">Select Type</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('in_stock') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="is_special">Is Special? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="is_special">
                                <option value="">Select Type</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('is_special') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <label class="control-label">Upsell Items <span class="m-l-5 text-danger"> *</span></label>
                    <table>
                        <tbody id="time-tbody">
                            <tr>
                                <td style="padding: 10px 5px;">
                                    Select Item <br/>
                                    <select class="form-control" name="upsell_ids[]">
                                        <option value="">Select Option</option>
                                        @foreach($items as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 10px 5px;">
                                    Select Item <br/>
                                    <select class="form-control" name="upsell_ids[]">
                                        <option value="">Select Option</option>
                                        @foreach($items as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 10px 5px;">
                                    Select Item <br/>
                                    <select class="form-control" name="upsell_ids[]">
                                        <option value="">Select Option</option>
                                        @foreach($items as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 10px 5px;">
                                    Select Item <br/>
                                    <select class="form-control" name="upsell_ids[]">
                                        <option value="">Select Option</option>
                                        @foreach($items as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 10px 5px;">
                                    Select Item <br/>
                                    <select class="form-control" name="upsell_ids[]">
                                        <option value="">Select Option</option>
                                        @foreach($items as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Item</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.restaurant.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $('body').on('click','a.a-add',function(e){
        //alert("hello");
        var html = '<tr>\
                        <td style="padding: 10px 5px;">\
                            Day <br/>\
                            <select class="form-control" name="days[]">\
                                <option value="ALL">ALL Days</option>\
                                <option value="MON">Monday</option>\
                                <option value="TUE">Tuesday</option>\
                                <option value="WED">Wednesday</option>\
                                <option value="THU">Thursday</option>\
                                <option value="FRI">Friday</option>\
                                <option value="SAT">Saturday</option>\
                                <option value="SUN">Sunday</option>\
                            </select>\
                        </td>\
                        <td style="padding: 10px 5px;">\
                            Mobile No <br/>\
                            <input type="time" class="form-control" name="start_times[]" placeholder="Mobile No" value="">\
                        </td>\
                        <td style="padding: 10px 5px;">\
                            Address <br/>\
                            <input type="time" class="form-control" name="end_times[]" placeholder="Address" value="">\
                        </td>\
                        <td>\
                            <a href="javascript:void(0);" class="a-add">Add</a>\
                            <a href="javascript:void(0);" class="a-rm">Remove</a>\
                        </td>\
                    </tr>';  

        $('#time-tbody').append(html);
    })

    $('body').on('click','a.a-rm',function(e){
        $(this).parent().parent().remove();
    });
</script>
@endpush