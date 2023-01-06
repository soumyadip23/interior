@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')


    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    @include('admin.partials.flash')
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
@endsection
@push('scripts')
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