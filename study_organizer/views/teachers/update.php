<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Teachers $model */

$this->title = Yii::t('app', 'Update Teacher: {name}', [
    'name' => $model->T_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teachers'), 'url' => ['teachers/index']];
$this->params['breadcrumbs'][] = ['label' => $model->T_ID, 'url' => ['view', 'T_ID' => $model->T_ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="teachers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
