<?php
?>
<div id="main">

    <ol class="breadcrumb">
        <li><a href="#">Главная</a></li>
    </ol>
    <!-- //breadcrumb-->

    <div id="content">

        <div class="row">
            <div class="col-md-3">
                <div class="well bg-info">
                    <div class="widget-tile">
                        <section>
                            <h5><strong>Мобильные</strong> пользователи</h5>
                            <h2>
                                <?= \models\MobDevice::find()->where('user_id=0')->count()?>
                                /
                                <?= \models\MobDevice::find()->where('user_id!=0')->count()?>
                            </h2>
                        </section>
                        <div class="hold-icon"><i class="fa fa-bar-chart-o"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well bg-inverse">
                    <div class="widget-tile">
                        <section>
                            <h5><strong>FREE</strong><br/>  </h5>
                            <h2>
                                <?= \models\Stock::find()->where('status!="modern" AND 	tarif="free"')->count()?>
                                /
                                <?= \models\Stock::find()->where('status="modern" AND 	tarif="free"')->count()?>
                            </h2>
                        </section>
                        <div class="hold-icon"><i class="fa fa-shopping-cart"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well bg-theme">
                    <div class="widget-tile">
                        <section>
                            <h5><strong>PRO</strong><br/>  </h5>
                            <h2>
                                <?= \models\Stock::find()->where('status!="modern" AND 	tarif="pro"')->count()?>
                                /
                                <?= \models\Stock::find()->where('status="modern" AND 	tarif="pro"')->count()?>
                            </h2>
                        </section>
                        <div class="hold-icon"><i class="fa fa-laptop"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well bg-theme">
                    <div class="widget-tile">
                        <section>
                            <h5><strong>enterprise</strong><br/>  </h5>
                            <h2>
                                <?= \models\Stock::find()->where('status!="modern" AND 	tarif="enterprise"')->count()?>
                                /
                                <?= \models\Stock::find()->where('status="modern" AND 	tarif="enterprise"')->count()?>
                            </h2>
                        </section>
                        <div class="hold-icon"><i class="fa fa-laptop"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h2><strong>Акции</strong></h2>
                <hr>
                <div class="tabbable">

                    <section class="panel">
                        <div class="panel-tools fully color " align="right" data-toolscolor="theme-inverse">
                            <ul class="tooltip-area">
                                <li>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-table="table-toggle-column-free" data-table-target="#toggle-column-free"  title="Table Column"><i class="fa fa-th-list"></i></button>
                                        <ul class="dropdown-menu dpfree arrow pull-right" role="menu"></ul>
                                    </div>
                                </li>
                                <li><a href="javascript:void(0)" class="btn btn-collapse" title="Collapse"><i class="fa fa-sort-amount-asc"></i></a></li>
                                <li><a href="javascript:void(0)" class="btn btn-reload"  title="Reload"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="javascript:void(0)" class="btn btn-close" title="Close"><i class="fa fa-times"></i></a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <form>
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-hover" data-provide="data-table-free" id="toggle-column-free">
                                    <thead>
                                    <tr>
                                        <th class="free">№</th>
                                        <th class="free">Компания</th>
                                        <th class="free">Начало</th>
                                        <th class="free">Конец</th>
                                        <th class="free">Статус</th>
                                        <th class="free">Рейтинг</th>
                                        <th class="free">Дата создания</th>
                                        <th class="free"></th>
                                    </tr>
                                    </thead>
                                    <tbody align="center">
                                    <?php foreach($ret as $k => $stok){?>
                                        <tr class="odd gradeX">
                                            <td><?=$stok['stock_id']?></td>
                                            <td><?=$stok['name']?></td>
                                            <td><?= date('d.m.Y',$stok['start'])?></td>
                                            <td><?= date('d.m.Y',$stok['end'])?></td>
                                            <?php if($stok['status'] == 'inprogress'){?>
                                                <td><span class="label label-success ">Опубликованно</span></td>
                                            <?php }elseif ($stok['status'] == 'modern'){?>
                                                <td><span class="label label-warning ">На проверке</span></td>
                                            <?php }elseif ($stok['status'] == 'ended' || $stok['status']=='arhive'){?>
                                                <td><span class="label label-danger ">В архиве</span></td>
                                            <?php }?>
                                            <td>
                                                <?= $stok['moder_rating']?>
                                            </td><td>
                                                <?= date('d.m.Y H:i',$stok['created_at'])?>
                                            </td>
                                            <td>
                        <span class="tooltip-area">
                            <a href="/stock/edit?id=<?= $stok['stock_id']?>" class="btn btn-default btn-sm" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0)"  class="btn btn-default btn-sm" title="Delete"><i class="fa fa-trash-o"></i></a>
                        </span>
                                            </td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </section>

                    <script type="text/javascript">

                        function fnShowHideFree( iCol , table){
                            var oTable = $(table).dataTable();
                            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
                            oTable.fnSetColumnVis( iCol, bVis ? false : true );
                        }

                        $(function() {

                            //////////     DATA TABLE  COLUMN TOGGLE    //////////
                            $('[data-table="table-toggle-column-free"]').each(function(i) {
                                var data=$(this).data(),
                                    table=$(this).data("table-target"),
                                    dropdown=$(this).parent().find(".dpfree"),
                                    col=new Array;
                                $(table).find("thead th").each(function(i) {
                                    $("<li><a  class='toggle-column-free' href='javascript:void(0)' onclick=fnShowHideFree("+i+",'"+table+"') ><i class='fa fa-check'></i> "+$(this).text()+"</a></li>").appendTo(dropdown);
                                });
                            });

                            //////////     COLUMN  TOGGLE     //////////
                            $("a.toggle-column-free").on('click',function(){
                                $(this).toggleClass( "toggle-column-hide" );
                                $(this).find('.fa').toggleClass( "fa-times" );
                            });

                            // Call dataTable in this page only
                            // $('#table-example').dataTable();
                            $('table[data-provide="data-table-free"]').dataTable();
                        });
                    </script>
                </div>
            </div>

        </div>
        <!-- //content > row-->

    </div>
    <!-- //content-->

    <footer id="site-footer">
        <section>&copy; Copyright 2014, By zicedemo</section>
    </footer>

</div>
