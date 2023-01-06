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
                            <td>Blog Title</td>
                            <td>{{ empty($blog['title'])? null:$blog['title'] }}</td>
                        </tr>
                        <tr>
                            <td>Blog Image</td>
                            <td>@if($blog->image!='')
                                <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/blogs/'}}{{$blog->image}}">
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{!! empty($blog['description'])? null:($blog['description']) !!}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>

           
        </div>
    </div>
@endsection