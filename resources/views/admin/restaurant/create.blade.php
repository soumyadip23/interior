@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    @php
    $cuisines = DB::select("select * from cuisines");
    @endphp
    
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Restaurant</button>
                        <a class="btn btn-secondary" href="{{ route('admin.restaurant.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.restaurant.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}"/>
                            @error('name') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Restaurant Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Restaurant Logo</label>
                            <input class="form-control @error('logo') is-invalid @enderror" type="file" id="logo" name="logo"/>
                            
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
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="email">Email Id <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{ old('email') }}"/>
                            @error('email') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="password">Password <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" value="{{ old('password') }}"/>
                            @error('password') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="mobile">Mobile No <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"/>
                            @error('mobile') {{ $message ?? '' }} @enderror
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
                            <label class="control-label" for="name">Address <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address" value="{{ old('address') }}"/>
                            @error('address') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Location <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('location') is-invalid @enderror" type="text" name="location" id="location" value="{{ old('location') }}"/>
                            @error('location') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="lat">Latitude <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('lat') is-invalid @enderror" type="text" name="lat" id="lat" value="{{ old('lat') }}"/>
                            @error('lat') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="lng">Longitude <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('lng') is-invalid @enderror" type="text" name="lng" id="lng" value="{{ old('lng') }}"/>
                            @error('lng') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="lng">Start Time <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('start_time') is-invalid @enderror" type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"/>
                            @error('start_time') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="lat">Close Time <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('close_time') is-invalid @enderror" type="time" name="close_time" id="close_time" value="{{ old('close_time') }}"/>
                            @error('close_time') {{ $message ?? '' }} @enderror
                        </div>
                        
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="address">Pure Veg? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="is_pure_veg">
                                <option value="">Select Type</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('is_pure_veg') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="commission_rate">Commission Rate <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('commission_rate') is-invalid @enderror" type="text" name="commission_rate" id="commission_rate" value="{{ old('commission_rate') }}"/>
                            @error('commission_rate') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="estimated_delivery_time">Estimated Delivery Time (In Mins) <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('estimated_delivery_time') is-invalid @enderror" type="text" name="estimated_delivery_time" id="estimated_delivery_time" value="{{ old('estimated_delivery_time') }}"/>
                            @error('estimated_delivery_time') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="address">Not Taking Orders? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="is_not_taking_orders">
                                <option value="">Select Type</option>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            @error('is_not_taking_orders') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="address">Tax Included? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="including_tax">
                                <option value="">Select Option</option>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            @error('including_tax') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="tax_rate">Tax Rate <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('tax_rate') is-invalid @enderror" type="text" name="tax_rate" id="tax_rate" value="{{ old('tax_rate') }}"/>
                            @error('tax_rate') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="minimum_order_amount">Minimum Order Amount <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('minimum_order_amount') is-invalid @enderror" type="text" name="minimum_order_amount" id="minimum_order_amount" value="{{ old('minimum_order_amount') }}"/>
                            @error('minimum_order_amount') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="order_preparation_time">Order Preparation Time (In Mins) <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('order_preparation_time') is-invalid @enderror" type="text" name="order_preparation_time" id="order_preparation_time" value="{{ old('order_preparation_time') }}"/>
                            @error('order_preparation_time') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="address">Show Out Of Stock Products In App? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="show_out_of_stock_products_in_app">
                                <option value="">Select Option</option>
                                <option value="0" >No</option>
                                <option value="1">Yes</option>
                            </select>
                            @error('show_out_of_stock_products_in_app') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <label class="control-label">Availibility of Restaurant <span class="m-l-5 text-danger"> *</span></label>
                    <table>
                        <tbody id="time-tbody">
                            <tr>
                                <td style="padding: 10px 5px;">
                                    Day <br/>
                                    <select class="form-control" name="days[]">
                                        <option value="ALL">ALL Days</option>
                                        <option value="MON">Monday</option>
                                        <option value="TUE">Tuesday</option>
                                        <option value="WED">Wednesday</option>
                                        <option value="THU">Thursday</option>
                                        <option value="FRI">Friday</option>
                                        <option value="SAT">Saturday</option>
                                        <option value="SUN">Sunday</option>
                                    </select>
                                </td>
                                <td style="padding: 10px 5px;">
                                    Mobile No <br/>
                                    <input type="time" class="form-control" name="start_times[]" placeholder="Mobile No" value="">
                                </td>
                                <td style="padding: 10px 5px;">
                                    Address <br/>
                                    <input type="time" class="form-control" name="end_times[]" placeholder="Address" value="">
                                    
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="a-add">Add</a>
                                    <a href="javascript:void(0);" class="a-rm">Remove</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Restaurant</button>
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