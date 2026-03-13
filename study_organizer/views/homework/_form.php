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
            Create a subject before adding homework.
            <?= Html::a('Create subject', ['/subjects/create'], ['class' => 'alert-link']) ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'H_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'H_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'H_due_date')->input('date') ?>

    <?= $form->field($model, 'H_S_ID')->dropDownList(
        $subjects,
        [
            'prompt' => 'Select a subject',
            'disabled' => !$hasSubjects,
        ]
    ) ?>

    <?= $form->field($model, 'H_is_done')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'disabled' => !$hasSubjects]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
