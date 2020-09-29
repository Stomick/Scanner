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
    a:hover {
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

<script src="/js/markerplace.js?v=1.03"></script>

<script defer>
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
            Getspecialties(lat, lng, zoom);
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
        var input = document.getElementById('find_address');

        var autocomplete = new google.maps.places.Autocomplete(input);

        if (autocomplete) {
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
            console.log(lat, lng)
            var token = $('input[name="_csrf"]').val();
            $(".preloader, .load_icon").addClass('display_block');
            $.ajax({
                url: '/vacancies/list.html',
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
                            <?php if(\Yii::$app->mobileDetect->isDesktop){?>
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
                                '        </div>' +
                                '    </div>' +
                                '</div>';
                            <?php }
                            //Код дл моб верстки в меню
                            else {?>
                            var vacStr = '<div class="row" id="vac' + vac.id + '">' +
                                '    <div class="vacansy_block">' +
                                '        <div class="col-xs-4">' +
                                '            <a href="/profile/info/' + vac.prof + '.html">' +
                                '               <section class="regular_' + vac.id + ' slider">' + imgBlock +
                                '               </section>' +
                                '           </a>' +
                                '        </div>' +
                                '<div class="col-xs-8">' +
                                '<div class="job_status">' + vac.vstat + '</div>' +
                                '            <a style="color:#3D2B3B;;" href="/<?=$mtype?>/info/ID' + vac.id + '.html">' +
                                '               <h3 class="job_status" style="text-decoration:none">' + vac.title + ' </h3>' +
                                '           </a>' +
                                '                        <span style="font-size: 16px; font-weight: 500;" class="salary">' + vac.price + '</span>' +
                                '<a style="color:#333;" href="/<?=$mtype?>/info/ID' + vac.id + '.html">' +
                                '</div>' +
                                '<div class="col-xs-12">' +
                                '       <span class="information">' + vac.description + '</span>' +
                                '</a>' +
                                '<hr>' +
                                '<span style="float: left; font-size: 14px;">' + vac.send + '</span>' +
                                '        </div>' +
                                '    </div>' +
                                '</div>';

                            <?php }?>
                            var v = document.getElementById('vac' + vac.id);
                            if (v == null) {
                                $('#menu_container').append(vacStr);
                                var mark = new google.maps.Marker({
                                    position: {lat: parseFloat(vac.lat), lng: parseFloat(vac.lot)},
                                    icon: {url: vac.marker, scaledSize: vac.size},
                                    id: vac.id,
                                });
                                markers.push(mark);
                                $(".regular_" + vac.id).slick({
                                    dots: false,
                                    infinite: true,
                                    slidesToShow: 1,
                                    slidesToScroll: 1
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBI56UwMrhNrE4_FDt-Ks1lBhk2wBWxbBg&language=ru&libraries=drawing&libraries=places&callback=initMap"></script>

<style>

    .map_avatar {
        width: 70px;
        margin: 0 auto 10px;
        display: block;
        border-radius: 50%;
    }

    .gm-style button {
        top: 0 !important;
        right: 0 !important;
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
        margin: 15px 0 10px;
    }

    .gm-style .gm-style-iw-c .left_block {
        width: 70px;
        float: left;
        margin-right: 20px;
    }

    .gm-style .gm-style-iw-c .right_block {
        width: 240px;
        float: left;
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
        margin-bottom: 10px;
        color: #3D2B3B;
    }

    .gm-style .gm-style-iw-c .vac_respond,
    .gm-style .gm-style-iw-c .vac_tell {
        display: inline-block;
    }

    .gm-style .gm-style-iw-c .vac_respond:hover,
    .gm-style .gm-style-iw-c .vac_tell:hover {
        color: #0041EB;
    }

    .gm-style .gm-style-iw-c .vac_respond {
        float: left;
        margin-top: 5px;
    }

    .gm-style .gm-style-iw-c .vac_tell {
        float: right;
        margin-top: 10px;
    }


    .gm-style .gm-style-iw-c .vac_descr {
        color: #816A7E;
        border-bottom: 1px solid #D1C4C4;
        padding-bottom: 10px;
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
    div[title] img {
        width: auto !important;
        height: 24px !important;
    }

    div[title] {
        overflow: hidden !important;
        opacity: 0 !important;
    }

    <?php }?>

    .jobWorker {
        height: 53px !important;
        width: 39px !important;
        line-height: 42px !important;
        font-family: Roboto !important;
        background-size: cover !important;
        -webkit-transition: background-image 0.2s ease-in-out;
        transition: background-image 0.2s ease-in-out;
    }

    .jobWorker:hover {
        background-image: url(/img/markers/v/m1-hover.png) !important;
    }

    .pac-logo:after {
        display: none !important;
    }
</style>