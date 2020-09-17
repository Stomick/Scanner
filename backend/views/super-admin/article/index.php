<?php
$this->title = "Статьи"
?>
<div id="main">


    <ol class="breadcrumb">
        <li><a href="#">Главная</a></li>
    </ol>
    <!-- //breadcrumb-->

    <div id="content">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <h2><strong>Статьи</strong></h2>
                        <label class="color"><a href="/article/add">Добавить статью</a></label>
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <?php foreach (\models\Article::findAll(['colum'=> 1]) as $col){?>
                                    <div><a href="/article/edit?id=<?=$col->id?>"><?= $col->title?></a><a data-toggle="Удалить" style="float: right;color: red" href="/article/del?id=<?=$col->id?>">Удалить</a></div><br/>
                                <?php }?>
                            </div>
                            <div class="col-sm-4" style="border-right: 1px solid grey;border-left: 1px solid grey">
                                <?php foreach (\models\Article::findAll(['colum'=> 2]) as $col){?>
                                    <div><a href="/article/edit?id=<?=$col->id?>"><?= $col->title?></a><a data-toggle="Удалить" style="float: right; color: red" href="/article/del?id=<?=$col->id?>">Удалить</a></div><br/>
                                <?php }?>
                            </div>
                            <div class="col-sm-4">
                                <?php foreach (\models\Article::findAll(['colum'=> 3]) as $col){?>
                                    <div><a href="/article/edit?id=<?=$col->id?>"><?= $col->title?></a><a data-toggle="Удалить" style="float: right; color: red" href="/article/del?id=<?=$col->id?>">Удалить</a></div><br/>
                                <?php }?>
                            </div>
                        </div>
                    </div><!-- //panel-body-->

                </section><!-- //panel-->
            </div>
        </div>
    </div>

</div>


