<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\HomeworkSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="homework-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'H_ID') ?>

    <?= $form->field($model, 'H_title') ?>

    <?= $form->field($model, 'H_description') ?>

    <?= $form->field($model, 'H_due_date') ?>

    <?= $form->field($model, 'H_is_done') ?>

    <?php // echo $form->field($model, 'H_S_ID') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
