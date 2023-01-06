<div class="tile">
    <form action="{{ route('admin.profile.update') }}" method="POST" role="form" id="formgeneral">
        @csrf
        <h3 class="tile-title">General Settings</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="site_name">Name</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter name"
                    id="name"
                    name="name"
                    value="{{ $profile->name }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="site_title">Email</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Email ID"
                    id="email"
                    name="email"
                    value="{{ $profile->email }}"
                    readonly
                />
            </div>
        </div>
    </form>
</div>