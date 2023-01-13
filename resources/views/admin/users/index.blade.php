@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@php
$name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
$mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
$email = (isset($_GET['email']) && $_GET['email']!='')?$_GET['email']:'';
$status = (isset($_GET['status']) && $_GET['status']!='')?$_GET['status']:'';
$order_placed = (isset($_GET['order_placed']) && $_GET['order_placed']!='')?$_GET['order_placed']:'';
@endphp
   <div class="fixed-row">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-text"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary pull-right">Add New</a>
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
                  
                    <form action="">
                    <table class="table table-hover custom-data-table-style table-striped" id="">
                        <tbody>
                            <tr>
                                <td style="padding: 10px 5px;">
                                    Name <br/>
                                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{$name}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    Mobile No <br/>
                                    <input type="text" class="form-control" name="mobile" placeholder="Mobile No" value="{{$mobile}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    Email Id <br/>
                                    <input type="text" class="form-control" name="email" placeholder="Email Id" value="{{$email}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    Location <br/>
                                    <input type="text" class="form-control" name="location" placeholder="Location" value="{{$location}}">
                                </td>
                                
                                <td style="padding: 10px 5px;">
                                    Select categories  <br/>
                                    
                                    <select class="form-control categorySelect" name="cat_id[]" multiple="multiple">
                                            {{-- <option value="">Select Category</option> --}}
                                            @foreach($categories as $cat)
                                           
                                            <option value="{{$cat->id}}" <?php if($cat_id !="") { $res = in_array($cat->id,$cat_id); if($res){ echo 'selected';}else{ echo '';}}?>>{{$cat->title}}</option>
                                            @endforeach
                                        </select>
                                </td> 
                                <td style="padding: 10px 5px;">
                                    <button class="btn btn-primary" type="submit" id="btnSave"><i class="fa fa-fw fa-lg fa-check-circle"></i>Search</button>
                                </td>
                                <td style="padding: 10px 5px;">
                                  <a href="{{ route('admin.users.index') }}">   <button class="btn btn-danger" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Reset</button></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </form>

                 
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Name</th>
                                <th> Email</th>
                                <th> Address</th>
                                <th class="text-center"> Phone</th>
                                <th>Categories</th>
                                <th class="align-center"> Status</th>
                                <th class="align-center"> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user_detail)
                                <tr>
                                    <td>{{ $user_detail['name'] }}<br></td>
                                    <td>{{ $user_detail['email'] }}
                                        <br />
                                        @if ($user_detail['is_verified']==1)
                                            <span class="badge badge-verified emailV-tag">Verified</span>
                                        @else
                                            <span class="badge badge-notverified emailV-tag">Not verified</span>
                                        @endif
                                    </td>

                                    <td>{{ $user_detail['address'] }}<br></td>

                                    <td class="text-center">{{ (empty($user_detail['mobile']))? "N/A":($user_detail['mobile']) }}</td>
                                    <td><?php echo rtrim($user_detail->user_cat, ','); ?></td>
                                    <td class="text-center">
                                    <div class="toggle-button-cover margin-auto">
                                        <div class="button-cover">
                                            <div class="button-togglr b2" id="button-11">
                                                <input id="toggle-block" type="checkbox" name="status" class="checkbox" data-user_id="{{ $user_detail['id'] }}" {{ $user_detail['status'] == 1 ? 'checked' : '' }}>
                                                <div class="knobs"><span>Inactive</span></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                    </div>
                                    </td>
                                    <td class="align-center">
                                       
                                       <div class="btn-group" role="group" aria-label="Second group">
                                        <a href="{{ route('admin.users.edit', $user_detail['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.users.details', $user_detail['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                        <a href="#" data-id="{{$user_detail['id']}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                            <div class="custom-file text-left">
                                <input type="file" name="file" class="custom-file-input" id="customFile" required>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <a class="btn btn-success" href="{{ route('file-export') }}">Export data</a>
                        <button class="btn btn-primary">Import data</button>
                        
                    </form>

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
    <!-- <script type="text/javascript">
        $('#sampleTable').DataTable({"ordering": false});
    </script> -->
    <script type="text/javascript">
    $('.sa-remove').on("click",function(){
        var userid = $(this).data('id');
        swal({
          title: "Are you sure?",
          text: "Your will not be able to recover the record!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "users/"+userid+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
    <script type="text/javascript">
        $('input[id="toggle-block"]').change(function() {
            var user_id = $(this).data('user_id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var check_status = 0;
          if($(this).is(":checked")){
              check_status = 1;
          }else{
            check_status = 0;
          }
          $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.users.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, id:user_id, check_status:check_status},
                success:function(response)
                {
                  swal("Success!", response.message, "success");
                },
                error: function(response)
                {
                    
                  swal("Error!", response.message, "error");
                }
              });
        });
    </script>
@endpush