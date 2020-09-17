<?php
$this->title = "Профиль пользователя";
?>

<link rel="stylesheet" href="/croper/croppie.css"/>
<script src="/croper/croppie.js"></script>
<script src="/croper/loadAvatar.js"></script>
<div class="container profile_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 pad_mobile_none">
            <div style="margin-bottom: 15px" class="white_bg_block">
                <ul class="nav nav-tabs" role="tablist">
                    <?php foreach ($li as $link){?>
                        <li role="presentation" <?= $link['active'] ? 'class="active"' : '' ?>>
                            <a href="<?= $link['href']?>"><?= $link['title']?></a>
                        </li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <?php include $page.'.php'?>
    </div>
</div>


