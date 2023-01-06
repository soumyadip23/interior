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
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Commission</button>
                        <a class="btn btn-secondary" href="{{ route('admin.commission.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.commission.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="min_order">No Of Min Orders <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('min_order') is-invalid @enderror" type="text" name="min_order" id="min_order" value="{{ old('min_order') }}"/>
                            @error('min_order') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="max_order">No Of Max Orders <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('max_order') is-invalid @enderror" type="text" name="max_order" id="max_order" value="{{ old('max_order') }}"/>
                            @error('max_order') {{ $message ?? '' }} @enderror
                        </div>
                         <div class="form-group">
                            <label class="control-label" for="value">Commission Value <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('value') is-invalid @enderror" type="text" name="value" id="value" value="{{ old('value') }}"/>
                            @error('max_order') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Commission</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.commission.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection