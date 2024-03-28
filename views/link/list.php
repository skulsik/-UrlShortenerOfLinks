<?php

/** @var yii\web\View $this */

$this->title = 'Просмотр всех ссылок';

?>
<div class="card">
    <div class="card-header text-bg-success text-center">
        <h1>Обзор всех ссылок</h1>
    </div>
    <div class="card-body">
        <table class="table table-success table-striped">
            <tr class="">
                <td class="col-lg-3">
                    <p><strong>Хост</strong></p>
                </td>
                <td class="col-lg-6">
                    <p><strong>Длинная ссылка</strong></p>
                </td>
                <td class="col-lg-3">
                    <p><strong>Короткая ссылка</strong></p>
                </td>
            </tr>
            <?php if(!empty($model_list)): ?>
                <?php foreach($model_list as $host): ?>
                    <?php foreach($host->longLink as $long_link): ?>
                        <?php foreach($long_link->shortLink as $short_link): ?>
            <tr>
                <td><?= $host->host; ?></td>
                <td><?= $long_link->link; ?></td>
                <td><?= $short_link->link; ?></td>
            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>

        </table>
    </div>
</div>
