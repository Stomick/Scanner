<?php
$type = [
    'hour' => 'В час',
    'day' => 'В день',
    'month' => 'В месяц',
    'piecework' => 'Договорная'
];
$curr = [
    'RUB' => '₽',
    'EUR' => '€',
    'USD' => '$'
]
?>
<style>
    a:hover,h3{
        text-decoration: none;
    }
</style>
<input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
       value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
<div class="row">
    <?php include 'filter.php' ?>
    <div id="left_menu_container" class="left_menu_container">
        <h2><?= $mtitle ?></h2>
        <span class="load_icon glyphicon glyphicon-refresh"></span>
        <span id="open_close_menu" class="glyphicon glyphicon-tasks open_close_menu"></span>
        <div class="menu_container" id="menu_container">
        </div>
        <div class="preloader">
            <div class="lds-ellipsis">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <script>
        jQuery(function ($) {
            $("#close_menu").click(2000, function () {
                $("#left_menu_container").fadeOut();
            });

            $("#show_menu").click(2000, function () {
                $("#left_menu_container").fadeIn();
            });
        });
    </script>

    <div id="map" style="height: 88vh;"></div>
</div>

<script src="/js/markerplace.js?v=1.02"></script>

<script>

    var lat = 55.7235774;
    var lng = 37.4489189;
    var zoom = 9 ;
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
            $.each($('#specfilter input.catgory'),function (i,item) {
                if(item.checked){
                    $(prof).hide();
                    $(reset_prof).show();
                    $('#select_prof')[0].innerText = $("[for='"+item.id+"']")[0].innerText;
                }
            });
            Getspecialties(lat, lng, zoom);
        });

        $('#specfilter input.pay_inp').change(function () {
            $(document.getElementById('pay_select')).hide();
            $(document.getElementById('pay_reset')).show();
            Getspecialties(lat, lng, zoom);
        });

        $('#pay_reset').on('click',function () {
            $(document.getElementById('pay_select')).show();
            $(document.getElementById('pay_reset')).hide();
            $('#fmin').val($('#pmin').val());
            $('#fmax').val($('#pmax').val());
            $('#curens').find($('option')).attr('selected', false)

            $.each($('#specfilter input.pay_inp'),function (i,item) {
                if(item.checked) {
                    item.checked = false;
                }
            });
            Getspecialties(lat, lng, zoom);
        });

        $('#reset_prof').on('click',function () {
            var reset_prof = document.getElementById('select_prof');
            var prof = document.getElementById('prof');
            reset_prof.innerText = 'Профобласть';
            $(this).hide();
            $(prof).show();
            $.each($('#specfilter input.catgory'),function (i,item) {
                if(item.checked) {
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
            var tmp = Math.sqrt((Math.pow(centr.lat(),2)+Math.pow(centr.lng(),2))) * 100;
            if((tmp - tlatlng) > (20 - zoomLevel) || (tlatlng - tmp) > (20 - zoomLevel)) {
                console.log(tmp,tlatlng);
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
            url: '/img/markers/s/m1.png',
            height: 36,
            width: 25,
            line: 25,
        }
        ];
        var markerCluster = new MarkerClusterer(map, markers,
            {
                imagePath: '/img/markers/m/s',
                styles: clusterStyles,
                maxZoom: 12,
                className : 'jobVacans'
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
        var input = document.getElementById('find_address');

        var autocomplete = new google.maps.places.Autocomplete(input);

        if(autocomplete) {
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }
                var loc = place.geometry.location;
                map.panTo(place.geometry.location);
                Getspecialties(loc.lat(), loc.lng(), zoom);
            });
        }
        function Getspecialties(lat, lng, zoom) {
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
                        console.log(resp.price)
                        $('#fmin').val(resp.price.min);
                        $('#fmax').val(resp.price.max);
                        resp.vac.map(function (vac, i) {

                            var imgBlock = '<div class="slide_img_block">' +
                                    '                        <img class="" src="' + vac.photo + '"/>' +
                                    '                    </div>';

                            var vacStr = '<div class="row" id="vac' + vac.id + '">' +
                                '    <div class="vacansy_block">' +
                                '        <div class="col-md-3 col-xs-12">' +
                                '<a href="/<?=$mtype?>/info/ID' + vac.id + '.html">'+
                                '            <section class="regular_' + vac.id + ' slider">' + imgBlock +
                                '            </section>' +
                                '</a>' +

                                '        </div>' +
                                '<div class="col-md-9 col-xs-12">' +
                                '<a style="color:#333;" href="/<?=$mtype?>/info/ID' + vac.id + '.html">'+
                                ' <h3 class="job_name">'+vac.name+'</h3>' +
                                '</a>' +
                                '<a href="/profile/reviews/' + vac.prof + '.html">'+
                                '<div class="rating">\n' +
                                '<div class="stars">\n' +
                                '<div class="on" style="width: ' + vac.rating +'%;"></div>\n' +
                                '<div class="live">\n' +
                                '<span data-rate="1"></span>\n' +
                                '<span data-rate="2"></span>\n' +
                                '<span data-rate="3"></span>\n' +
                                '<span data-rate="4"></span>\n' +
                                '<span data-rate="5"></span>\n' +
                                '</div>\n' +
                                '</div>\n' +
                                '</div>\n' +
                                '</a>' +
                                '<a href="/<?=$mtype?>/info/ID' + vac.id + '.html">'+
                                '   <h3 class="job_status">' + vac.title + ' </h3>' +
                                '</a>' +
                                '<a href="/<?=$mtype?>/info/ID' + vac.id + '.html">'+
                                '</a>' +
                                '                        <span class="salary">' + vac.price + '</span>'+
                                '<hr>'+
                                '                        </span>' +
                                '<span style="float:left; font-size: 14px;">' + vac.send + '</span>'+
                                '            <a style="float: right; margin-top: 5px; display: block;" href="tel:' + vac.phone + '">' + vac.phone + '</a>' +
                                '        </div>' +
                                '    </div>' +
                                '</div>';

                            var v = document.getElementById('vac' + vac.id);
                            if (v==null) {

                                $('#menu_container').append(vacStr);
                                var mark = new google.maps.Marker({
                                    position: {lat: parseFloat(vac.lat), lng: parseFloat(vac.lot)},
                                    icon: {url:vac.marker,scaledSize: vac.size},
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
                                            '<a href="/<?=$mtype?>/info/ID' + vac.id + '.html">'+
                                                '<img class="map_avatar" src="'+vac.photo+'" alt="logo"/>\n' +
                                            '</a>' +
                                        '</div>\n' +
                                        '<div class="right_block">\n' +
                                            '<a style="color:#333;" href="/<?=$mtype?>/info/ID' + vac.id + '.html">'+
                                                '<h3 class="map_name">'+vac.name+'</h3>\n' +
                                                '</a>' +
                                                '<a href="/<?=$mtype?>/info/' + vac.prof + '.html">'+
                                                '<div class="rating">\n' +
                                                '<div class="stars">\n' +
                                                '<div class="on" style="width: ' + vac.rating +'%;"></div>\n' +
                                                '<div class="live">\n' +
                                                '<span data-rate="1"></span>\n' +
                                                '<span data-rate="2"></span>\n' +
                                                '<span data-rate="3"></span>\n' +
                                                '<span data-rate="4"></span>\n' +
                                                '<span data-rate="5"></span>\n' +
                                                '</div>\n' +
                                                '</div>\n' +
                                                '</div>\n' +
                                                '</a>' +
                                            '<a style="color:#333;" href="/profile/reviews/ID' + vac.id + '.html">'+
                                                '<h3>' + vac.title + '</h3>\n' +
                                            '</a>' +
                                    '<span class="vac_price">' + vac.price + '</span>\n' +
                                            //'<span>' + vac.description + '</span>\n' +

                                    '<span class="offer_job">' + vac.send + '</span>\n' +
                                    '<a class="job_tell" href="tel:' + vac.phone + '">' + vac.phone + '</a>\n' +

                                            // vac.review +
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
                        $.each($('#menu_container .row'), function (i,item) {
                            if (!resp.id.includes(item.id)) {
                                 item.remove();
                            };
                        })
                        console.log(markers)
                        markers.map(function (m) {
                            if (!resp.id.includes('vac' + m.id)) {
                                console.log(m.id)
                                  markerCluster.removeMarker(m);
                            };
                        })
                    } else {
                        $.each($('#menu_container .row'), function (i,item) {
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBI56UwMrhNrE4_FDt-Ks1lBhk2wBWxbBg&language=ru&libraries=drawing&libraries=places&callback=initMap"></script>

<style>

    .gm-style button {
        top: 0 !important;
        right: 0 !important;
    }

    .gm-style .rating {
        margin: 0 0 15px;
        overflow: hidden;
    }

    .gm-style .vac_price {
        color: #3D2B3B;
        border-bottom: 1px solid #D1C4C4;
        padding-bottom: 10px;
        font-weight: 500;
    }

    .gm-style .gm-style-iw-c h3.map_name {
        text-align: left;
        margin: 0 0 5px;
        display: block;
    }

    .map_avatar {
        width: 70px;
        margin: 0 auto 10px;
        display: block;
        border-radius: 50%;
    }

    .gm-style .gm-style-iw-c {
        padding: 15px !important;
        border-radius: 0px;
        font-family: 'Roboto' !important;
        font-weight: 400;
        border: none;
    }

    .gm-style .gm-style-iw-t::after {
        border-color: #fff;
        border-style: none;
        border-width: 0px 0px 0px 5px;
        top: -1px;
        height: 20px;
        width: 20px;
    }

    .gm-style .gm-style-iw-c h3 {
        font-size: 16px;
        font-weight: 500;
        margin: 0 0 10px;
    }

    .gm-style .gm-style-iw-c .left_block {
        width: 70px;
        float: left;
        margin-right: 20px;
    }

    .gm-style .gm-style-iw-c .right_block {
        width: 260px;
        float: left;
    }

    .gm-style .offer_job {
        margin-top: 5px;
        float: left;
        display: inline-block;
    }

    .gm-style .job_tell {
        float: right;
        display: inline-block;
        margin-top: 10px;
    }

    .gm-style .gm-style-iw-c span,
    .gm-style .gm-style-iw-c a {
        font-size: 14px;
        display: block;
        overflow: hidden;
    }

    .gm-style .gm-style-iw-c span.salary {
        font-weight: 500;
        font-size: 16px;
        margin-bottom: 0px;
        text-align: center;
    }

    <?php if(\Yii::$app->mobileDetect->isDesktop){?>
    <?php }elseif (\Yii::$app->mobileDetect->isTablet){?>
    div[title] img {
        width: auto !important;
        height: 24px !important;
    }
    div[title] {
        overflow: hidden !important;
        opacity: 0 !important;
    }
    <?php } else{?>
    div[title] {
        overflow: hidden !important;
        opacity: 0 !important;
    }
    div[title] img {
        width: auto !important;
        height: 24px !important;
    }
    div[title] {
        overflow: hidden !important;
        opacity: 0 !important;
    }
    <?php }?>

    .jobVacans {
        height: 53px !important;
        width: 39px !important;
        line-height: 42px !important;
        font-family: Roboto !important;
        background-size: cover !important;
        -webkit-transition: background-image 0.2s ease-in-out;
        transition: background-image 0.2s ease-in-out;
    }

    .jobVacans:hover {
        background-image: url(/img/markers/s/m1-hover.png) !important;
    }
    .pac-logo:after{
        display: none !important;
    }
</style>