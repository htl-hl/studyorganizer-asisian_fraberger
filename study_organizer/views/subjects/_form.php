<?php

use app\models\Teachers;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Subjects $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="subjects-form">
    <?php
    $teachers = ArrayHelper::map(
        Teachers::find()
            ->where(['T_is_active' => 1])
            ->orderBy(['T_name' => SORT_ASC])
            ->all(),
        'T_ID',
        'T_name'
    );
    $hasTeachers = !empty($teachers);
    ?>

    <?php $form = ActiveForm::begin(); ?>

    <?php if (!$hasTeachers): ?>
        <div class="alert alert-warning">
            Add an active teacher before creating a subject.
            <?= Html::a('Create teacher', ['/teachers/create'], ['class' => 'alert-link']) ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'S_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'S_T_ID')->dropDownList(
        $teachers,
        [
            'prompt' => 'Select a teacher',
            'disabled' => !$hasTeachers,
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'disabled' => !$hasTeachers]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
