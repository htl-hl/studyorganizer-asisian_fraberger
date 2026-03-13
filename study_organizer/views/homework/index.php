<?php

use app\models\Homework;
use app\models\Subjects;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Homework'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'format' => ['date', 'php:d.m.Y'],
            ],
            [
                'attribute' => 'H_is_done',
                'label' => 'Status',
                'format' => 'raw',
                'filter' => ['0' => 'Open', '1' => 'Done'],
                'value' => static function (Homework $model) {
                    if ((int) $model->H_is_done === 1) {
                        return '<span class="badge text-bg-success">Done</span>';
                    }

                    return '<span class="badge text-bg-warning">Open</span>';
                },
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {done} {delete}',
                'buttons' => [
                    'done' => static function ($url, Homework $model) {
                        if ((int) $model->H_is_done === 1) {
                            return '';
                        }

                        return Html::a('Done', $url, [
                            'class' => 'btn btn-sm btn-outline-success',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Mark this homework as done?',
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
