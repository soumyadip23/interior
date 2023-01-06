<div class="tile">
    <form action="{{ route('admin.profile.changepassword') }}" method="POST" role="form" id="formpassword">
        @csrf
        <h3 class="tile-title">Change Password</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="site_name">Current Password</label>
                <input
                    class="form-control"
                    type="password"
                    placeholder="Enter current password"
                    id="current_password"
                    name="current_password"
                    value=""
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="site_title">New Password</label>
                <input
                    class="form-control"
                    type="password"
                    placeholder="Enter new password"
                    id="new_password"
                    name="new_password"
                    value=""
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="site_title">Confirm Password</label>
                <input
                    class="form-control"
                    type="password"
                    placeholder="Enter confirm password"
                    id="new_confirm_password"
                    name="new_confirm_password"
                    value=""
                />
            </div>
        </div>
        <!-- <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Password</button>
                </div>
            </div>
        </div> -->
    </form>
</div>