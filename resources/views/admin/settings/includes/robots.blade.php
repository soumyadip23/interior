<div class="tile">
    <form id="robots-form" action="{{ route('admin.settings.update') }}" method="POST" role="form">
        @csrf
        <h3 class="tile-title">Robot</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="google_analytics">Robot Code</label>
                <textarea
                    class="form-control"
                    rows="8"
                    placeholder="Enter Robot code"
                    id="robot_txt"
                    name="robot_txt"
                >{!! $setting::get('robot_txt') !!}</textarea>
            </div>
        </div>
    </form>
</div>