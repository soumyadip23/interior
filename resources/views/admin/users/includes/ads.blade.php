<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <table class="table table-hover custom-data-table-style table-striped" id="sampleTable1">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Package</th>
                        <th>Posted On</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($ads as $k=>$ad)
                        @php $key = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $ad->title)); @endphp
                            <tr>
                                <td>{{ $ad->title }}</td>
                                <td>{{$ad->package_name}}</td>
                                <td>{{ Carbon\Carbon::parse($ad->created_at)->format('m/d/Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($ad->package_expire_date)->format('m/d/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.ads.view', $ad->id) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">$('#sampleTable1').DataTable({"ordering": false});</script>
@endpush