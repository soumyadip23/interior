@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style type="text/css">
        .details_badge_item{
            margin-right: 15px;
        }    
    </style>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="details_badge_list d-flex flex-wrap mb-3 mb-lg-3">
        <a href="{{ route('admin.boys.details', $boy['id']) }}" class="details_badge_item btn btn-primary">Basic Details</a>
        <a href="{{ route('admin.boys.genetaredleeds', $boy['id']) }}" class="details_badge_item btn btn-primary">Generated Leads</a>
        <a href="{{ route('admin.boys.assignedleeds', $boy['id']) }}" class="details_badge_item btn btn-primary">Assigned Leads</a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ empty($boy['name'])? null:$boy['name'] }}</td>
                        </tr>
                        <tr>
                            <td>Email Id</td>
                            <td>{{ empty($boy['email'])? null:$boy['email'] }}</td>
                        </tr>
                        <tr>
                            <td>Mobile No</td>
                            <td>{{ empty($boy['mobile'])? null:$boy['mobile'] }}</td>
                        </tr>
                        <tr>
                            <td>Image</td>
                            <td>@if($boy->image!='')
                                <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/delivery_boys/'}}{{$boy->image}}">
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ empty($boy['country'])? null:$boy['country'] }}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{ empty($boy['city'])? null:$boy['city'] }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ empty($boy['address'])? null:$boy['address'] }}</td>
                        </tr>
                        <tr>
                            <td>Pin Code</td>
                            <td>{{ empty($boy['pin'])? null:$boy['pin'] }}</td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td>{{ empty($boy['gender'])? null:$boy['gender'] }}</td>
                        </tr>
                        <tr>
                            <td>Date Of Birth</td>
                            <td>{{ empty($boy['date_of_birth'])? null:$boy['date_of_birth'] }}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection