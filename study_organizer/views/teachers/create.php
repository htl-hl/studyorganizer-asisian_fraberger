<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Teachers $model */

$this->title = Yii::t('app', 'Create Teacher');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teachers'), 'url' => ['teachers/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teachers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
