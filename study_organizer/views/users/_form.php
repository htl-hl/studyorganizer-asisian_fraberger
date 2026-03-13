<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Users $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'U_username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'U_password')
        ->passwordInput(['maxlength' => true, 'value' => ''])
        ->hint($model->isNewRecord ? 'Choose a password for this account.' : 'Leave blank to keep the current password.') ?>

    <?= $form->field($model, 'U_role')->dropDownList([
        'user' => 'User',
        'admin' => 'Admin',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
