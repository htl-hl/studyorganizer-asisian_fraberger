<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Subjects $model */

$this->title = $model->S_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subjects'), 'url' => ['subjects/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="subjects-view">
    <div class="content-box">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'S_ID' => $model->S_ID], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'S_ID' => $model->S_ID], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('Back to list', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'S_ID',
                'S_name',
                [
                    'label' => 'Teacher',
                    'value' => $model->teacher
                        ? $model->teacher->T_name . ((int) $model->teacher->T_is_active === 1 ? '' : ' (inactive)')
                        : 'No teacher',
                ],
            ],
        ]) ?>
    </div>
</div>
