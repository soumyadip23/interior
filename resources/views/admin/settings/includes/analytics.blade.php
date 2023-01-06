<div class="tile">
    <form id="analytics-form" action="{{ route('admin.settings.update') }}" method="POST" role="form">
        @csrf
        <h3 class="tile-title">Analytics</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="google_analytics">Google Analytics Code</label>
                <textarea
                    class="form-control"
                    rows="4"
                    placeholder="Enter google analytics code"
                    id="google_analytics"
                    name="google_analytics"
                >{!! $setting::get('google_analytics') !!}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label" for="facebook_pixels">Facebook Pixel Code</label>
                <textarea
                    class="form-control"
                    rows="4"
                    placeholder="Enter facebook pixel code"
                    id="facebook_pixels"
                    name="facebook_pixels"
                >{!! $setting::get('facebook_pixels') !!}</textarea>
            </div>
        </div>
    </form>
</div>