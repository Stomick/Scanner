<?php
$type = [
    'hour' => 'В час',
    'day' => 'В день',
    'month' => 'В месяц',
    'piecework' => 'Договорная'
];
?>

<div class="row">
    <div id="main">
    <div class="tabbable">
        <ul id="profile-tab" class="nav nav-tabs" data-provide="tabdrop"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-align-right"></i> <span class="badge"></span></a><ul class="dropdown-menu"></ul></li>
            <li><a href="#" id="prevtab" data-change="prev"><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="#" id="nexttab" class="change" data-change="next"><i class="fa fa-chevron-right"></i></a></li>
            <li class="active"><a href="#tab1" data-toggle="tab">Списком</a></li>
            <li class=""><a href="#tab2" data-toggle="tab" class="timeline-show">Карта</a></li>
        </ul>
    </div>
        <div class="tab-content row">
            <div class="tab-pane active col-lg-12" id="tab1">
                <?php include 'spec/list.php' ?>
            </div>
            <div class="tab-pane fade col-lg-12" id="tab2">
                <?php include 'spec/map.php'?>
            </div>
        </div>
            <script>
        jQuery(function($) {
            $("#close_menu").click(2000, function() {
                $("#left_menu_container").fadeOut();
            });

            $("#show_menu").click(2000, function() {
                $("#left_menu_container").fadeIn();
            });
        });
    </script>

    </div>
</div>
