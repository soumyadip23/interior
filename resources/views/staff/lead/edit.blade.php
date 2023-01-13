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
                   
                </h3>
                <hr>
                <form action="{{ route('admin.lead.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $targetlead->id }}">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Customer Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $targetlead->customer_name) }}"/>
                            @error('name') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="email">Email Id <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('customer_email') is-invalid @enderror" type="text" name="customer_email" id="customer_email" value="{{ old('customer_email', $targetlead->customer_email) }}"/>
                            @error('customer_email') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="customer_mobile">Mobile No <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('customer_mobile') is-invalid @enderror" type="text" name="customer_mobile" id="customer_mobile" value="{{ old('customer_mobile', $targetlead->customer_mobile) }}"/>
                            @error('customer_mobile') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="address">Customer Address</label>
                            <input class="form-control" type="text" name="customer_address" id="searchTextField" value="{{ old('customer_address', $targetlead->customer_address) }}"/>
                                <input type="hidden" id="lat" name="lat" />
                                 <input type="hidden" id="long" name="long" />
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="source">Source <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="source">
                                <option value="phone" {{ $targetlead->source  == 'phone' ? 'selected' : '' }} >Phone</option>
                                <option value="email" {{ $targetlead->source  == 'email' ? 'selected' : '' }}  >email</option>
                                <option value="campaign" {{ $targetlead->source  == 'campaign' ? 'selected' : '' }}>Campaign</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="requirement">Requirement</label>
                            <textarea class="form-control" rows="4" name="requirement" id="requirement">{{ old('requirement', $targetlead->requirement) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="budget">Budget <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('budget') is-invalid @enderror" type="number" name="budget" id="budget" value="{{ old('budget', $targetlead->budget) }}"/>
                            @error('budget') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="remarks">Remarks</label>
                            <textarea class="form-control" rows="1" name="remarks" id="remarks">{{ old('remarks', $targetlead->remarks) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Assigned To<span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="assigned_to">
                                <option value="">Select Staff</option> 
                                @foreach($boys as $boy)
                                <option value="{{$boy->id}}" {{ $boy->id== $targetlead->assigned_to ? 'selected' : '' }}>{{$boy->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="status">Status <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="status">
                                <option value="0" {{ $targetlead->status  == 0 ? 'selected' : '' }} >new</option>
                                <option value="1" {{ $targetlead->status  == 1 ? 'selected' : '' }} >open</option>
                                <option value="2" {{ $targetlead->status  == 2 ? 'selected' : '' }} >working</option>
                                <option value="3" {{ $targetlead->status  == 3 ? 'selected' : '' }} >Disqualified</option>
                                <option value="4" {{ $targetlead->status  == 4 ? 'selected' : '' }} >Not a Target</option>
                                <option value="5" {{ $targetlead->status  == 5 ? 'selected' : '' }} >Nurture</option>
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