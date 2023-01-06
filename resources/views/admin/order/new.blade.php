@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@php
$restaurants = App\Models\Restaurant::where('status','1')->get();

$order_id = (isset($_GET['order_id']) && $_GET['order_id']!='')?$_GET['order_id']:'';
$name = (isset($_GET['name']) && $_GET['name']!='')?$_GET['name']:'';
$mobile = (isset($_GET['mobile']) && $_GET['mobile']!='')?$_GET['mobile']:'';
$start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'';
$end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'';
$restaurant_id = (isset($_GET['restaurant_id']) && $_GET['restaurant_id']!='')?$_GET['restaurant_id']:'';
$location = \App\Models\DriverLocation::paginate(20);
@endphp
    <style type="text/css">
        .details_badge_item{
            margin-right: 15px;
        }    
    </style>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="details_badge_list d-flex flex-wrap mb-3 mb-lg-3">
        <a href="{{ route('admin.order.index') }}" class="details_badge_item btn btn-primary">All Orders</a>
        <a href="{{ route('admin.order.new') }}" class="details_badge_item btn btn-primary">New Orders</a>
        <a href="{{ route('admin.order.ongoing') }}" class="details_badge_item btn btn-primary">Ongoing Orders</a>
        <a href="{{ route('admin.order.delivered') }}" class="details_badge_item btn btn-primary">Delivered Orders</a>
        <a href="{{ route('admin.order.cancelled') }}" class="details_badge_item btn btn-primary">Cancelled Orders</a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form action="">
                    <table class="table table-hover custom-data-table-style table-striped" id="">
                        <tbody>
                            <tr>
                                
                                <td style="padding: 10px 5px;">
                                    Order Id <br/>
                                    <input type="text" class="form-control" name="order_id" placeholder="Order Id" value="{{$order_id}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    Name <br/>
                                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{$name}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    Mobile No <br/>
                                    <input type="text" class="form-control" name="mobile" placeholder="Mobile No" value="{{$mobile}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    Start Date <br/>
                                    <input type="date" class="form-control" name="start_date" placeholder="Start Date" value="{{$start_date}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    End Date <br/>
                                    <input type="date" class="form-control" name="end_date" placeholder="End Date" value="{{$end_date}}">
                                </td>
                                <td style="padding: 10px 5px;">
                                    Restaurant <br/>
                                    <select class="form-control" name="restaurant_id">
                                        <option value="">Select Restaurant</option>
                                        @foreach($restaurants as $restaurant)
                                        <option value="{{$restaurant->id}}" @if($restaurant_id==$restaurant->id){{"selected"}}@endif>{{$restaurant->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 10px 5px;">
                                    <button class="btn btn-primary" type="submit" id="btnSave"><i class="fa fa-fw fa-lg fa-check-circle"></i>Search</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </form>
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Order No</th>
                                <th>Order Date</th>
                                <th>Time in Order</th>
                                <th>Restaurant</th>
                                <th>Delivery Agent</th>
                                <th>Customer Details</th>
                                <th>Order Amount </th>
                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $key => $order)
                            @php
                            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at);
                            $from = \Carbon\Carbon::now('Asia/Kolkata');
                            $time = $from->toTimeString();
                            $diff_in_minutes = $to->diffInMinutes($time);
                            @endphp
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->unique_id }} <br><a type="button" class="btn btn-primary" data-toggle="modal" data-target="#driver_modal"><small class="d-block">Driver Location</small>
                                    </a></td>
                                    <td>{{ date("d-M-Y h:i a",strtotime($order->created_at))}}</td>
                                    @if($diff_in_minutes<20)
                                    <td><div style="background-color: #00FF00 ; padding: 10px; border: 1px solid green;">{{$diff_in_minutes}} mins</div></td>
                                    @elseif($diff_in_minutes >20 && $diff_in_minutes < 45)
                                    <td><div style="background-color: #FFFF00 ; padding: 10px; border: 1px solid yellow;">{{$diff_in_minutes}} mins</div></td>
                                    @else
                                    <td><div style="background-color: #FF0000 ; padding: 10px; border: 1px solid red;">{{$diff_in_minutes}} mins</div></td>
                                    @endif
                                    <td>{{ $order->restaurant->name }}</td>
                                    <td>
                                        @if($order->delivery_boy_id==0)
                                        <form action="{{ route('admin.order.assignboy') }}" method="POST" role="form" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $order->id }}">
                                            <div class="tile-body">
                                                <div class="form-group">
                                                    
                                                    <select  name="delivery_boy_id">
                                                        <option value="">Select Delievry Boy</option>
                                                        @foreach($boys as $boy)
                                                        <option value="{{$boy->id}}" @if($order->delivery_boy_id==$boy->id){{"selected"}}@endif>{{$boy->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="tile-footer">
                                                <button  type="submit">Update</button>
                                                &nbsp;&nbsp;&nbsp;
                                                
                                            </div>
                                        </form>
                                        @else
                                        Delivery Agent : {{$order->boy->name}}
                                        @endif
                                    </td>
                                    <td>{{ $order->name }}<br>Mobile : <br>{{ $order->mobile }}</td>
                                    <td>Rs. {{ $order->total_amount }}</td>
                                    
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('admin.order.details', $order['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="driver_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Driver Location Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="tile">
                            <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                                
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Name</th>
                                        <th> Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($location as $key=> $data)
                                        <tr>
                                            <td>{{ ($location->firstItem()) + $key }}</td>
                                            <td>{{ $data->driver->name }}</td>
                                            <td>{{ $data->location }}</td>
                                        </tr>
                                    @endforeach            
                                </tbody>
                            </table>
                            {!! $location->appends($_GET)->links() !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="directory-map">
                            <div id="mapShow" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <!-- <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script> -->

    <script src="https://maps.google.com/maps/api/js?key=AIzaSyDegpPMIh4JJgSPtZwE6cfTjXSQiSYOdc4" type="text/javascript"></script>

    <script>
        @php
     $locations = [];
        foreach ($location as $item) {
            $img = "";
            $page_link = "";
           $data = [$item->name, floatval($item->lat), floatval($item->lng), $item->address, $page_link];
            array_push($locations, $data);
        }
        @endphp

        var locations = <?php echo json_encode($locations); ?>;

        if (locations.length > 0) {
            var map = new google.maps.Map(document.getElementById('mapShow'), {
                zoom: 15,
                center: new google.maps.LatLng(locations[0][1], locations[0][2]),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                "styles": [{
                    "featureType": "administrative",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#444444"
                    }]
                }, {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [{
                        "color": "#f2f2f2"
                    }]
                }, {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "lightness": 45
                    }]
                }, {
                    "featureType": "road.highway",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "labels.icon",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [{
                        "color": "#4f595d"
                    }, {
                        "visibility": "on"
                    }]
                }],
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;
            var iconBase = 'https://demo91.co.in/localtales-prelaunch/public/site/images/';

            for (i = 0; i < locations.length; i++) {
                const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    //'<img src="' + locations[i][4] + '" width="">' +

                    '<div class="mapPopContent"><div id="bodyContent"><a href="' + locations[i][4] +
                    '" target="_blank"><h6 id="firstHeading" class="firstHeading mb-2">' + locations[i][0] + '</h6></a>' +
                    '<p>' + locations[i][3] + '</p></div>' +

                    '<a href="' + locations[i][4] + '" target="_blank" class="directionBtn"><i class="fas fa-link"></i></a>' +
                    '</div></div>';

                const infowindow = new google.maps.InfoWindow({
                    content: contentString,
                });

                const marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: iconBase + 'map_icon.png'
                });

                marker.addListener("click", () => {
                    infowindow.open({
                        anchor: marker,
                        map,
                        shouldFocus: false,
                    });
                });
            }
        }
    </script>
  
@endpush