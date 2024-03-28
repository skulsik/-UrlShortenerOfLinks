<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Главная страница';
?>
<div class="site-index">
    <div class="card">
        <div class="card-header text-bg-success text-center">
            <h1>Создание короткой ссылки.</h1>
        </div>
        <div class="card-body">
            <h5 class="card-title">Вставьте в поле, вашу активную ссылку.</h5>
            <div class="short-link-form">

                <?php $form = ActiveForm::begin(['action' => ['link/create']]); ?>

                <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Создать короткую ссылку', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

    <div class="body-content">

        <div class="row">

        </div>

    </div>
</div>
