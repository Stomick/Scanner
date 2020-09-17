<?php
$this->title = "Пользователи"
?>
<div id="main">
    <div id="content">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <h2>Пользователи</h2>
                    </header>
                    <div class="panel-tools fully color" align="right" data-toolscolor="#6CC3A0">
                        <ul class="tooltip-area">
                            <li><a href="javascript:void(0)" class="btn btn-collapse" title="Collapse"><i class="fa fa-sort-amount-asc"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-reload"  title="Reload"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-close" title="Close"><i class="fa fa-times"></i></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <?= $sort->link('price') . " | " . $sort->link('title') . " | " . $sort->link('created'); ?>
                        <form>
                            <table class="table table-striped" id="table-example">
                                <thead>
                                <tr>
                                    <th  class="text-center">№</th>
                                    <th class="text-center">Имя</th>
                                    <th class="text-center">Емаил</th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody align="center">
                                <?php foreach ($users as $k => $user) {?>
                                    <tr class="odd gradeX">
                                        <td><?= $user->id?></td>
                                        <td><?= $user->firstname . ' ' . $user->lastname ?></td>
                                        <td><?= $user->email ?></td>
                                        <td class="center">
                                        <span class="tooltip-area">
											<a href="/musers/info?id=<?=$user->id?>" class="btn btn-default btn-sm" title="" data-original-title="Информация"><i class="fa fa-pencil"></i></a>
										</span>
                                        </td> <td class="center">
                                        <span class="tooltip-area">
											<a href="/musers/chat?id=<?=$user->id?>" class="btn btn-default btn-sm" title="" data-original-title="Чат"><i class="fa fa-comment"></i></a>
										</span>
                                        </td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </form>
                        <?php echo \yii\widgets\LinkPager::widget([
                            'pagination' => $pages,
                        ]);?>
                    </div>
                </section>
            </div>

        </div>
        <!-- //content > row-->

    </div>
    <!-- //content-->


</div>