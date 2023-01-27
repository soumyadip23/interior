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
                <form action="{{ route('admin.item.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="category">Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                        @if(count($category->childs))
                                            @include('manageChild',['childs' => $category->childs])
                                        @endif
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
                            <input class="form-control" type="file" id="image" name="image"/>
                
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div> <p> Product Varient(s) </p></div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="unit">Varient Name <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control" type="text" name="vname[]" id="name1" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="unit">Unit <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control" type="text" name="unit[]" id="unit1" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="price">Price <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control"  name="price[]" id="price1" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="in_stock">In Stock? <span class="m-l-5 text-danger"> *</span></label>
                                <select class="form-control" name="in_stock[]" id="in_stock1">
                                    <option value="">Select Type</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="newinput"></div>
                    <button id="rowAdder" type="button" class="btn btn-dark"> <span class="bi bi-plus-square-dotted"></span> ADD More Varient</button>


                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Item</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.item.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script type="text/javascript">
 var i = 2; 
    $("#rowAdder").click(function () {
        newRowAdd =
         '<div class="row concat"><div class="col-sm-3"><div class="form-group"><label class="control-label" for="unit">Name <span class="m-l-5 text-danger"> *</span></label><input class="form-control" type="text" name="vname[]" id="name'+i+'" value=""/></div></div><div class="col-sm-3"><div class="form-group"><label class="control-label" for="unit">Unit <span class="m-l-5 text-danger"> *</span></label><input class="form-control" type="text" name="unit[]" id="unit'+i+'" value=""/></div></div><div class="col-sm-3"><div class="form-group"><label class="control-label" for="price">Price <span class="m-l-5 text-danger"> *</span></label><input class="form-control"  name="price[]" id="price'+i+'" value=""/></div></div><div class="col-sm-2"><div class="form-group"><label class="control-label" for="in_stock">In Stock? <span class="m-l-5 text-danger"> *</span></label><select class="form-control" name="in_stock[]" id="in_stock'+i+'"><option value="">Select Type</option><option value="1">Yes</option><option value="0">No</option></select></div></div><div class="col-sm-1"><button class="btn btn-danger DeleteRow" type="button"><i class="bi bi-trash"></i> Delete</button></div></div>';

        $('#newinput').append(newRowAdd);
    });

    $("body").on("click", ".DeleteRow", function () {
        $(this).parents(".concat").remove();
    })
</script>
@endpush