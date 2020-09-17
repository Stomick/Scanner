<?php
?>

<script>
    var lat = 55.7235774;
    var lng = 37.4489189;
    var zoom = 9;

    function initMap() {
        var tlatlng = 0;
        <?php if($cord != null){
        $c = explode(',', $cord);
        ?>
        lat = <?=$c[0]?>;
        lng = <?=$c[1]?>;
        zoom = 12;
        Getspecialties(lat, lng, zoom);
        <?php } else {?>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
            // Getspecialties(lat, lng, zoom);
        }
        <?php }?>

        $('#specfilter input.catgory').change(function () {
            $('#select_prof')[0].innerText = 'Профобласть';
            var reset_prof = document.getElementById('reset_prof');
            var prof = document.getElementById('prof');
            $.each($('#specfilter input.catgory'), function (i, item) {
                if (item.checked) {
                    $(prof).hide();
                    $(reset_prof).show();
                    $('#select_prof')[0].innerText = $("[for='" + item.id + "']")[0].innerText;
                }
            });
            Getspecialties(lat, lng, zoom);
        });

        $('#specfilter input.pay_inp').change(function () {
            $(document.getElementById('pay_select')).hide();
            $(document.getElementById('pay_reset')).show();
            Getspecialties(lat, lng, zoom);
        });

        $('#pay_reset').on('click', function () {
            $(document.getElementById('pay_select')).show();
            $(document.getElementById('pay_reset')).hide();
            $('#fmin').val($('#pmin').val());
            $('#fmax').val($('#pmax').val());
            $('#curens').find($('option')).attr('selected', false)

            $.each($('#specfilter input.pay_inp'), function (i, item) {
                if (item.checked) {
                    item.checked = false;
                }
            });
            Getspecialties(lat, lng, zoom);
        });

        $('#reset_prof').on('click', function () {
            var reset_prof = document.getElementById('select_prof');
            var prof = document.getElementById('prof');
            reset_prof.innerText = 'Профобласть';
            $(this).hide();
            $(prof).show();
            $.each($('#specfilter input.catgory'), function (i, item) {
                if (item.checked) {
                    item.checked = false;
                }
            });
            $('#fmin').val($('#pmin').val());
            $('#fmax').val($('#pmax').val());
            $('#curens').find($('option')).attr('selected', false)

            Getspecialties(lat, lng, zoom);
        });

        $('#find_address').on('keyup', function () {
            if (this.value.length > 3) {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({"address": this.value}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var loc = results[0].geometry.location;
                        map.setCenter(results[0].geometry.location);
                        setTimeout(Getspecialties(loc.lat(), loc.lng(), zoom),2000);
                    }
                });
            }
        })
        var settings = {
            zoom: zoom,
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
            }, styles: [

                {
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                }

            ]
        };
        var map = new google.maps.Map(document.getElementById('map'), settings);
        google.maps.event.addListener(map, 'center_changed', function () {
            var zoomLevel = map.getZoom();
            var centr = map.getCenter();
            var tmp = Math.sqrt((Math.pow(centr.lat(), 2) + Math.pow(centr.lng(), 2))) * 100;
            if ((tmp - tlatlng) > (20 - zoomLevel) || (tlatlng - tmp) > (20 - zoomLevel)) {

                tlatlng = tmp;
                lat = centr.lat;
                lng = centr.lng;
                zoom = zoomLevel;
                Getspecialties(centr.lat, centr.lng, zoomLevel);
            }
        });

        var markers = [];
        var clusterStyles = [{
            textColor: 'black',
            url: '/img/markers/v/m1.png',
            height: 36,
            width: 25,
            line: 25,
        }
        ];
        var markerCluster = new MarkerClusterer(map, markers,
            {
                imagePath: '/img/markers/m/v',
                styles: clusterStyles,
                maxZoom: 12,
                className: 'jobWorker'
            });

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

        function Getspecialties(lat, lng, zoom) {
            console.log(lat,lng)
            var token = $('input[name="_csrf"]').val();
            $(".preloader, .load_icon").addClass('display_block');
            $.ajax({
                url: '/<?=$mtype?>/list.html',
                type: 'post',
                dataType: "json",
                data: {_csrf: token, lat: lat, lng: lng, z: zoom, f: $('#specfilter').serializeArray()},
                success: function (resp) {
                    if (resp.id.length > 0) {
                        $(".preloader").addClass('display_block');
                        $(".load_icon").addClass('display_block');

                        $('#fmin').val(resp.price.min);
                        $('#fmax').val(resp.price.max);
                        resp.vac.map(function (vac, i) {

                            var imgBlock = '';
                            vac.photos.map(function (url) {
                                imgBlock += '<div class="slide_img_block">' +
                                    '                        <img class="" src="' + url.url + '"/>' +
                                    '                    </div>';
                            });

                            var vacStr = '<div class="row" id="vac' + vac.id + '">' +
                                '    <div class="vacansy_block">' +
                                '        <div class="col-md-3 col-xs-12">' +
                                '            <a href="/profile/info/' + vac.prof + '.html">' +
                                '               <section class="regular_' + vac.id + ' slider">' + imgBlock +
                                '               </section>' +
                                '           </a>' +
                                '        </div>' +
                                '<div class="col-md-9 col-xs-12">' +
                                '<div class="job_status">' + vac.vstat + '</div>' +
                                '            <a style="color:#333;" href="/<?=$mtype?>/info/ID' + vac.id + '.html">' +
                                '               <h3 class="job_status" style="text-decoration:none">' + vac.title + ' </h3>' +
                                '           </a>' +
                                '                        <span style="font-size: 14px;" class="salary">' + vac.price + '</span>' +
                                '<a style="color:#333;" href="/<?=$mtype?>/info/ID' + vac.id + '.html">' +
                                '       <span class="information">' + vac.description + '</span>' +
                                '</a>' +
                                '<hr>' +
                                '<span style="float: left; font-size: 14px;">' + vac.send + '</span>' +
                                '<a style="float: right; font-size: 14px; margin-top: 5px; display: block;" href="tel:' + vac.phone + '">' + vac.phone + '</a>' +
                                '        </div>' +
                                '    </div>' +
                                '</div>';

                            var v = document.getElementById('vac' + vac.id);
                            if (v == null) {

                                $('#menu_container').append(vacStr);
                                var mark = new google.maps.Marker({
                                    position: {lat: parseFloat(vac.lat), lng: parseFloat(vac.lot)},
                                    icon: vac.marker,
                                    id: vac.id
                                });
                                markers.push(mark);
                                $(".regular_" + vac.id).slick({
                                    dots: false,
                                    infinite: true,
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                });
                                var contentString =
                                    '<div class="block_poly">\n' +
                                    '<div class="left_block">\n' +
                                    '<a style="color:#333;" href="/<?=$mtype?>/info/ID' + vac.id + '.html">' +
                                    '<img class="map_avatar" src="' + vac.logo + '" alt="logo"/>\n' +
                                    '</a>' +
                                    '</div>\n' +
                                    '<div class="right_block">\n' +
                                    '<a style="color:#333;" href="/<?=$mtype?>/info/ID' + vac.id + '.html">' +
                                    '<h3>' + vac.title + '</h3>\n' +
                                    '</a>' +
                                    '<span class="salary">' + vac.price + '</span>\n' +
                                    '<a class="vac_descr" href="/<?=$mtype?>/info/ID' + vac.id + '.html">' +
                                    '<span>' + vac.description + '</span>\n' +
                                    '</a>' +


                                    // vac.review +
                                    '<span class="vac_respond">' + vac.send + '</span>\n' +
                                    '<a class="vac_tell" href="tel:' + vac.phone + '">' + vac.phone + '</a>\n' +
                                    //'<a href="/<?=$mtype?>/info/ID' + vac.id + '.html">Подробнее</a>' +
                                    '</div>\n' +
                                    '</div>';
                                var infowindow = new google.maps.InfoWindow({
                                    content: contentString
                                });
                                infom.push(infowindow);
                                mark.addListener('click', function (e) {
                                    this.setOptions({fillOpacity: 0.1});
                                    infom.map(function (wind) {
                                        wind.close();
                                    })
                                    var containerScr = $('.menu_container');
                                    var block = $('#vac' + vac.id + ' .vacansy_block');
                                    $(".left_menu_container").addClass("max_height");
                                    var scrollTo = $(block);
                                    containerScr.animate({
                                        scrollTop: scrollTo.offset().top - containerScr.offset().top + containerScr.scrollTop() - 135
                                    }, 700);
                                    $('.vacansy_block').removeClass('active_block');
                                    $(block).addClass('active_block');
                                    //mark.infowindow.setPosition({lat:location.loc.lat + 0.0003 , lng:location.loc.lng});
                                    infowindow.open(map, mark);
                                });
                                markerCluster.addMarker(mark);
                            }
                        });
                        $.each($('#menu_container .row'), function (i, item) {
                            if (!resp.id.includes(item.id)) {
                                item.remove();
                            }
                        })
                        markers.map(function (m) {
                            if (!resp.id.includes('vac' + m.id)) {

                                markerCluster.removeMarker(m);
                            }
                        })
                    } else {
                        $.each($('#menu_container .row'), function (i, item) {
                            this.remove();
                        })
                        markerCluster.clearMarkers();
                    }
                    setTimeout(function () {
                        $(".preloader, .load_icon").removeClass('display_block');
                    }, resp.id.length * 250);
                }
            });
        }
    }


</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBI56UwMrhNrE4_FDt-Ks1lBhk2wBWxbBg&language=ru&libraries=places&libraries=drawing&callback=initMap"></script>

