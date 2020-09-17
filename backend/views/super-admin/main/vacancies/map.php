<?php
?>
<div id="map" style="height: 840px;"></div>

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
        var infom = [];
        var markers = locations.map(function (location, i) {
            var mark = new google.maps.Marker({
                position: location.loc,
                icon:location.icon,
                label: labels[i % labels.length]
            });
            var contentString =
                '<div class="block_poly">\n' +
                '<div class="left_block">\n' +
                '<h3>' + location.name + '</h3>\n' +
                '<span>' + location.description + '</span>\n' +
                '</div>\n' +
                '<div class="right_block">\n' +
                '<span class="red salary">' + location.price + '</span>\n' +
                location.review +
                '<a href="'+location.phone+'">' + location.phone + '</a>\n' +
                '</div>\n' +
                '</div>';
            mark.infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            infom.push(mark);
            google.maps.event.addListener(mark, 'mouseover', function (e) {
                this.setOptions({fillOpacity: 0.1});
                mark.infowindow.setPosition(location.loc);
                mark.infowindow.open(map);
            });
            /*
            google.maps.event.addListener(mark, 'mouseout', function (e) {
                 this.setOptions({fillOpacity: 0.35});
                 mark.infowindow.close(map);
             });

             */
            return mark;
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
        {
            loc : {lat: <?= $mark->lat?>, lng: <?= $mark->lot?>},
            icon:'' ,
            name : "<?= $mark->title?>" ,
            phone: "<?=$mark->phone?>",
            description: "<?=$mark->description?>",
            price: "<?= $mark->type =='piecework' ? $type[$mark->type] : $mark->price . ' ' .$mark->currency .' ' . $type[$mark->type]?>",
            review: "<a href=\"/vacancies?info=<?=$mark->id?>\">Подробнее</a>\n"
        },
        <?php }?>
    ]

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBI56UwMrhNrE4_FDt-Ks1lBhk2wBWxbBg&language=ru&libraries=places&libraries=drawing&callback=initMap"></script>

<style>
    .gm-style .gm-style-iw-c {
        padding: 15px 0px 5px 15px !important;
        border-radius: 2px;
        font-family: 'Roboto' !important;
        font-weight: 400;
        border: 2px solid #c00000;
    }

    .gm-style .gm-style-iw-t::after {
        border-color: #c00000;
        border-style: solid;
        border-width: 0px 0px 2px 2px;
        top: -1px;
    }

    .gm-style .gm-style-iw-c h3 {
        font-size: 16px;
        font-weight: 500;
        margin: 0 0 10px;
    }

    .gm-style .gm-style-iw-c .left_block {
        width: 120px;
        float: left;
        margin-right: 20px;
    }

    .gm-style .gm-style-iw-c .right_block {
        width: 120px;
        float: left;
    }

    .gm-style .gm-style-iw-c span,
    .gm-style .gm-style-iw-c a {
        font-size: 14px;
        display: block;
    }

    .gm-style .gm-style-iw-c span.salary {
        font-weight: 500;
        font-size: 16px;
        margin-bottom: 10px;
    }
</style>
