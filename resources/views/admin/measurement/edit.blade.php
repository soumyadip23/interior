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
                <form action="{{ route('admin.item.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $targetitem->id }}">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="category">Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{ $category->id== $targetitem->category_id ? 'selected' : '' }}>{{$category->title}}</option>
                                @endforeach
                            </select>
                            @error('category_id') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $targetitem->name) }}"/>
                            @error('name') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="col-md-2">
                            @if ($targetitem->image != null)
                                <figure class="mt-2" style="width: 80px; height: auto;">
                                    <img src="{{ asset('items/'.$targetitem->image) }}" id="blogImage" class="img-fluid" alt="img">
                                </figure>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description', $targetitem->description) }}</textarea>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="unit">Unit <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('unit') is-invalid @enderror" type="text" name="unit" id="unit" value="{{ old('unit', $targetitem->unit) }}"/>
                            @error('unit') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="price">Price <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('price') is-invalid @enderror" type="number" name="price" id="price" value="{{ old('price', $targetitem->price) }}"/>
                            @error('price') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="in_stock">In Stock? <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="in_stock">
                                <option value="">Select Type</option>
                                <option value="1" {{ $targetitem->in_stock  == 1 ? 'selected' : '' }} >Yes</option>
                                <option value="0" {{ $targetitem->in_stock  == 0 ? 'selected' : '' }}>No</option>
                            </select>
                            @error('in_stock') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
      



                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Item</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.item.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection