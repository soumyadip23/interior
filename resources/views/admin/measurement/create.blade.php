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
                <form action="{{ route('admin.quatation.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
           
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="lead">Lead <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="lead_id">
                                <option value="">Select Lead</option>
                                @foreach($leads as $lead)
                                <option value="{{$lead->uid}}">{{$lead->uid}}</option>
                                @endforeach
                            </select>
                            @error('lead_id') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label class="control-label" for="next_follow_date">Property Type</label>
                        <input class="form-control" type="text" name="property_type" id="property_type" value="{{ old('property_type') }}"/>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label class="control-label" for="next_follow_date">Total Area (sq.ft)</label>
                        <input class="form-control" type="text" name="total_area" id="total_area" value="{{ old('total_area') }}"/>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label class="control-label" for="next_follow_date">No of Rooms </label>
                        <input class="form-control" type="number" name="no_of_rooms" id="no_of_rooms" value="1" onkeyup="CallFunction()"/>
                    </div>
                </div>



       
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label" for="unit_price">Width<span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('unit_price') is-invalid @enderror" type="text" name="unit_price[]" id="unit_price1" value="{{ old('unit_price') }}"/>
                            @error('unit_price') {{ $message }} @enderror
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label" for="quantity">Height <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('quantity') is-invalid @enderror" type="text" name="quantity[]" id="quantity1" value="" onkeyup="CallFunction(1)"/>
                            @error('quantity') {{ $message }} @enderror
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label" for="sub_total">Length <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control subT" type="number" name="sub_total[]" id="sub_total1" value="{{ old('sub_total') }}"/>
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
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.measurement.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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
         '<div class="row concat"><div class="col-sm-3"><label class="control-label" for="name">Item <span class="m-l-5 text-danger"> *</span></label><select class="form-control item" id="item'+i+'" name="item_id[]" onChange="fetchVariation('+i+')"><option value="">Select ITEM</option>@foreach($items as $item)<option value="{{$item->id}}">{{$item->name}}</option>@endforeach</select></div><div class="col-sm-3"><label class="control-label" for="name">Variation <span class="m-l-5 text-danger"> *</span></label><select class="form-control variation" id="variation'+i+'" onChange="jsfunction('+i+')" name="variation[]"><option value="">Select Variation</option></select></div><div class="col-sm-2"><label class="control-label" for="unit">Unit Price <span class="m-l-5 text-danger"> *</span></label><input class="form-control @error('unit') is-invalid @enderror" type="text" name="unit_price[]" id="unit_price'+i+'" value="{{ old('unit') }}" readonly/></div><div class="col-sm-2"><label class="control-label" for="unit">Quantity <span class="m-l-5 text-danger"> *</span></label><input class="form-control @error('unit') is-invalid @enderror" type="text" name="quantity[]" id="quantity'+i+'" value="1" onkeyup="CallFunction('+i+')"/></div><div class="col-sm-2"><label class="control-label" for="price">Sub Total <span class="m-l-5 text-danger"> *</span></label><input class="form-control subT" type="number" name="sub_total[]" id="sub_total'+i+'" value="{{ old('price') }}"/></div><button class="btn btn-danger DeleteRow" type="button"><i class="bi bi-trash"></i> Delete</button></div>';
         i++;

        $('#newinput').append(newRowAdd);
    });

    $("body").on("click", ".DeleteRow", function () {
        $(this).parents(".concat").remove();
    })
    function jsfunction(i){
        //alert(i);
        var itemID =  $('#variation'+i+'').val();
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
                    $('#sub_total'+i+'').val(response.message);

                    var calculated_total_sum = 0;
                    $(".subT").each(function () {
                            var get_textbox_value = $(this).val();
                            //alert(get_textbox_value);
                            if ($.isNumeric(get_textbox_value)) {
                                calculated_total_sum += parseFloat(get_textbox_value);
                                }                  
                    });
                    $("#quote_sub_total").val(calculated_total_sum);
                    $("#quote_final_total").val(calculated_total_sum);
                
                },
                error: function(response)
                {
                    
                  swal("Error!", response.message, "error");
                }
              });
              
        
      
}
function fetchVariation(i){
        //alert(i);
        var itemID =  $('#item'+i+'').val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //alert( itemID );
        $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.item.fetchVariations')}}",
                data:{ _token: CSRF_TOKEN, itemID:itemID},
                success:function(response)
                {
                    var data = response.message; 
                     var formoption = "<option value=''> Select Variation </option>";
                    $.each(data, function(v) {
                        var val = data[v].name;
                        var id = data[v].id;
                        formoption += "<option value='" + id + "'>" + val + "</option>";
                    });
                    $('#variation'+i+'').html(formoption);
                
                },
                error: function(response)
                {
                    
                  swal("Error!", response.message, "error");
                }
              });
        
      
}

function CallFunction() {
         //alert(i);
         var noOfRooms =  $('#no_of_rooms').val();
         //alert(noOfRooms);
         $('#newinput').empty();
         var i;
        for (i = 1; i < noOfRooms; i++) {
              newRowAdd =
                     '<div class="row concat"><div class="col-sm-3"><label class="control-label" for="unit">Width <span class="m-l-5 text-danger"> *</span></label><input class="form-control @error('unit') is-invalid @enderror" type="text" name="unit_price[]" id="unit_price'+i+'" value="{{ old('unit') }}" readonly/></div><div class="col-sm-3"><label class="control-label" for="unit">Width <span class="m-l-5 text-danger"> *</span></label><input class="form-control @error('unit') is-invalid @enderror" type="text" name="quantity[]" id="quantity'+i+'" value="1" onkeyup="CallFunction('+i+')"/></div><div class="col-sm-3"><label class="control-label" for="price">Length <span class="m-l-5 text-danger"> *</span></label><input class="form-control subT" type="number" name="sub_total[]" id="sub_total'+i+'" value="{{ old('price') }}"/></div></div>';
  
           $('#newinput').append(newRowAdd);
        }

     
}
function CallTax() {
         //alert(i);
         var unitPrice =  $('#quote_sub_total').val();
         var tax =  $('#tax').val();
         var labourCost =  $('#labour_cost').val();

         var taxAmount  =  unitPrice * (tax/100 ); 
         

         var total = parseFloat(unitPrice)  +  parseFloat(taxAmount); 


         var discount =  $('#discount').val(); 


        var disAmt =  parseFloat(total) * (discount/100 );


        var totalAmt = parseFloat(total)  - parseFloat(disAmt); 

        var finalAmt =  parseFloat(totalAmt)  + parseFloat(labourCost); 
 
         $("#quote_final_total").val(finalAmt);

}

function CallDiscount() {
         //alert(i);
         var unitPrice =  $('#quote_sub_total').val();
         var tax =  $('#tax').val();
         var labourCost =  $('#labour_cost').val();
         var taxAmount  =  unitPrice * (tax/100 ); 

         var total = parseFloat(unitPrice)  +  parseFloat(taxAmount); 


         var discount =  $('#discount').val(); 

         //alert(discount);

         var disAmt =  parseFloat(total) * (discount/100 );

         

         var totalAmt = parseFloat(total)  - parseFloat(disAmt); 


       //  alert(totalAmt);

         //alert(labourCost);

         var finalAmt =  parseFloat(totalAmt)  + parseFloat(labourCost); 

         
 
         $("#quote_final_total").val(finalAmt);

}

</script>
@endpush