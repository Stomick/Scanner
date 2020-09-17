<?php
?>
<div id="main">

    <ol class="breadcrumb">
        <li><a href="#">Главная</a></li>
    </ol>
    <!-- //breadcrumb-->

    <div id="content">
        <?php
        $type = [
            'hour' => 'В час',
            'day' => 'В день',
            'month' => 'В месяц',
            'piecework' => 'Договорная'
        ];
        ?>

        <div class="row">
            <div id="map" style="height: 840px;"></div>
        </div>

        <script src="/js/markerplace.js"></script>

        <script>
            var lat = 55.7235774;
            var lng = 37.4489189;
            function initMap() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                }
                var settings = {
                    zoom: 8,
                    center: {lat: lat, lng: lng},
                    zoomControl: true,
                    disableDefaultUI: true,
                    scrollwheel: false,
                    mapTypeControl: false,
                    navigationControl: false,
                    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    zoomControlOptions: {
                        position: google.maps.ControlPosition.TOP_RIGHT,
                    },
                    streetViewControlOptions: {
                        position: google.maps.ControlPosition.TOP_RIGHT
                    },
                    // styles: [
                    //     {
                    //         "featureType": "administrative",
                    //         "elementType": "all",
                    //         "stylers": [
                    //             {
                    //                 "saturation": "-100"
                    //             }
                    //         ]
                    //     },
                    //     {
                    //         "featureType": "administrative.province",
                    //         "elementType": "all",
                    //         "stylers": [
                    //             {
                    //                 "visibility": "off"
                    //             }
                    //         ]
                    //     },
                    //     {
                    //         "featureType": "landscape",
                    //         "elementType": "all",
                    //         "stylers": [
                    //             {
                    //                 "saturation": -100
                    //             },
                    //             {
                    //                 "lightness": 65
                    //             },
                    //             {
                    //                 "visibility": "on"
                    //             }
                    //         ]
                    //     },
                    //     {
                    //         "featureType": "poi",
                    //         "elementType": "all",
                    //         "stylers": [
                    //             {
                    //                 "saturation": -100
                    //             },
                    //             {
                    //                 "lightness": "50"
                    //             },
                    //             {
                    //                 "visibility": "simplified"
                    //             }
                    //         ]
                    //     },
                    //     {
                    //         "featureType": "road",
                    //         "elementType": "all",
                    //         "stylers": [
                    //             {
                    //                 "saturation": "-100"
                    //             }
                    //         ]
                    //     },
                    //     {
                    //         "featureType": "road.highway",
                    //         "elementType": "all",
                    //         "stylers": [
                    //             {
                    //                 "visibility": "simplified"
                    //             }
                    //         ]
                    //     },
                    //     {
                    //         "featureType": "road.arterial",
                    //         "elementType": "all",
                    //         "stylers": [
                    //             {
                    //                 "lightness": "30"
                    //             }
                    //         ]
                    //     },
                    //     {
                    //         "featureType": "road.local",
                    //         "elementType": "all",
                    //         "stylers": [
                    //             {
                    //                 "lightness": "40"
                    //             }
                    //         ]
                    //     },
                    //     {
                    //         "featureType": "transit",
                    //         "elementType": "all",
                    //         "stylers": [
                    //             {
                    //                 "saturation": -100
                    //             },
                    //             {
                    //                 "visibility": "simplified"
                    //             }
                    //         ]
                    //     },
                    //     {
                    //         "featureType": "water",
                    //         "elementType": "geometry",
                    //         "stylers": [
                    //             {
                    //                 "hue": "#ffff00"
                    //             },
                    //             {
                    //                 "lightness": -25
                    //             },
                    //             {
                    //                 "saturation": -97
                    //             }
                    //         ]
                    //     },
                    //     {
                    //         "featureType": "water",
                    //         "elementType": "labels",
                    //         "stylers": [
                    //             {
                    //                 "lightness": -25
                    //             },
                    //             {
                    //                 "saturation": -100
                    //             }
                    //         ]
                    //     }
                    // ]
                    //------------конец --------------
                };
                var map = new google.maps.Map(document.getElementById('map'), settings);
                var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                function showPosition(position) {
                    lat = position.coords.latitude;
                    lng = position.coords.longitude;
                    map.setCenter(new google.maps.LatLng(lat, lng))
                }
                // Add some markers to the map.
                // Note: The code uses the JavaScript Array.prototype.map() method to
                // create an array of markers based on a given "locations" array.
                // The map() method here has nothing to do with the Google Maps API.
                var markers = locations.map(function (location, i) {
                    return new google.maps.Marker({
                        position: location.loc,
                        icon:location.icon,
                        label: labels[i % labels.length]
                    });
                });

                // Add a marker clusterer to manage the markers.
                var markerCluster = new MarkerClusterer(map, markers,
                    {imagePath: '/img/markers/m'});

                // Add some markers to the map.
                // Note: The code uses the JavaScript Array.prototype.map() method to
                // create an array of markers based on a given "locations" array.
                // The map() method here has nothing to do with the Google Maps API.
            }

            var locations = [
                <?php foreach ($markers as $mark){ ?>
                {loc : {lat: <?= $mark->lat?>, lng: <?= $mark->lot?>}, icon:''},
                <?php }?>
            ]

        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBI56UwMrhNrE4_FDt-Ks1lBhk2wBWxbBg&language=ru&libraries=places&libraries=drawing&callback=initMap"></script>
    </div>
</div>
