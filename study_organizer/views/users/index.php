<?php

use app\models\Users;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\UsersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
    <div class="content-box">
        <div class="section-header">
            <h1 class="mb-0"><?= Html::encode($this->title) ?></h1>
            <?= Html::a(Yii::t('app', 'Create Users'), ['create'], ['class' => 'btn btn-primary']) ?>
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
                'U_username',
                [
                    'attribute' => 'U_role',
                    'label' => 'Role',
                    'format' => 'raw',
                    'filter' => ['user' => 'User', 'admin' => 'Admin'],
                    'value' => static function (Users $model) {
                        $class = $model->U_role === 'admin' ? 'status-open' : 'status-inactive';

                        return Html::tag('span', Html::encode(ucfirst($model->U_role)), [
                            'class' => 'status-box ' . $class,
                        ]);
                    },
                ],
                [
                    'class' => ActionColumn::class,
                    'contentOptions' => ['class' => 'actions-cell'],
                    'template' => '{view} {update} {delete}',
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
                                    'confirm' => 'Delete this user?',
                                ],
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, Users $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'U_ID' => $model->U_ID]);
                    },
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
