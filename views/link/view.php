<?php

/** @var yii\web\View $this */

$this->title = 'Просмотр созданной ссылки';

?>
<div class="card">
    <div class="card-header text-bg-success text-center">
        <h1>Обзор созданной ссылки</h1>
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
            <tr>
                <td><?= $host; ?></td>
                <td><?= $long_link; ?></td>
                <td><?= $short_link; ?></td>
            </tr>
        </table>
    </div>
</div>
