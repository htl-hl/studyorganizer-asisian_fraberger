<?php

use app\models\Subjects;
use app\models\Teachers;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\SubjectsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Subjects');
$this->params['breadcrumbs'][] = $this->title;
$teacherFilter = ArrayHelper::map(
    Teachers::find()->orderBy(['T_name' => SORT_ASC])->all(),
    'T_ID',
    static function (Teachers $teacher) {
        return $teacher->T_name . ((int) $teacher->T_is_active === 1 ? '' : ' (inactive)');
    }
);
?>
<div class="subjects-index">
    <div class="content-box">
        <div class="section-header">
            <h1 class="mb-0"><?= Html::encode($this->title) ?></h1>
            <?= Html::a(Yii::t('app', 'Create subject'), ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
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
                'S_name',
                [
                    'attribute' => 'S_T_ID',
                    'label' => 'Teacher',
                    'filter' => $teacherFilter,
                    'value' => static function (Subjects $model) {
                        if ($model->teacher === null) {
                            return 'No teacher';
                        }

                        return $model->teacher->T_name . ((int) $model->teacher->T_is_active === 1 ? '' : ' (inactive)');
                    },
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => '{view} {update} {delete}',
                    'contentOptions' => ['class' => 'actions-cell'],
                    'buttons' => [
                        'view' => static function ($url, $model, $key) {
                            return Html::a('View', $url, ['class' => 'btn btn-sm btn-outline-secondary']);
                        },
                        'update' => static function ($url, $model, $key) {
                            return Html::a('Edit', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                        },
                        'delete' => static function ($url, $model, $key) {
                            return Html::a('Delete', $url, [
                                'class' => 'btn btn-sm btn-outline-danger',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Delete this subject?',
                                ],
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, Subjects $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'S_ID' => $model->S_ID]);
                    },
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
