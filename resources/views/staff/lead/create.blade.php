@extends('staff.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('staff.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}
                   
                </h3>
                <hr>
                <form action="{{ route('staff.lead.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Customer Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}"/>
                            @error('name') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="email">Email Id <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('customer_email') is-invalid @enderror" type="text" name="customer_email" id="customer_email" value="{{ old('customer_email') }}"/>
                            @error('customer_email') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="customer_mobile">Mobile No <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('customer_mobile') is-invalid @enderror" type="text" name="customer_mobile" id="customer_mobile" value="{{ old('customer_mobile') }}"/>
                            @error('customer_mobile') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="address">Customer Address</label>
                            <input class="form-control" type="text" name="customer_address" id="searchTextField" value="{{ old('customer_address') }}"/>
                                <input type="hidden" id="lat" name="lat" />
                                 <input type="hidden" id="long" name="long" />
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="source">Source <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="source">
                                <option value="phone">Phone</option>
                                <option value="email">email</option>
                                <option value="campaign">Campaign</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="requirement">Requirement <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control" rows="4" name="requirement" id="requirement">{{ old('requirement') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="budget">Budget <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('budget') is-invalid @enderror" type="number" name="budget" id="budget" value="{{ old('budget') }}"/>
                            @error('budget') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="remarks">Remarks</label>
                            <textarea class="form-control" rows="1" name="remarks" id="remarks">{{ old('remarks') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="status">Status <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="status">
                                <option value="0">new</option>
                                <option value="1">open</option>
                                <option value="2">working</option>
                                <option value="3">Disqualified</option>
                                <option value="4">Not a Target</option>
                                <option value="5">Nurture</option>
                            </select>
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Lead</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.lead.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection