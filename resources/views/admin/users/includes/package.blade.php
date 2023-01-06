<div class="tile">
    <form action="" method="POST" role="form">
        <h3 class="tile-title">{{$username}}</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="site_name">Package Name</label>
                <input
                    class="form-control"
                    type="text"
                    id="site_name"
                    name="site_name"
                    value="{{ empty($userdetails->package->name)? null:$userdetails->package->name }}"
                    readonly
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="site_title">Expiry Date</label>
                <input
                    class="form-control"
                    type="text"
                    id="site_title"
                    name="site_title"
                    value="{{ empty($userdetails->getPackageExpiryDate())? null:($userdetails->getPackageExpiryDate()) }}"
                    readonly
                />
            </div>
        </div>
    </form>
</div>