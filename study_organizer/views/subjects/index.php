<?php

use app\models\Subjects;
use app\models\Teachers;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\SubjectsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Subjects');
$this->params['breadcrumbs'][] = $this->title;
$teacherFilter = ArrayHelper::map(
    Teachers::find()->orderBy(['T_name' => SORT_ASC])->all(),
    'T_ID',
    'T_name'
);
?>
<div class="subjects-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Subjects'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'S_name',
            [
                'attribute' => 'S_T_ID',
                'label' => 'Teacher',
                'filter' => $teacherFilter,
                'value' => static function (Subjects $model) {
                    return $model->teacher ? $model->teacher->T_name : 'No teacher';
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Subjects $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'S_ID' => $model->S_ID]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
