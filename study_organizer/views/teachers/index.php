<?php

use app\models\Teachers;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\TeachersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Teachers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teachers-index">
    <div class="content-box">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="mb-0">
            <?= Html::a(Yii::t('app', 'Create teacher'), ['create'], ['class' => 'btn btn-primary']) ?>
        </p>
    </div>

    <div class="content-box">
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered table-striped'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'T_name',
                [
                    'label' => 'Subjects',
                    'value' => static function (Teachers $model) {
                        return count($model->subjects);
                    },
                ],
                [
                    'attribute' => 'T_is_active',
                    'label' => 'Status',
                    'format' => 'raw',
                    'filter' => ['1' => 'Active', '0' => 'Inactive'],
                    'value' => static function (Teachers $model) {
                        return Html::tag(
                            'span',
                            (int) $model->T_is_active === 1 ? 'Active' : 'Inactive',
                            ['class' => 'status-box ' . ((int) $model->T_is_active === 1 ? 'status-done' : 'status-inactive')]
                        );
                    },
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => '{view} {update}',
                    'contentOptions' => ['class' => 'actions-cell'],
                    'buttons' => [
                        'view' => static function ($url, $model, $key) {
                            return Html::a('View', $url, ['class' => 'btn btn-sm btn-outline-secondary']);
                        },
                        'update' => static function ($url, $model, $key) {
                            return Html::a('Edit', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                        },
                    ],
                    'urlCreator' => function ($action, Teachers $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'T_ID' => $model->T_ID]);
                    },
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
