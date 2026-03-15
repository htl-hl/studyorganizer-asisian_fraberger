<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\SignupForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="content-box">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
                'enableClientValidation' => true,
            ]); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'maxlength' => true,
                'autocomplete' => 'username',
            ]) ?>
            <?= $form->field($model, 'password')->passwordInput([
                'autocomplete' => 'new-password',
            ])->hint('Use at least 6 characters.') ?>

            <div class="form-group">
                <?= Html::submitButton('Create account', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <p class="mb-0">
                Already have an account?
                <?= Html::a('Login here', ['/site/login']) ?>.
            </p>
        </div>
    </div>
</div>
