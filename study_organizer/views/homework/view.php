<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Homework $model */

$this->title = $model->H_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Homeworks'), 'url' => ['homework/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="homework-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'H_ID' => $model->H_ID], ['class' => 'btn btn-primary']) ?>
        <?php if (!(int) $model->H_is_done): ?>
            <?= Html::a('Mark done', ['done', 'H_ID' => $model->H_ID], [
                'class' => 'btn btn-success',
                'data' => [
                    'method' => 'post',
                    'confirm' => 'Mark this homework as done?',
                ],
            ]) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'H_ID' => $model->H_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'H_ID',
            'H_title',
            'H_description:ntext',
            [
                'attribute' => 'H_due_date',
                'format' => ['date', 'php:d.m.Y'],
            ],
            [
                'label' => 'Status',
                'format' => 'raw',
                'value' => (int) $model->H_is_done === 1
                    ? '<span class="badge text-bg-success">Done</span>'
                    : '<span class="badge text-bg-warning">Open</span>',
            ],
            [
                'label' => 'Subject',
                'value' => $model->subject ? $model->subject->S_name : 'No subject',
            ],
        ],
    ]) ?>

</div>
