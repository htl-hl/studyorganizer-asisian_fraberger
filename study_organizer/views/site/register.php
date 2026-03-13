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
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-lg-5">
                <h1 class="h3 mb-2"><?= Html::encode($this->title) ?></h1>
                <p class="text-muted mb-4">Create an account and you can start organizing your homework right away.</p>

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

                <div class="d-grid gap-2 mt-4">
                    <?= Html::submitButton('Create account', ['class' => 'btn btn-primary btn-lg', 'name' => 'register-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <p class="text-muted mt-4 mb-0">
                    Already have an account?
                    <?= Html::a('Login here', ['/site/login']) ?>.
                </p>
            </div>
        </div>
    </div>
</div>
