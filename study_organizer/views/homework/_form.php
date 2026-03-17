<?php

use app\models\Subjects;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Homework $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="homework-form">
    <?php
    $subjects = ArrayHelper::map(
        Subjects::find()->orderBy(['S_name' => SORT_ASC])->all(),
        'S_ID',
        'S_name'
    );
    $hasSubjects = !empty($subjects);
    ?>

    <?php $form = ActiveForm::begin(); ?>

    <?php if (!$hasSubjects): ?>
        <div class="alert alert-warning">
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()): ?>
                Create a subject before adding homework.
                <?= Html::a('Create subject', ['/subjects/create'], ['class' => 'alert-link']) ?>
            <?php else: ?>
                No subjects are available yet. Ask an admin to create at least one subject first.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'H_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'H_description')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'H_due_date')->input('date') ?>

    <?= $form->field($model, 'H_S_ID')->dropDownList(
        $subjects,
        [
            'prompt' => 'Select a subject',
            'disabled' => !$hasSubjects,
        ]
    ) ?>

    <p class="form-note">After saving, you can mark the homework as done. Done homework cannot be changed anymore.</p>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'disabled' => !$hasSubjects]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
