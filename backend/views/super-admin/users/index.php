<?php
$this->title = "Пользователи"
?>
<div id="main">
    <div id="content">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <h2>Пользователи </h2>
                    </header>
                    <div class="panel-tools fully color" align="right" data-toolscolor="#6CC3A0">
                        <ul class="tooltip-area">
                            <li><a href="javascript:void(0)" class="btn btn-collapse" title="Collapse"><i class="fa fa-sort-amount-asc"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-reload"  title="Reload"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-close" title="Close"><i class="fa fa-times"></i></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <a href="/users/add" type="button" class="btn btn-primary">Добавить</a>
                        <form>
                            <table class="table table-striped" id="table-example">
                                <thead>
                                <tr>
                                    <th  class="text-center">№</th>
                                    <th class="text-center">Имя</th>
                                    <th class="text-center">Емаил</th>
                                    <th class="text-center">Роль</th>
                                    <th class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody align="center">
                                <?php foreach (\models\User::find()->all() as $k => $user) {?>
                                <tr class="odd gradeX">
                                    <td><?= $user->id?></td>
                                    <td><?= $user->username ?></td>
                                    <td><?= $user->email ?></td>
                                    <td class="center"><?= $user->role == 'partner' ? 'Партнер' : ($user->role == 'admin' ? 'Админ ':'Супер админ')?></td>
                                    <td class="center">
                                        <span class="tooltip-area">
											<a href="/users/edit?id=<?=$user->id?>" class="btn btn-default btn-sm" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
											<a href="/users/delete?id=<?=$user->id?>" class="btn btn-default btn-sm" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
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
        <!-- //content > row-->

    </div>
    <!-- //content-->


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
