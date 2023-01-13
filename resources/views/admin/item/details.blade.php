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
                            <td>Category :</td>
                            <td>{{ empty($item['category']->title)? null:$item['category']->title }}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{!! empty($item['name'])? null:($item['name']) !!}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{!! empty($item['description'])? null:($item['description']) !!}</td>
                        </tr>   
                    </tbody>
                </table>
                <table class="table table-hover custom-data-table-style table-striped table-col-width"> 
                    <thead>
                        <tr>
                         <th>Variation name</th>
                         <th>Price</th>
                        <th>Unit</th>
                         <th>Stock</th>
                    </thead>
                    <tbody>
                           <tr>
                         <?php  foreach ($item['itemVariation'] as $itemvari){ ?>
                         <td> <?php echo $itemvari['name']; ?> </td>
                         <td> <?php echo $itemvari['price']; ?> </td>
                         <td> <?php echo $itemvari['unit']; ?> </td>
                         <td> <?php echo   ($itemvari['stock'] == '0')?'No':'Yes'; ?> </td>
                          </tr>
                        <?php } ?>
                    </tbody>
                    </table>
            </div>

           
        </div>
    </div>
@endsection