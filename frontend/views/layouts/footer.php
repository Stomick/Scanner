<?php
?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <?php foreach (\models\Article::findAll(['colum'=> 1]) as $col){?>
                    <a href="/info/article/<?=$col->url?>.html"><?= $col->title?></a>
                <?php }?>
            </div>
            <div class="col-md-4 col-xs-12">
                <?php foreach (\models\Article::findAll(['colum'=> 2]) as $col){?>
                    <a href="/info/article/<?=$col->url?>.html"><?= $col->title?></a>
                <?php }?>
            </div>
            <div class="col-md-4 col-xs-12">
                <?php foreach (\models\Article::findAll(['colum'=> 3]) as $col){?>
                    <a href="/info/article/<?=$col->url?>.html"><?= $col->title?></a>
                <?php }?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <span style="float: right;">(с) ООО «КОМПАНИЯ «ИНВЕНТРЕЙД» все права защищены</span>
    </div>
</footer>

