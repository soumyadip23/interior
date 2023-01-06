@extends('admin.app')

@section('title') {{ $pageTitle }} @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
                <h1><i class="fa fa-cogs"></i> {{ $pageTitle }}</h1>
                <div class="form-group">
                <button class="btn btn-primary" id="btnSave" type="button"><i class="fa fa-check-circle"></i>Update <span id="btn-name"></span> Settings</button>
                <a class="btn btn-secondary" href="{{ URL::previous() }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="user">
            <div class="col-md-12 nopadding">
                <div class="tile p-0">
                    <ul class="nav nav-tabs user-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="#site-logo" data-toggle="tab">Site Logo</a></li>
                        <li class="nav-item"><a class="nav-link" href="#footer-seo" data-toggle="tab">Footer &amp; SEO</a></li> -->
                        <li class="nav-item"><a class="nav-link" href="#social-links" data-toggle="tab">Social Links</a></li>
                        {{-- <li class="nav-item"><a class="nav-link" href="#analytics" data-toggle="tab">Analytics</a></li> --}}
                        <li class="nav-item"><a class="nav-link" href="#payments" data-toggle="tab">Payments</a></li>
                        {{-- <li class="nav-item"><a class="nav-link" href="#robots" data-toggle="tab">Robot</a></li> --}}
                        <!-- <li class="nav-item"><a class="nav-link" href="#" data-toggle="tab">Sitemap</a></li> -->
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
                    @include('admin.settings.includes.general')
                </div>
                <div class="tab-pane fade" id="site-logo">
                    @include('admin.settings.includes.logo')
                </div>
                <div class="tab-pane fade" id="footer-seo">
                    @include('admin.settings.includes.footer_seo')
                </div>
                <div class="tab-pane fade" id="social-links">
                    @include('admin.settings.includes.social_links')
                </div>
                <div class="tab-pane fade" id="analytics">
                    @include('admin.settings.includes.analytics')
                </div>
                <div class="tab-pane fade" id="payments">
                    @include('admin.settings.includes.payments')
                </div>
                <div class="tab-pane fade" id="robots">
                    @include('admin.settings.includes.robots')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
$(function(){
    var hash = $('.nav-tabs a.active').attr('href');
    var activeTab = $('.nav-tabs a.active').text();
    $("#btn-name").text(activeTab);
    //hash && $('ul.nav a[href="' + hash + '"]').tab('show');

    $("#btnSave").on("click",function(){
        $(hash+"-form").submit();
    });

    $('.nav-tabs a').click(function (e) {
        activeTab = $(this).text();
        hash = $(this).attr('href');
        $("#btn-name").text(activeTab);
    });
});
</script>
@endpush