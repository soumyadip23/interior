@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@php
    $errors = Session::get('error');
    $messages = Session::get('success');
    $info = Session::get('info');
    $warnings = Session::get('warning');
@endphp
@if ($errors) 
	@foreach($errors as $key => $value)
	    <!-- <div class="alert alert-danger alert-dismissible" role="alert">
	        <button class="close" type="button" data-dismiss="alert">×</button>
	        <strong>Error!</strong> {{ $value }}
	    </div> -->
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
	    <script type="text/javascript">
		swal("Error!", "{{ $value }}", "error")
		</script>
	@endforeach 
@endif

@if ($messages)
@foreach($messages as $key => $value) 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
	<script type="text/javascript">
	swal("Success!", "{{ $value }}", "success")
	</script>
	@endforeach 
@endif

@if ($info) 
	@foreach($info as $key => $value)
	    <div class="alert alert-info alert-dismissible" role="alert">
	        <button class="close" type="button" data-dismiss="alert">×</button>
	        <strong>Info!</strong> {{ $value }}
	    </div>
	@endforeach 
@endif

@if ($warnings) 
	@foreach($warnings as $key => $value)
	    <!-- <div class="alert alert-warning alert-dismissible" role="alert">
	        <button class="close" type="button" data-dismiss="alert">×</button>
	        <strong>Warning!</strong> {{ $value }}
	    </div> -->
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
	    <script type="text/javascript">
		swal("Warning!", "{{ $value }}", "warning")
		</script>
	@endforeach 
@endif
