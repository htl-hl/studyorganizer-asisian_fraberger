<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Homework $model */

$this->title = Yii::t('app', 'Update Homework: {name}', [
    'name' => $model->H_ID,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Homeworks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->H_ID, 'url' => ['view', 'H_ID' => $model->H_ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="homework-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
