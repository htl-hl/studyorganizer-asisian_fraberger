<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\HomeworkSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Homeworks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="homework-index">
    <div class="content-box">
        <div class="section-header">
            <h1 class="mb-0"><?= Html::encode($this->title) ?></h1>
            <?= Html::a(Yii::t('app', 'Create homework'), ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <div class="content-box">
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php if ($dataProvider->getCount() === 0): ?>
            <div class="empty-state">
                <?= Html::a(Yii::t('app', 'Create homework'), ['create'], ['class' => 'btn btn-primary']) ?>
            </div>
        <?php else: ?>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'homework-list-view'],
                'summaryOptions' => ['class' => 'list-summary'],
                'itemOptions' => ['class' => 'col-md-6 col-xl-4'],
                'layout' => "{summary}\n<div class=\"row g-4 homework-card-grid\">{items}</div>\n<div class=\"mt-4\">{pager}</div>",
                'itemView' => '_card',
                'viewParams' => [
                    'compact' => false,
                    'showDelete' => true,
                ],
            ]) ?>
        <?php endif; ?>

        <?php Pjax::end(); ?>
    </div>
</div>
