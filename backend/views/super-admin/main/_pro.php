<?php

use models\Stock;
$ret =[];
$andWhere = 1;

$select = [
    'stock.stock_id',
    'description',
    'tarif' ,
    'com.name' ,
    'com.url as logo' ,
    'photo' ,
    'status',
    'banner' ,
    'start_date as start' ,
    'end_date as end' ,
    'moder_rating',
    '(SELECT SUM(type) FROM `reviews` WHERE reviews.`stock_id`=stock.`stock_id`) as rating' , 'stock.created_at'];
$ret_pro = Stock::find()
    ->select($select)
    ->where(['tarif' => 'pro'])
    ->innerJoin('company com' , 'com.company_id=stock.company_id')
    ->innerJoin('stock_category stk' , 'stk.`stock_id`=stock.`stock_id`')
    ->andWhere($andWhere)
    ->asArray()
    ->orderBy('moder_rating , tarif desc , rating desc' )
    ->all();
?>
<section class="panel">
    <div class="panel-tools fully color " align="right" data-toolscolor="theme-inverse">
        <ul class="tooltip-area">
            <li>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-table="table-toggle-column-pro" data-table-target="#toggle-column-pro"  title="Table Column"><i class="fa fa-th-list"></i></button>
                    <ul class="dropdown-menu dppro arrow pull-right" role="menu"></ul>
                </div>
            </li>
            <li><a href="javascript:void(0)" class="btn btn-collapse" title="Collapse"><i class="fa fa-sort-amount-asc"></i></a></li>
            <li><a href="javascript:void(0)" class="btn btn-reload"  title="Reload"><i class="fa fa-retweet"></i></a></li>
            <li><a href="javascript:void(0)" class="btn btn-close" title="Close"><i class="fa fa-times"></i></a></li>
        </ul>
    </div>
    <div class="panel-body">
        <form>
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-hover" data-provide="data-table-pro" id="toggle-column-pro">
                <thead>
                <tr>
                    <th class="pro">№</th>
                    <th class="pro">Компания</th>
                    <th class="pro">Начало</th>
                    <th class="pro">Конец</th>
                    <th class="pro">Статус</th>
                    <th class="pro">Рейтинг</th>
                    <th class="pro">Дата создания</th>
                    <th class="pro"></th>
                </tr>
                </thead>
                <tbody align="center">
                <?php foreach($ret_pro as $k => $stok){?>
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

    function fnShowHidePro( iCol , table){
        var oTable = $(table).dataTable();
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        oTable.fnSetColumnVis( iCol, bVis ? false : true );
    }

    $(function() {

        //////////     DATA TABLE  COLUMN TOGGLE    //////////
        $('[data-table="table-toggle-column-pro"]').each(function(i) {
            var data=$(this).data(),
                table=$(this).data("table-target"),
                dropdown=$(this).parent().find(".dppro"),
                col=new Array;
            $(table).find("thead th").each(function(i) {
                $("<li><a  class='toggle-column-pro' href='javascript:void(0)' onclick=fnShowHidePro("+i+",'"+table+"') ><i class='fa fa-check'></i> "+$(this).text()+"</a></li>").appendTo(dropdown);
            });
        });

        //////////     COLUMN  TOGGLE     //////////
        $("a.toggle-column-pro").on('click',function(){
            $(this).toggleClass( "toggle-column-hide" );
            $(this).find('.fa').toggleClass( "fa-times" );
        });

        // Call dataTable in this page only
        // $('#table-example').dataTable();
        $('table[data-provide="data-table-pro"]').dataTable();
    });
</script>