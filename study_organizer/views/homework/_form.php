<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Homework $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="homework-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'H_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'H_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'H_due_date')->textInput() ?>

    <?= $form->field($model, 'H_is_done')->textInput() ?>

    <?= $form->field($model, 'H_S_ID')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
