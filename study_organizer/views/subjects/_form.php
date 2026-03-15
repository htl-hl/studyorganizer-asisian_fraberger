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
    $teacherQuery = Teachers::find()->orderBy(['T_name' => SORT_ASC]);

    if ($model->isNewRecord) {
        $teacherQuery->where(['T_is_active' => 1]);
    } else {
        $teacherQuery->andWhere(['or', ['T_is_active' => 1], ['T_ID' => $model->S_T_ID]]);
    }

    $teachers = ArrayHelper::map(
        $teacherQuery->all(),
        'T_ID',
        static function (Teachers $teacher) {
            return $teacher->T_name . ((int) $teacher->T_is_active === 1 ? '' : ' (inactive)');
        }
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

    <p class="form-note">Inactive teachers stay assigned to old subjects, but new subjects should usually use active teachers.</p>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'disabled' => !$hasTeachers]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
