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
                            <label class="control-label" for="lead">Lead <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="lead_id">
                                <option value="">Select Lead</option>
                                @foreach($leads as $lead)
                                <option value="{{$lead->id}}">{{$lead->uid}}</option>
                                @endforeach
                            </select>
                            @error('lead_id') {{ $message ?? '' }} @enderror
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label" for="name">Item <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control item" id="item1" onChange="jsfunction(1)" name="item_id[]">
                                <option value="">Select ITEM</option>
                                @foreach($items as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('name') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label" for="unit_price">Unit Price <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('unit_price') is-invalid @enderror" type="text" name="unit_price[]" id="unit_price1" value="{{ old('unit_price') }}"/>
                            @error('unit_price') {{ $message }} @enderror
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label" for="quantity">Quantity <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('quantity') is-invalid @enderror" type="text" name="quantity[]" id="quantity1" value="{{ old('quantity') }}"/>
                            @error('quantity') {{ $message }} @enderror
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label" for="sub_total">Sub Total <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('sub_total') is-invalid @enderror" type="number" name="sub_total[]" id="sub_total1" value="{{ old('sub_total') }}"/>
                            @error('sub_total') {{ $message }} @enderror
                        </div>
                    </div>
                    <div id="newinput"></div>
                    <button id="rowAdder" type="button"
                    class="btn btn-dark">
                    <span class="bi bi-plus-square-dotted">
                    </span> ADD More Item
                   </button>


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
         '<div class="row concat"><div class="col-sm-3"><label class="control-label" for="name">Item <span class="m-l-5 text-danger"> *</span></label><select class="form-control item" id="item'+i+'" name="item_id[]" onChange="jsfunction('+i+')"><option value="">Select ITEM</option>@foreach($items as $item)<option value="{{$item->id}}">{{$item->name}}</option>@endforeach</select></div><div class="col-sm-2"><label class="control-label" for="unit">Unit Price <span class="m-l-5 text-danger"> *</span></label><input class="form-control @error('unit') is-invalid @enderror" type="text" name="unit_price[]" id="unit_price'+i+'" value="{{ old('unit') }}"/></div><div class="col-sm-3"><label class="control-label" for="unit">Quantity <span class="m-l-5 text-danger"> *</span></label><input class="form-control @error('unit') is-invalid @enderror" type="text" name="quantity[]" id="quantity'+i+'" value="{{ old('unit') }}"/></div><div class="col-sm-3"><label class="control-label" for="price">Sub Total <span class="m-l-5 text-danger"> *</span></label><input class="form-control @error('price') is-invalid @enderror" type="number" name="sub_total[]" id="sub_total'+i+'" value="{{ old('price') }}"/></div><div class="col-sm-1"><button class="btn btn-danger DeleteRow" type="button"><i class="bi bi-trash"></i> Delete</button></div></div>';
         i++;

        $('#newinput').append(newRowAdd);
    });

    $("body").on("click", ".DeleteRow", function () {
        $(this).parents(".concat").remove();
    })
    function jsfunction(i){
        //alert(i);
        var itemID =  $('#item'+i+'').val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //alert( itemID );
        $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.item.fetchPrice')}}",
                data:{ _token: CSRF_TOKEN, itemID:itemID},
                success:function(response)
                {
                    //alert(response.message);
                    $('#unit_price'+i+'').val(response.message);
                
                },
                error: function(response)
                {
                    
                  swal("Error!", response.message, "error");
                }
              });
        
      
}
</script>
@endpush