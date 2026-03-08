<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Homework $model */

$this->title = Yii::t('app', 'Create Homework');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Homeworks'), 'url' => ['homework/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="homework-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="homework-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'H_title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'H_description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'H_due_date')->textInput(['type' => 'date']) ?>

        <?php
        $subjects = ArrayHelper::map(
                \app\models\Subjects::find()->all(),
                'S_ID',
                'S_name'
        );

        echo $form->field($model, 'H_S_ID')->dropDownList(
                $subjects,
                ['prompt' => 'Select Subject']
        );
        ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
