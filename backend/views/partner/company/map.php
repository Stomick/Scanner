<?php

$point = [];
/*
foreach (\frontend\models\CSilePoint::find()->all() as $k => $v) {
    $point[$v->sp_id] = $v->name;
}

$js = '';
foreach (\frontend\models\CSilePoint::find()->all() as $k => $v) {
    if ($v->lat && $v->lot) {
//function codeAddress(address , lat , lot, decrip ,name) {
        $js .= "setTimeout( function () {
            codeAddress('" . $v->address . "'  ,
             " . $v->lat . " ,
             " . $v->lot . " ,
             '" . $v->description . "' ,
             '" . $v->name . "' ,
             '" . $v->sp_id . "' ,
             '" . $v->metro . "' )}, " . $k . " * 500);";
    }
}
$this->registerJs($js);

$jsPoly = '';
foreach (\frontend\models\CSilePoint::find()->all() as $k => $v) {
    //function drawPoligon(name , arrCoord )
    $jsPoly .= 'var name' . $k . '="' . $v->name . '";
     var arrPoint' . $k . '=[';
    foreach (\frontend\models\Poligons::find()->where(['point_id' => $v->sp_id])->all() as $s => $p) {
        $jsPoly .= '{lat: '.$p->lat.', lng: '.$p->lot.'},';
    }
    $jsPoly .= '] ; setTimeout( function () { drawPoligon(name' . $k .', arrPoint' .$k. ')}, " . $k . " * 500);';
}
$this->registerJs($jsPoly);
*/
?>

<div class="container">
    <div class="row">
        <div id="pac-container" class="col-md-9">
            <input style="width: 100% " id="address-input" autocomplete="false" type="text" placeholder="Введите адрес филиала"/>
        </div>
        <button type="button" onclick="addFilial()" class="btn btn-primary">Добавить филиал</button>
        <br/>
        <label class="control-label">Адреса филиалов</label>
        <div id="copy" hidden class="row col-md-9">
            <div class="hidden"><input type="text" name="Affiliates[affiliate_id][]" value="0" class="form-control"
                                       required placeholder="Адрес"/></div>
            <div class="col-md-2">
                <div class="checkbox"><label><input name="Affiliates[main][]" type="radio" value="">Основной</label>
                </div>
            </div>
            <div class="col-md-3"><span class="span-address"></span><input type="text"  name="Affiliates[address][]" value=""
                                         class="form-control hidden form-address" required placeholder="Адрес"/></div>
            <div class="col-md-3"><input type="text" name="Affiliates[email][]" value="" class="form-control" required
                                         placeholder="Email"/></div>
            <div class="col-md-3"><input type="text" name="Affiliates[phone][]" value="" class="form-control" required
                                         placeholder="Телефон"/></div>
            <div class="hidden"><input type="text" name="Affiliates[lat][]" value="0" class="form-control form-lat"
                                       required placeholder="required"/></div>
            <div class="hidden"><input type="text" name="Affiliates[lot][]" value="0" class="form-control form-lot"
                                       required placeholder="required"/></div>
            <div class="col-md-1">
                <div class="checkbox">
                    <label>
                        <input name="Affiliates[delete][]" type="checkbox" value="">
                        Удалить</label>
                </div>
            </div>
        </div>
        <form id="formFillials" method="post" class="form-horizontal" data-collabel="3" data-alignlabel="right"
              data-parsley-validate>
            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                   value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
            <div class="form-group" id="tocopy">
                <?php foreach (\models\Affiliates::findAll(['company_id' => $company->company_id]) as $k => $affiliates) { ?>
                    <div class="row col-md-9">
                        <div class="hidden"><input type="text" name="Affiliates[affiliate_id][]"
                                                   value="<?= $affiliates->affiliate_id ?>" class="form-control"
                                                   required placeholder="Адрес"/></div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <label>
                                    <input name="Affiliates[main][]" type="radio"
                                           <?= $affiliates->main ? 'checked="checked"' : '' ?>value="<?= $affiliates->affiliate_id ?>">
                                    Основной</label>
                            </div>
                        </div>
                        <div class="col-md-3"><input type="text" name="Affiliates[address][]"
                                                     value="<?= $affiliates->address ?>" class="form-control" required
                                                     placeholder="Адрес"/></div>
                        <div class="col-md-3"><input type="text" name="Affiliates[email][]"
                                                     value="<?= $affiliates->email ?>" class="form-control" required
                                                     placeholder="Email"/></div>
                        <div class="col-md-3"><input type="text" name="Affiliates[phone][]"
                                                     value="<?= $affiliates->phone ?>" class="form-control" required
                                                     placeholder="Телефон"/></div>
                        <div class="hidden"><input type="text" name="Affiliates[lat][]" value="<?= $affiliates->lat ?>"
                                                   class="form-control" required placeholder="required"/></div>
                        <div class="hidden"><input type="text" name="Affiliates[lot][]" value="<?= $affiliates->lot ?>"
                                                   class="form-control" required placeholder="required"/></div>
                        <div class="col-md-1">
                            <div class="checkbox">
                                <label>
                                    <input name="Affiliates[delete][]" type="checkbox"
                                           value="<?= $affiliates->affiliate_id ?>">
                                    Удалить</label>
                            </div>
                        </div>
                    </div>
                    <script>$(document).ready(function () {
                            setMarkets(<?= $affiliates->lat?> , <?=$affiliates->lot?>)
                        })</script>
                <?php } ?>
            </div>
            <div class="form-group offset">
                <div>
                    <button type="submit" class="btn btn-theme">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    #infowindow-content .title {
        font-weight: bold;
    }

    #infowindow-content {
        display: none;
    }

    #map #infowindow-content {
        display: inline;
    }
