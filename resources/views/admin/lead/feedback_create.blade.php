@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}
                   
                </h3>
                <hr>
                <form action="{{ route('admin.feedback.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <input type="hidden" name="lead_id" value="{{$lead['lead_id']}}">
                        <div class="form-group">
                            <label class="control-label" for="client_comment">Client's Feedback <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control" rows="4" name="client_comment" id="client_comment">{{ old('client_comment') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="staff_comment">Staff's Feedback</label>
                            <textarea class="form-control" rows="1" name="staff_comment" id="staff_comment">{{ old('staff_comment') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="next_follow_date">Next Follow-up Date</label>
                            <input class="form-control" type="date" name="next_follow_date" id="date_of_birth" value="{{ old('next_follow_date') }}"/>
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Feedback</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.lead.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection