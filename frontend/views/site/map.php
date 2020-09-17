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
<input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
       value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
<div class="row">
    <form id="specfilter">
        <div id="cssmenu">
            <ul>
                <li class="active"><p>Категория</p>
                    <ul>
                        <?php foreach (\models\Categories::findAll(['status' => 1, 'sub_id' => 0]) as $cat) { ?>
                            <li>
                                <?php if ($sub = \models\Categories::find()->where(['status' => 1, 'sub_id' => $cat->category_id])->all()) { ?>
                                    <p><?= $cat->name ?></p>
                                    <ul>
                                        <?php foreach ($sub as $k => $sb) {?>
                                        <li>
                                            <p>
                                                <input type="radio" id="cat_<?= $sb->category_id ?>"
                                                       value="<?= $sb->category_id ?>" name="speccat">
                                                <label class="cat_1"
                                                       for="cat_<?= $sb->category_id ?>"><?= $sb->name ?></label>
                                            </p>
                                        </li>
                                        <?php }?>
                                    </ul>
                                <?php } else { ?>
                                    <p>
                                        <input type="radio" id="cat_<?= $cat->category_id ?>"
                                               value="<?= $cat->category_id ?>" name="speccat">
                                        <label class="cat_1"
                                               for="cat_<?= $cat->category_id ?>"><?= $cat->name ?></label>
                                    </p>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </li>

                <li><p>Оплата</p>
                    <ul>
                        <li>
                            <p>
                                От <label>
                                    <input name="price[min]" type="number" id="fmin" class="input_from" value="<?= $price['min'] ?>"/>
                                </label>
                                <input type="hidden" id="pmin" value="<?= $price['min'] ?>">
                                до <label>
                                    <input name="price[max]" type="number" id="fmax" class="input_to" value="<?= $price['max'] ?>"/>
                                </label>
                                <input type="hidden" id="pmax" value="<?= $price['max'] ?>"
                            </p>
                        </li>
                        <li>
                            <p>
                                Валюта:
                                <label for=""></label><select name="speccur" id="curens">
                                    <option value="">Все</option>
                                    <option value="RUB">РУБ</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                </select>
                            </p>
                        </li>
                        <li>
                            <p>
                                <input type="radio" id="cat_2_1" value="hour" name="speccurtype">
                                <label class="cat_1" for="cat_2_1">В час</label>
                            </p>
                        </li>
                        <li>
                            <p>
                                <input type="radio" id="cat_2_2" value="day" name="speccurtype">
                                <label class="cat_1" for="cat_2_2">В день</label>
                            </p>
                        </li>
                        <li>
                            <p>
                                <input type="radio" id="cat_2_3" value="month" name="speccurtype">
                                <label class="cat_1" for="cat_2_3">В месяц</label>
                            </p>
                        </li>
                        <li>
                            <p>
                                <input type="radio" id="cat_2_4" value="piecework" name="speccurtype">
                                <label class="cat_1" for="cat_2_4">Договорная</label>
                            </p>
                        </li>
                    </ul>
                </li>
                <li><p id="ClearFilter">Сбросить</p></li>
                <!--
                                <li><p>Режим работы</p>
                                    <ul>
                                        <li>
                                            <p>
                                                <input type="radio" id="cat_3_1" name="spectype">
                                                <label class="cat_1" for="cat_3_1">Постоянная</label>
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <input type="radio" id="cat_3_2" name="spectype">
                                                <label class="cat_1" for="cat_3_2">Сдельно</label>
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <input type="radio" id="cat_3_3" name="spectype">
                                                <label class="cat_1" for="cat_3_3">На
                                                    <input class="days_count" type="number"> дней
                                                </label>
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <input type="radio" id="cat_3_4" name="spectype">
                                                <label class="cat_1" for="cat_3_4">Сезонная</label>
                                            </p>
                                        </li>
                                    </ul>
                                </li>
                                -->
            </ul>
        </div>
    </form>
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

    <div id="map" style="height: 840px;"></div>
</div>

<script src="/js/markerplace.js"></script>

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
        $('#specfilter input').change(function () {
            Getspecialties(lat, lng, zoom);
        });
        $('#ClearFilter').on('click' , function (){
            $.each($('#specfilter input'),function (i,item) {
                $(item).prop( "checked", false )
            });
            $('#fmin').val($('#pmin').val());
            $('#fmax').val($('#pmax').val());
            $('#curens').find($('option')).attr('selected',false)
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
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: '/img/markers/m'});

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

                            var imgBlock = '';
                            vac.photos.map(function (url) {
                                imgBlock += '<div class="slide_img_block">' +
                                    '                        <img class="" src="' + url.url + '"/>' +
                                    '                    </div>';
                            });

                            var vacStr = '<div class="row" id="vac' + vac.id + '">' +
                                '    <div class="vacansy_block">' +
                                '        <div class="col-md-4 col-xs-12">' +
                                '            <section class="regular_' + vac.id + ' slider">' + imgBlock +
                                '            </section>' +
                                '        </div>' +
                                '<div class="col-md-4 col-xs-12">' +
                                ' <h3 class="job_status">' + vac.title + ' </h3>' +
                                ' <span class="information">' + vac.description + '</span>' +
                                '        </div>' +
                                '        <div class="col-md-4 col-xs-12">' +
                                '                        <span class="red salary">' +
                                vac.price +
                                '                        </span>' +
                                '            <br>' +
                                '            <a href="tel:' + vac.phone + '">' + vac.phone + '</a>' +
                                '            <br>' +
                                '            <a href="/<?=$mtype?>/info/ID' + vac.id + '.html">Подробнее</a>' +
                                '        </div>' +
                                '    </div>' +
                                '</div>';

                            var v = document.getElementById('vac' + vac.id);
                            if (v==null) {

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
                                    '<h3>' + vac.title + '</h3>\n' +
                                    '<span>' + vac.description + '</span>\n' +
                                    '</div>\n' +
                                    '<div class="right_block">\n' +
                                    '<span class="red salary">' + vac.price + '</span>\n' +
                                    // vac.review +
                                    '<a href="' + vac.phone + '">' + vac.phone + '</a>\n' +
                                    '<a href="/<?=$mtype?>/info/ID' + vac.id + '.html">Подробнее</a>' +
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

    div[title] img{
        width: auto !important;
        /*height: 24px !important;*/
    }
</style>