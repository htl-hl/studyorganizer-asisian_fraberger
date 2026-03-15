<?php

use app\models\Homework;
use app\models\Subjects;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\HomeworkSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Homeworks');
$this->params['breadcrumbs'][] = $this->title;
$subjectFilter = ArrayHelper::map(
    Subjects::find()->orderBy(['S_name' => SORT_ASC])->all(),
    'S_ID',
    'S_name'
);
?>
<div class="homework-index">
    <div class="content-box">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="mb-0">
            <?= Html::a(Yii::t('app', 'Create homework'), ['create'], ['class' => 'btn btn-primary']) ?>
        </p>
    </div>

    <div class="content-box">
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered table-striped'],
            'rowOptions' => static function (Homework $model) {
                return ['class' => $model->getDueRowClass()];
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'H_title',
                [
                    'attribute' => 'H_S_ID',
                    'label' => 'Subject',
                    'filter' => $subjectFilter,
                    'value' => static function (Homework $model) {
                        return $model->subject ? $model->subject->S_name : 'No subject';
                    },
                ],
                [
                    'attribute' => 'H_due_date',
                    'format' => 'raw',
                    'value' => static function (Homework $model) {
                        return Html::tag(
                            'span',
                            Yii::$app->formatter->asDate($model->H_due_date, 'php:d.m.Y'),
                            ['class' => 'due-box ' . $model->getDueCssClass()]
                        );
                    },
                ],
                [
                    'attribute' => 'H_is_done',
                    'label' => 'Status',
                    'format' => 'raw',
                    'filter' => ['0' => 'Open', '1' => 'Done'],
                    'value' => static function (Homework $model) {
                        return Html::tag(
                            'span',
                            $model->isDone() ? 'Done' : 'Open',
                            ['class' => 'status-box ' . ($model->isDone() ? 'status-done' : 'status-open')]
                        );
                    },
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => '{view} {update} {done} {delete}',
                    'contentOptions' => ['class' => 'actions-cell'],
                    'visibleButtons' => [
                        'update' => static function ($model, $key, $index) {
                            return $model->isEditable();
                        },
                        'done' => static function ($model, $key, $index) {
                            return $model->isEditable();
                        },
                        'delete' => static function ($model, $key, $index) {
                            return $model->isEditable();
                        },
                    ],
                    'buttons' => [
                        'view' => static function ($url, $model, $key) {
                            return Html::a('View', $url, ['class' => 'btn btn-sm btn-outline-secondary']);
                        },
                        'update' => static function ($url, $model, $key) {
                            return Html::a('Edit', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                        },
                        'done' => static function ($url, $model, $key) {
                            return Html::a('Done', $url, [
                                'class' => 'btn btn-sm btn-outline-success',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Mark this homework as done?',
                                ],
                            ]);
                        },
                        'delete' => static function ($url, $model, $key) {
                            return Html::a('Delete', $url, [
                                'class' => 'btn btn-sm btn-outline-danger',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Delete this homework item?',
                                ],
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, Homework $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'H_ID' => $model->H_ID]);
                    },
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
