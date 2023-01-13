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
                        <tr>
                            <td>Price</td>
                            <td>{!! empty($item['price'])? null:($item['price']) !!}</td>
                        </tr>
                        <tr>
                            <td>Unit</td>
                            <td>{!! empty($item['unit'])? null:($item['unit']) !!}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>

           
        </div>
    </div>
@endsection