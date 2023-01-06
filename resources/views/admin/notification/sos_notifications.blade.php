@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.notification.create') }}" class="btn btn-primary pull-right">Add New</a>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Sr No</th>
                                <th> Date </th>
                                <th> Notification </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $srNo=1; 
                            @endphp
                            @foreach($notifications as $key => $notification)
                                <tr>
                                    <td>{{ $srNo }}</td>
                                    <td>{{ date("d-M-Y h:i a",strtotime($notification->created_at)) }}</td>
                                    <td>{{ $notification->notification }}</td>
                                </tr>
                                @php $srNo++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
   
@endpush