<?php


?>
<div id="main">
    <ol class="breadcrumb">
        <li><a href="/">Главная</a></li>
        <li class="active">Спиок акций</li>
    </ol>
    <!-- //breadcrumb-->
    <div id="content">
<section class="panel">
    <div class="panel-tools fully color " align="right" data-toolscolor="theme-inverse">
        <ul class="tooltip-area">
            <li>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-table="table-toggle-column" data-table-target="#toggle-column"  title="Table Column"><i class="fa fa-th-list"></i></button>
                    <ul class="dropdown-menu arrow pull-right" role="menu"></ul>
                </div>
            </li>
            <li><a href="javascript:void(0)" class="btn btn-collapse" title="Collapse"><i class="fa fa-sort-amount-asc"></i></a></li>
            <li><a href="javascript:void(0)" class="btn btn-reload"  title="Reload"><i class="fa fa-retweet"></i></a></li>
            <li><a href="javascript:void(0)" class="btn btn-close" title="Close"><i class="fa fa-times"></i></a></li>
        </ul>
    </div>
    <div class="panel-body">
        <form>
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-hover" data-provide="data-table" id="toggle-column">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Компания</th>
                    <th>Начало</th>
                    <th>Конец</th>
                    <th>Тип</th>
                    <th>Рейтинг</th>
                    <th>Дата создания</th>
                    <th></th>
                </tr>
                </thead>
                <tbody align="center">
                <?php foreach($ret as $k => $stok){?>
                    <tr class="odd gradeX">
                        <td><?=$stok['stock_id']?></td>
                        <td><?=$stok['name']?></td>
                        <td><?= date('d.m.Y',$stok['start'])?></td>
                        <td><?= date('d.m.Y',$stok['end'])?></td>
                        <td><?=$stok['tarif']?></td>
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
    </div>
</div>
<script type="text/javascript">

    function fnShowHide( iCol , table){
        var oTable = $(table).dataTable();
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        oTable.fnSetColumnVis( iCol, bVis ? false : true );
    }

    $(function() {

        //////////     DATA TABLE  COLUMN TOGGLE    //////////
        $('[data-table="table-toggle-column"]').each(function(i) {
            var data=$(this).data(),
                table=$(this).data("table-target"),
                dropdown=$(this).parent().find(".dropdown-menu"),
                col=new Array;
            $(table).find("thead th").each(function(i) {
                $("<li><a  class='toggle-column' href='javascript:void(0)' onclick=fnShowHide("+i+",'"+table+"') ><i class='fa fa-check'></i> "+$(this).text()+"</a></li>").appendTo(dropdown);
            });
        });

        //////////     COLUMN  TOGGLE     //////////
        $("a.toggle-column").on('click',function(){
            $(this).toggleClass( "toggle-column-hide" );
            $(this).find('.fa').toggleClass( "fa-times" );
        });

        // Call dataTable in this page only
        $('#table-example').dataTable();
        $('table[data-provide="data-table"]').dataTable();
    });
</script>