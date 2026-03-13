<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Users $model */

$this->title = Yii::t('app', 'Update Users: {name}', [
    'name' => $model->U_ID,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['users/index']];
$this->params['breadcrumbs'][] = ['label' => $model->U_ID, 'url' => ['view', 'U_ID' => $model->U_ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="users-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
