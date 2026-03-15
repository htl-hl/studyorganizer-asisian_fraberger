<?php

/** @var yii\web\View $this */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="content-box">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'enableClientValidation' => true,
            ]); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'maxlength' => true,
                'autocomplete' => 'username',
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'autocomplete' => 'current-password',
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <p class="mb-0">
                Need an account?
                <?= Html::a('Register here', ['/site/register']) ?>.
            </p>
        </div>
    </div>
</div>
