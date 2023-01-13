@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
                <p>{{ $subTitle }}</p>
            </div>
            <a href="{{ route('admin.invite.create') }}" class="btn btn-primary pull-right">Invite Admin</a>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="alert alert-success" id="success-msg" style="display: none;">
        <span id="success-text"></span>
    </div>
    <div class="alert alert-danger" id="error-msg" style="display: none;">
        <span id="error-text"></span>
    </div>
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Name </th>
                                <th> Email </th>
                                <th class="text-center"> Phone </th>
                                <th class="text-center"> Status </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                                    <tr>
                                        <td>{{ isset($user['name']) ? $user['name']:'' }}</td>
                                        <td>{{ $user['email'] }}</td>
                                        <td class="text-center">{{ isset($user['phone']) ? $user['phone']:'N/A'}}</td>
                                        <td class="text-center">
                                            @if (array_key_exists('registered_at', $user))
                                            <span class="badge badge-notverified">Pending</span>
                                            @else
                                            <div class="toggle-button-cover margin-auto">
                                                <div class="button-cover">
                                                    <div class="button-togglr b2" id="button-10">
                                                    <input id="toggle-block" type="checkbox" class="checkbox" data-user_id="{{ $user['id'] }}" {{ $user["is_block"] == 1 ? 'checked' : '' }}>
                                                    <div class="knobs">
                                                        <span>Active</span>
                                                    </div>
                                                    <div class="layer"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                    </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
    $('#sampleTable').DataTable({"ordering": false});
    
    $('input[id="toggle-block"]').change(function() {
        var user_id = $(this).data('user_id');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var check_block_status = 0;
        if($(this).is(":checked")){
            check_block_status = 1;
        }else{
        check_block_status = 0;
        }
        $.ajax({
            type:'POST',
            dataType:'JSON',
            url:"{{route('admin.adminuser.update')}}",
            data:{ _token: CSRF_TOKEN, id:user_id, is_block:check_block_status},
            success:function(response)
            {
                // $('#success-text').text(response.message);
                // $('#success-msg').show();
                // $('#success-msg').fadeOut(2000);
                swal("Success!", response.message, "success");
            },
            error: function()
            {
                // $('#error-text').text("Error! Please try again later");
                // $('#error-msg').show();
                // $('#error-msg').fadeOut(2000);
                swal("Error!", response.message, "error");
            }
            });
    });

    </script>
@endpush