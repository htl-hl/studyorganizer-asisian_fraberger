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
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-lg-5">
                <h1 class="h3 mb-2"><?= Html::encode($this->title) ?></h1>
                <p class="text-muted mb-4">Sign in to manage homework, subjects, and teachers.</p>

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

                <div class="d-grid gap-2 mt-4">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-lg', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <p class="text-muted mt-4 mb-0">
                    Need an account?
                    <?= Html::a('Register here', ['/site/register']) ?>.
                </p>
            </div>
        </div>
    </div>
</div>
