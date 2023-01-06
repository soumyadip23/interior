@extends('admin.app')

@section('title') {{ $pageTitle }} @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
                <h1><i class="fa fa-user"></i> {{ $pageTitle }}</h1>
                <div class="form-group">
                    <button class="btn btn-primary" id="btnSave" type="button"><i class="fa fa-check-circle"></i>Update <span id="btn-name"></span></button>
                    <!-- <button class="btn btn-primary" id="btnSave1" type="button" style="display: none;"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update <span id="btn-name"></span> Password</button> -->
                    <a class="btn btn-secondary" href="{{ URL::previous() }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="user">
            <div class="col-md-12 nopadding">
                <div class="tile p-0">
                    <ul class="nav nav-tabs user-tabs" id="myTab">
                        <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a></li>
                        <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Change Password</a></li>
                    </ul>
                </div>
            </div>  
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row row-md-body">
        <div class="col-md-12">
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    @include('admin.profile.includes.general')
                </div>
                <div class="tab-pane fade" id="password">
                    @include('admin.profile.includes.password')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
var hash = "#general";
$(function(){
  $("#btn-name").text("Profile");
  //hash && $('ul.nav a[href="' + hash + '"]').tab('show');

  // $('.nav-tabs a').click(function (e) {
  //   //$(this).tab('show');
  //   var scrollmem = $('body').scrollTop();
  //   window.location.hash = this.hash;
  //   $('html,body').scrollTop(scrollmem);
  // });
});

    $('.nav-tabs > li > a').click( function() {
        hash = $(this).attr('href');
        if(hash=='#general'){
            $("#btn-name").text("Profile");
            window.location.hash = hash;
        }else if(hash=='#password'){
            $("#btn-name").text("Password");
            window.location.hash = hash;
        }
    });

    $("#btnSave").on("click",function(){
        //alert("hello >>"+hash);
        if(hash=='#general'){
            $('#formgeneral').submit();
        }else if(hash=='#password'){
            $('#formpassword').submit();
        }
        window.location.hash = hash;
    })

    
</script>
@endpush