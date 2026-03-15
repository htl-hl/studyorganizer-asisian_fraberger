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
    <div class="content-box">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (!$model->isEditable()): ?>
            <div class="alert alert-secondary">
                This homework is completed and cannot be edited or deleted anymore.
            </div>
        <?php endif; ?>

        <p>
            <?php if ($model->isEditable()): ?>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'H_ID' => $model->H_ID], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Mark done', ['done', 'H_ID' => $model->H_ID], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'method' => 'post',
                        'confirm' => 'Mark this homework as done?',
                    ],
                ]) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'H_ID' => $model->H_ID], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
            <?= Html::a('Back to list', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'H_ID',
                'H_title',
                'H_description:ntext',
                [
                    'attribute' => 'H_due_date',
                    'format' => 'raw',
                    'value' => Html::tag(
                        'span',
                        Yii::$app->formatter->asDate($model->H_due_date, 'php:d.m.Y'),
                        ['class' => 'due-box ' . $model->getDueCssClass()]
                    ),
                ],
                [
                    'label' => 'Status',
                    'format' => 'raw',
                    'value' => Html::tag(
                        'span',
                        $model->isDone() ? 'Done' : 'Open',
                        ['class' => 'status-box ' . ($model->isDone() ? 'status-done' : 'status-open')]
                    ),
                ],
                [
                    'label' => 'Subject',
                    'value' => $model->subject ? $model->subject->S_name : 'No subject',
                ],
            ],
        ]) ?>
    </div>
</div>
