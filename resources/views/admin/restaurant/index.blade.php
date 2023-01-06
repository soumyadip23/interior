@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@php
$name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
$mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
$address = (isset($_GET['address']) && $_GET['address']!='')?$_GET['address']:'';
$status = (isset($_GET['status']) && $_GET['status']!='')?$_GET['status']:'';
@endphp
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.restaurant.create') }}" class="btn btn-primary pull-right">Add New</a>
    </div>
    @include('admin.partials.flash')
    <div class="row">
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
                                    Address <br/>
                                    <input type="text" class="form-control" name="order_id" placeholder="Address" value="{{$address}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    Status <br/>
                                    <select class="form-control" name="status">
                                        <option value="">Select Status</option>
                                        <option value="1" @if($status=='1'){{"selected"}}@endif>Active</option>
                                        <option value="0" @if($status=='0'){{"selected"}}@endif>Not Active</option>
                                    </select>
                                </td>
                                <td style="padding: 10px 5px;">
                                    <button class="btn btn-primary" type="submit" id="btnSave"><i class="fa fa-fw fa-lg fa-check-circle"></i>Search</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </form>
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Id</th>
                                <th> Name </th>
                                <th> Image </th>
                                <th> Address </th>
                                <th> Working Hour </th>
                                <th> Status </th>
                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($restaurants as $key => $restaurant)
                                <tr>
                                    <td>{{ $restaurant->id }} </td>
                                    <td>{{ $restaurant->name }}<br>Mobile :{{ $restaurant->mobile }} <br><a href="{{ route('admin.restaurant.change_password', $restaurant['id']) }}" class="btn btn-sm btn-primary edit-btn">Change Password</a></td>
                                    <td>
                                        @if($restaurant->image!='')
                                        <img style="width: 50px;height: 50px;" src="{{$restaurant->image}}">
                                        @endif
                                    </td>
                                    <td>{{ $restaurant->address }}</td>
                                    <td>Start : {{ $restaurant->start_time }}<br>Close :{{ $restaurant->close_time }}</td>
                                    <td class="text-center">
                                    <div class="toggle-button-cover margin-auto">
                                        <div class="button-cover">
                                            <div class="button-togglr b2" id="button-11">
                                                <input id="toggle-block" type="checkbox" name="status" class="checkbox" data-restaurant_id="{{ $restaurant['id'] }}" {{ $restaurant['status'] == 1 ? 'checked' : '' }}>
                                                <div class="knobs"><span>Inactive</span></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Second group">
                                        <a href="{{ route('admin.restaurant.edit', $restaurant['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.restaurant.details', $restaurant['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                        <a href="#" data-id="{{$restaurant['id']}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$restaurants->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <!-- <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script> -->
     {{-- New Add --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
    $('.sa-remove').on("click",function(){
        var restaurantid = $(this).data('id');
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
            window.location.href = "restaurant/"+restaurantid+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
    <script type="text/javascript">
        $('input[id="toggle-block"]').change(function() {
            var restaurant_id = $(this).data('restaurant_id');
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
                url:"{{route('admin.restaurant.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, id:restaurant_id, check_status:check_status},
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