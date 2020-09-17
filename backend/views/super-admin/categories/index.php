<?php
$this->title = "Пользователи"
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
                        <h2><strong>Категории</strong></h2>
                        <label class="color"><a href="/categories/add">Добавить категорию</a></label>
                    </header>
                    <div class="panel-body">
                        <div class="dd" id="nestable">
                            <ol class="dd-list">
                                <?php foreach (\models\Categories::find()->where(['sub_id' => 0])->orderBy('sort ASC')->all() as $k => $c1) { ?>
                                    <li class="dd-item" data-id="<?= $c1->category_id ?>">
                                        <div class="dd-handle"><a href="/categories/edit/<?= $c1->category_id?>" ><?= $c1->name ?></a>
                                            <span style="float: right;right: 25px; margin: auto" class="iCheck"
                                                  data-color="red">
                                                        <label class="setstat">
                                                        <input class="setcat" data-target="<?= $c1->category_id ?>" <?= $c1->status ? 'checked' : '' ?>
                                                               name="<?= $c1->category_id ?>" type="checkbox"/>
                                                        </label>
                                                </span>
                                        </div>
                                        <?php if ($c2 = \models\Categories::find()->where(['sub_id' => $c1->category_id])->orderBy('sort ASC')->all()) { ?>
                                            <ol class="dd-list">
                                                <?php foreach ($c2 as $t => $c3) { ?>
                                                    <li class="dd-item" data-id="<?= $c3->category_id ?>">
                                                        <div class="dd-handle"><?= $c3->name ?>
                                                            <span style="float: right;right: 25px;margin: auto"
                                                                  class="iCheck" data-color="red">
                                                        <label class="setstat">
                                                        <input class="setcat" data-target="<?= $c3->category_id ?>" <?= $c3->status ? 'checked' : '' ?>
                                                               name="<?= $c3->category_id ?>" type="checkbox"/>
                                                        </label>
                                                        </span>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            </ol>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ol>
                        </div>
                        <hr>

                    </div><!-- //panel-body-->

                </section><!-- //panel-->
            </div>
        </div>
    </div>

</div>
<script>

    $(document).ready(function () {
        console.log($('.setstat input'))
        $('.iCheck-helper').click(function () {
            var cat = [];
            $.each($('input.setcat[type="checkbox"]'),function (i,item) {
                cat.push({id:item.name , status:item.checked ? 1:0})
            });
            $.ajax({
                type: "POST",
                url: '/categories/updatestat',
                data: {
                    '<?= Yii::$app->request->csrfParam; ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
                    category: cat
                },
                success: function (data) {
                    console.log(data)
                }
            })
        })
        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
            var test = list.nestable('serialize');
            $.ajax({
                type: "POST",
                url: '/categories/list',
                data: {
                    '<?= Yii::$app->request->csrfParam; ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
                    category: test
                },
                success: function (data) {
                    console.log(data)
                }
            })
        };

        // activate Nestable for list 1
        $('#nestable').nestable({
            group: 1
        }).on('change', updateOutput);

        // activate Nestable for list 2
        $('#nestable2').nestable({
            group: 1
        }).on('change', updateOutput);

        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));
        //updateOutput($('#nestable2').data('output', $('#nestable2-output')));

        $('#nestable-menu').on('click', function (e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });
        $('#nestable3').nestable();
    });
</script>
