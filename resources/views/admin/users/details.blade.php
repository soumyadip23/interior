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
         <a href="{{ route('admin.users.details', $user['id']) }}" class="details_badge_item btn btn-primary">Basic Details</a>
        <a href="{{ route('admin.users.orders', $user['id']) }}" class="details_badge_item btn btn-primary">Quatation List</a>
        <a href="{{ route('admin.users.reviews', $user['id']) }}" class="details_badge_item btn btn-primary">Project List</a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ empty($user['name'])? null:$user['name'] }}</td>
                        </tr>
                        <tr>
                            <td>Email Id</td>
                            <td>{{ empty($user['email'])? null:$user['email'] }}</td>
                        </tr>
                        <tr>
                            <td>Mobile No</td>
                            <td>{{ empty($user['mobile'])? null:$user['mobile'] }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ empty($user['country'])? null:$user['country'] }}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{ empty($user['city'])? null:$user['city'] }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ empty($user['address'])? null:$user['address'] }}</td>
                        </tr>
                        <tr>
                            <td>Contact Person</td>
                            <td>{{ empty($user['contact_person'])? null:$user['contact_person'] }}</td>
                        </tr>
                        <tr>
                            <td>Contact No</td>
                            <td>{{ empty($user['contact_no'])? null:$user['contact_no'] }}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection