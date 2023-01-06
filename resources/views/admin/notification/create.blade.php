@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
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
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Notification</button>
                        <a class="btn btn-secondary" href="{{ route('admin.notification.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.notification.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="type">Type</label>
                            <select name="type" id="type" id="type" class="form-control @error('type') is-invalid @enderror">
                                <option value="">Select Type</option>
                                <option value="1">Customer</option>
                                <option value="2">Restaurant</option>
                                <option value="3">Agent</option>
                            </select>
                        </div>
                        <div class="form-group" id="customer_type_div" style="display:none;">
                            <label class="control-label" for="customer_type">Customer Type</label>
                            <select name="customer_type" id="customer_type" id="customer_type" class="form-control @error('type') is-invalid @enderror">
                                <option value="">Select Type</option>
                                <option value="1">All Customers</option>
                                <option value="2">Joined Today</option>
                                <option value="3">Haven't Place Order For 1 Month</option>
                                <option value="4">Haven't Place Order For 3 Months</option>
                                <option value="5">Haven't Place Order For 6 Months</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Choose Restaurant <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="restaurant_id">
                                <option value="">Select Restaurant</option>
                                @foreach($restaurants as $restaurant)
                                <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Notification Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Notification</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.notification.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $('#type').change(function() {
        //alert($(this).val());
        if($(this).val()=='1'){
            $('#customer_type_div').css({"display":"block"});
        }else{
            $('#customer_type_div').css({"display":"none"});
        }
    });
</script>
@endpush