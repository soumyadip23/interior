@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Form Date :</td>
                            <td>{!! empty($item['form_date'])? null:($item['form_date']) !!}</td>
                        </tr>
                        <tr>
                            <td>Expiry Date: </td>
                            <td>{!! empty($item['expiry_date'])? null:($item['expiry_date']) !!}</td>
                        </tr>
                        <tr>
                            <td>Note: </td>
                            <td>{!! empty($item['notes'])? null:($item['notes']) !!}</td>
                        </tr>   
                    </tbody>
                </table>
                <table class="table table-hover custom-data-table-style table-striped table-col-width"> 
                    <thead>
                        <tr>
                         <th>ITEM Type</th>
                         <th>Variaion</th>
                         <th>Unit Price</th>
                        <th>Quantity</th>
                         <th>Amount</th>
                    </thead>
                    <tbody>
                           <tr>
                         <?php 
                              $total_unit_price = 0;
                             foreach ($item['quatationDetails'] as $itemvari){ 
                                $total_unit_price = $total_unit_price + $itemvari['price'];
                        ?>
                        <td> <?php echo $itemvari['item_name']; ?> </td>
                         <td> <?php echo $itemvari['variation_name']; ?> </td>
                         <td> <?php echo $itemvari['unit_price']; ?> </td>
                         <td> <?php echo $itemvari['quantity']; ?> </td>
                         <td> <?php echo $itemvari['price']; ?> </td>
                          </tr>
                        <?php } ?>
                    </tbody>
                    </table>
            </div>

           
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Sub Total  </td>
                            <td>{!! empty($total_unit_price)? null:($total_unit_price) !!}</td>
                        </tr>
                        <tr>
                            <td>Tax:(%) </td>
                            <td>{!! empty($item['tax'])? null:($item['tax']) !!}</td>
                        </tr>
                        <tr>
                            <td>Discount:(%) </td>
                            <td>{!! empty($item['discount'])? null:($item['discount']) !!}</td>
                        </tr>   
                        <tr>
                            <td>Labour Cost </td>
                            <td>{!! empty($item['labour_cost'])? null:($item['labour_cost']) !!}</td>
                        </tr> 
                        <tr>
                            <td>Total: </td>
                            <td>{!! empty($item['total'])? null:($item['total']) !!}</td>
                            <td> @if($item['pdf_document']!='') <p>Quatation File: <a target="_blank" href="{{URL::to('/').'/quatations/'.$item['pdf_document']}}">PDF</a></p> @endif</td>
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection