<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Главная страница';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Создание короткой ссылки.</h1>

        <p class="lead">Вставьте в поле, вашу активную ссылку.</p>

        <div class="short-link-form">

            <?php $form = ActiveForm::begin(['action' => ['link/create']]); ?>

            <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Создать короткую ссылку', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

    <div class="body-content">

        <div class="row">

        </div>

    </div>
</div>
