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
    <div class="details_badge_list d-flex flex-wrap mb-3 mb-lg-3">
        <a href="{{ route('admin.leads.feedback', $lead['id']) }}" class="details_badge_item btn btn-primary">Feedback(s)</a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Customer Name:</td>
                            <td>{{ empty($lead['customer_name'])? null:$lead['customer_name'] }}</td>
                        </tr>
                        <tr>
                            <td>Customer Mobile</td>
                            <td>{!! empty($lead['customer_mobile'])? null:($lead['customer_mobile']) !!}</td>
                        </tr>
                        <tr>
                            <td>Customer Email</td>
                            <td>{!! empty($lead['customer_email'])? null:($lead['customer_email']) !!}</td>
                        </tr>
                        <tr>
                            <td>Customer Address</td>
                            <td>{!! empty($lead['customer_address'])? null:($lead['customer_address']) !!}</td>
                        </tr>
                        <tr>
                            <td>Requirement</td>
                            <td>{!! empty($lead['requirement'])? null:($lead['requirement']) !!}</td>
                        </tr>
                        <tr>
                            <td>Source</td>
                            <td>{!! empty($lead['source'])? null:($lead['source']) !!}</td>
                        </tr>
                        <tr>
                            <td>Budget</td>
                            <td>{!! empty($lead['budget'])? null:($lead['budget']) !!}</td>
                        </tr>
                        <tr>
                            <td>Assigned To</td>
                            <td>{!! empty($assigned_staff['name'])? null:($assigned_staff['name']) !!}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>

           
        </div>
    </div>
@endsection