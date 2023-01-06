<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form" id="general-form">
        @csrf
        <h3 class="tile-title">General</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="site_name">Site Name</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter site name"
                    id="site_name"
                    name="site_name"
                    value="{{ $setting::get('site_name') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="site_title">Site Title</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter site title"
                    id="site_title"
                    name="site_title"
                    value="{{ $setting::get('site_title') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="default_email_address">Default Email Address</label>
                <input
                    class="form-control"
                    type="email"
                    placeholder="Enter default email address"
                    id="default_email_address"
                    name="default_email_address"
                    value="{{ $setting::get('default_email_address') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="currency_code">Privacy</label>
                <textarea class="form-control" name="Privacy" id="Privacy">{{ $setting::get('Privacy') }}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label" for="currency_symbol">Terms & Conditions</label>
                <textarea class="form-control" name="terms" id="terms">{{ $setting::get('terms') }}</textarea>
            </div>
        </div>
    </form>
</div>