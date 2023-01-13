@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.lead.create') }}" class="btn btn-primary pull-right">Add New</a>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th> Customer Name </th>
                                <th> Requirement</th>
                                <th> Budget </th>
                                <th> Status </th>
                                <th> Date </th>

                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leads as $key => $lead)
                                <tr>
                                    <td>{{ $lead->id }}</td>
                                    <td>{{ $lead->customer_name}}</td>
                                    <td>
                                        @php 
                                            $desc = strip_tags($lead['requirement']);
                                            $length = strlen($desc);
                                            if($length>50)
                                            {
                                                $desc = substr($desc,0,50)."...";
                                            }else{
                                                $desc = substr($desc,0,50);
                                            }
                                        @endphp
                                        {!! $desc !!}
                                    </td>
                                    <td>
                                        {{ $lead->budget }}
                                    </td>
                                    <?php       if($lead->status === 0){ $stat = 'new'; } 
                                                elseif($lead->status === 1){ $stat = 'open';}
                                                elseif($lead->status === 2){ $stat = 'working';}
                                                elseif($lead->status === 3){ $stat = 'Disqualified';} 
                                                elseif($lead->status === 4){ $stat = 'Not a Target';} 
                                                elseif($lead->status === 5){ $stat = 'Nurture';} 
                                    ?>
                                    <td class="text-center">
                                        {{ $stat }}
                                   </td>
                                   <td class="text-center">
                                    {{   date( 'Y-m-d', strtotime($lead->created_at))  }}
                               </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Second group">
                                        <a href="{{ route('admin.lead.edit', $lead['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.lead.details', $lead['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                        <a href="#" data-id="{{$lead['id']}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a>
                                    </div>
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
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
     {{-- New Add --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
    $('.sa-remove').on("click",function(){
        var leadid = $(this).data('id');
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
            window.location.href = "lead/"+leadid+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
    <script type="text/javascript">
        $('input[id="toggle-block"]').change(function() {
            var blog_id = $(this).data('blog_id');
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
                url:"{{route('admin.blog.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, id:blog_id, check_status:check_status},
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