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
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="next_follow_date">Form Date</label>
                        <input class="form-control" type="date" name="form_date" id="date_of_birth" value="{{ old('form_date') }}"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="next_follow_date">Expiry Date</label>
                        <input class="form-control" type="date" name="expiry_date" id="date_of_birth" value="{{ old('expiry_date') }}"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="Note">Notes</label>
                <textarea class="form-control" rows="1" name="notes" id="notes">{{ old('notes') }}</textarea>
            </div>
                 
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label" for="name">Item <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control item" id="item1" onChange="fetchVariation(1)" name="item_id[]">
                                <option value="">Select ITEM</option>
                                @foreach($items as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('name') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label" for="name">Variation <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control variation" id="variation1" onChange="jsfunction(1)" name="variation[]">
                                <option value="">Select Variation</option>
                            </select>
                            @error('name') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label" for="unit_price">Unit Price <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('unit_price') is-invalid @enderror" type="text" name="unit_price[]" id="unit_price1" value="{{ old('unit_price') }}" readonly/>
                            @error('unit_price') {{ $message }} @enderror
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label" for="quantity">Quantity <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('quantity') is-invalid @enderror" type="text" name="quantity[]" id="quantity1" value="1" onkeyup="CallFunction(1)"/>
                            @error('quantity') {{ $message }} @enderror
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label" for="sub_total">Sub Total <span class="m-l-5 text-danger"> *</span></label>
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

                   <div class="row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="next_follow_date">Quote Sub Total:</label>
                            <input class="form-control @error('quote_sub_total') is-invalid @enderror" type="number" name="quote_sub_total" id="quote_sub_total" value="{{ old('quote_sub_total') }}"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="next_follow_date">Tax:(%)</label>
                            <input class="form-control @error('tax') is-invalid @enderror" type="number" name="tax" id="tax" value="{{ old('tax') }}" onkeyup="CallTax()"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="next_follow_date">Discount:(%)</label>
                            <input class="form-control @error('discount') is-invalid @enderror" type="number" name="discount" id="discount" value="{{ old('discount') }}" onkeyup="CallDiscount()"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="next_follow_date">Labour Cost</label>
                            <input class="form-control @error('labour_cost') is-invalid @enderror" type="number" name="labour_cost" id="labour_cost" value="0"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="next_follow_date"> Total:</label>
                            <input class="form-control @error('quote_final_total') is-invalid @enderror" type="text" name="quote_final_total" id="quote_final_total" value="{{ old('quote_final_total') }}"/>
                        </div>
                    </div>
                </div>


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

function CallFunction(i) {
         //alert(i);
         var unitPrice =  $('#unit_price'+i+'').val();
         var qty =  $('#quantity'+i+'').val();
         //alert(qty);
         var subTotal =  unitPrice * qty; 
         $('#sub_total'+i+'').val(subTotal);


         var calculated_total_sum = 0;
     
     $(".subT").each(function () {
                var get_textbox_value = $(this).val();
                if ($.isNumeric(get_textbox_value)) {
                    calculated_total_sum += parseFloat(get_textbox_value);
                    }                  
          });
    $("#quote_sub_total").val(calculated_total_sum);
    $("#quote_final_total").val(calculated_total_sum);

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