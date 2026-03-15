<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Teachers $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="teachers-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'T_name')->textInput(['maxlength' => true]) ?>

    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'initialSubjectName')->textInput(['maxlength' => true])
            ->hint('A teacher must have at least one subject. This subject will be created automatically.') ?>
    <?php endif; ?>

    <?= $form->field($model, 'T_is_active')->checkbox() ?>

    <p class="form-note">Teachers are not deleted. If needed, set them to inactive.</p>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