</style>
<div id="map" style="height: 700px;"></div>
<div id="infowindow-content">
    <img src="" width="16" height="16" id="place-icon">
    <span id="place-name"  class="title"></span><br>
    <span id="place-address"></span>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4C_O-MsiRI0lbaGchVdP6YEvBTmkr7VY&language=ru&libraries=places"></script>

<script>

    var latlng = new google.maps.LatLng(55.7525033, 37.5897101);
    var settings = {
        zoom: 8,
        center: latlng,
        zoomControl: true,
        scrollwheel: false,
        mapTypeControl: false,
        navigationControl: true,
        navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoomControlOptions: {
            position: google.maps.ControlPosition.BOTTOM_CENTER
        },
        streetViewControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER
        },

    };
    var map = new google.maps.Map(document.getElementById('map'), settings);
    geocoder = new google.maps.Geocoder();

    var isClosed = false;
    var poly = new google.maps.Polyline({
        map: map,
        path: [],
        strokeColor: "#FF0000",
        strokeOpacity: 1.0,
        strokeWeight: 2
    });
    var input = document.getElementById('address-input');
    var infowindowContent = document.getElementById('infowindow-content');

    autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    autocomplete.setFields(
        ['address_components', 'geometry', 'icon', 'name']);
    var infowindow = new google.maps.InfoWindow();
    infowindow.setContent(infowindowContent);

    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
        }else {
            console.log(place.geometry.location)
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }

        infowindowContent.children['place-icon'].src = place.icon;
        infowindowContent.children['place-name'].textContent = place.name;
        infowindowContent.children['place-address'].textContent = address;
        infowindow.open(map, marker);
    });

    function setMarkets( lat , lng) {
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });
        marker.setPosition({lat:lat, lng:lng});
        marker.setVisible(true);
    }
    function addFilial() {
        var address = $('#address-input').val();
        if (address) {
            geocoder.geocode({"address": address}, function (results, status) {
                console.log(results)
                if (status == google.maps.GeocoderStatus.OK) {
                    var lat = results[0].geometry.location.lat(),
                        lng = results[0].geometry.location.lng();
                    console.log(lat, lng);
                    var from = $(document.getElementById('copy')).clone()[0];
                    var to = document.getElementById('tocopy');
                    from.removeAttribute('hidden');
                    from.removeAttribute('id');
                    var id = '_' + Math.random().toString(36).substr(2, 25);
                    from.setAttribute('id', id);
                    to.appendChild(from);
                    $('#' + id + ' .form-address').val(address);
                    $('#' + id + ' .span-address').append(address);
                    $('#' + id + ' .form-lat').val(lat);
                    $('#' + id + ' .form-lot').val(lng);
                }
            });

        }
    }


    function codeAddress(address, lat, lot, decrip, name, id, mem, metro) {

        geocoder.geocode({'address': address}, function (results, status) {
            var latLng = {lat: lat, lng: lot};

            if (status == 'OK') {
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,

                });
                var contentString = '<div class="block">\n' +
                    '                                        <h3>' + name + '</h3>\n' +
                    '                                        <span class="station_name">\n' +
                    '                                            <img src="http://demo.daedaworld.ru/img/metro_icon.png" alt="metro"/>\n' +
                    '                                            ' + metro + '\n' +
                    '                                        </span> <br/>\n' +
                    '                                        <span class="shop_address">\n' +
                    '                                            <img src="http://demo.daedaworld.ru/img/location_icon.png" alt="location"/>\n' +
                    '                                            ' + address + '\n' +
                    '                                        </span> <br/>\n' +
                    '                                        <span class="working_hours">\n' +
                    '                                            <img src="http://demo.daedaworld.ru/img/clock_icon.png" alt="working hours"/>\n' +
                    '                                            с 10:00 до 22:00\n' +
                    '                                        </span>\n' +
                    '                                    </div>';
                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });
                google.maps.event.addListener(marker, 'mouseover', function () {
                    infowindow.open(map, marker);
                });
                google.maps.event.addListener(marker, 'click', function (e) {
                    $('#setpoint option[value=' + id + ']').attr('selected', 'selected')
                });
                google.maps.event.addListener(marker, 'mouseout', function () {
                    infowindow.close(map, marker);
                });

            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });

    }
</script>
