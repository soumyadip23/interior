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
                <form action="{{ route('admin.commission.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $targetCommission->id }}">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title', $targetCommission->title) }}"/>
                            
                            @error('title') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="lat">No Of Min Orders <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('min_order') is-invalid @enderror" type="text" name="min_order" id="min_order" value="{{ old('min_order', $targetCommission->min_order) }}"/>
                            @error('min_order') {{ $message }} @enderror
                        </div>
                         <div class="form-group">
                            <label class="control-label" for="max_order">No Of Max Orders <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('max_order') is-invalid @enderror" type="text" name="max_order" id="max_order" value="{{ old('max_order', $targetCommission->max_order) }}"/>
                            @error('max_order') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="value">Commission Value <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('value') is-invalid @enderror" type="text" name="value" id="value" value="{{ old('value', $targetCommission->value) }}"/>
                            @error('value') {{ $message }} @enderror
                        </div>
                    </div>
                    
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Commission</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.commission.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection