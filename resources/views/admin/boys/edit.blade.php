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
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.boys.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $targetBoy->id }}">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $targetBoy->name) }}"/>
                           
                            @error('name') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="email">Email Id <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{ old('email', $targetBoy->email) }}"/>
                           
                            @error('email') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="country">Country</label>
                            <input class="form-control" type="text" name="country" id="country" value="{{ old('country', $targetBoy->country) }}"/>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="city">City</label>
                            <input class="form-control" type="text" name="city" id="city" value="{{ old('city', $targetBoy->city) }}"/>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="address">Address</label>
                            <input class="form-control" type="text" name="address" id="address" value="{{ old('address', $targetBoy->address) }}"/>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="pin">Pin Code</label>
                            <input class="form-control" type="text" name="pin" id="pin" value="{{ old('pin', $targetBoy->pin) }}"/>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="address">Vehicle <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="vehicle_type">
                                <option value="">Select Vehicle</option>
                                @foreach($vehicles as $vehicle)
                                <option value="{{$vehicle->id}}" @if($vehicle->id==$targetBoy->vehicle_type){{"selected"}}@endif>{{$vehicle->name}}</option>
                                @endforeach
                            </select>
                            @error('gender') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="address">Gender <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" @if($targetBoy->gender=='Male'){{"selected"}}@endif>Male</option>
                                <option value="Female" @if($targetBoy->gender=='Female'){{"selected"}}@endif>Female</option>
                                <option value="Other" @if($targetBoy->gender=='Other'){{"selected"}}@endif>Other</option>
                            </select>
                            @error('gender') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="date_of_birth">Date Of Birth</label>
                            <input class="form-control" type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth',$targetBoy->date_of_birth) }}"/>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Delivery Boy</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.boys.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection