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
                <form action="{{ route('admin.users.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $targetUser->id }}">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $targetUser->name) }}"/>
                           
                            @error('name') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="email">Email Id <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{ old('email', $targetUser->email) }}"/>
                           
                            @error('email') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="country">Country</label>
                            <input class="form-control" type="text" name="country" id="country" value="{{ old('country', $targetUser->country) }}"/>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="city">City</label>
                            <input class="form-control" type="text" name="city" id="city" value="{{ old('city', $targetUser->city) }}"/>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="address">Address</label>
                            <input class="form-control" type="text" name="address" id="address" value="{{ old('address', $targetUser->address) }}"/>
                        </div>
                    </div>

                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="contact_person">Contact Person </label>
                            <input class="form-control" type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $targetUser->contact_person) }}"/>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="contact_no">Contact NO</label>
                            <input class="form-control" type="text" name="contact_no" id="contact_no" value="{{ old('contact_no', $targetUser->contact_no) }}"/>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label class="control-label" for="name">Select categories <span class="m-l-5 text-danger"> *</span></label>
                        <select class="form-control categorySelect" name="cat_id[]" multiple="multiple">
                            {{-- <option value="">Select Category</option> --}}
                            @foreach($categories as $cat)
                            <option value="{{$cat->id}}" <?= in_array($cat->id,$cat_array) ? 'selected':''?>>{{$cat->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Vendor</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.users.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection