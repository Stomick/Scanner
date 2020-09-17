<?php
?>
<div class="panel-body">
    <?php echo \yii\widgets\LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
  <span class="sorting_by_price">
  <?= $sort->link('price') . " | " . $sort->link('title') . " | " . $sort->link('created'); ?>
  </span>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th width="30%">Action</th>
        </tr>
        </thead>
        <tbody align="center">
        <?php foreach ($markers as $mark) {
            $muser = \models\MUser::findOne($mark->muser_id);
            ?>
            <tr>
                <td><?= $mark->id?></td>
                <td valign="middle"><?= $mark->title?></td>
                <td><?= $muser->email?></td>
                <td><span class="label label-<?= $mark->public ? "success" : 'warning'?>"> <?= $mark->public ? "Опубликованно" : "Не опубликованно"?></span></td>
                <td>
                    <span class="tooltip-area">
                    <a href="/works?info=<?=$mark->id?>"
                       class="btn btn-default btn-sm"
                       title=""
                       data-original-title="Edit"><i
                                class="fa fa-pencil"></i></a>
                    </span>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php echo \yii\widgets\LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>
