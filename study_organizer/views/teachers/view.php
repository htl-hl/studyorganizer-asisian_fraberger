<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Teachers $model */

$this->title = $model->T_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teachers'), 'url' => ['teachers/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="teachers-view">
    <div class="content-box">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'T_ID' => $model->T_ID], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Back to list', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </p>

        <?php if (empty($model->subjects)): ?>
            <div class="alert alert-warning">
                This teacher currently has no subject assigned. Add a subject to match the assignment requirements.
            </div>
        <?php endif; ?>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'T_ID',
                'T_name',
                [
                    'label' => 'Status',
                    'format' => 'raw',
                    'value' => Html::tag(
                        'span',
                        (int) $model->T_is_active === 1 ? 'Active' : 'Inactive',
                        ['class' => 'status-box ' . ((int) $model->T_is_active === 1 ? 'status-done' : 'status-inactive')]
                    ),
                ],
                [
                    'label' => 'Subjects',
                    'value' => empty($model->subjects)
                        ? 'No subjects assigned'
                        : implode(', ', array_map(static function ($subject) {
                            return $subject->S_name;
                        }, $model->subjects)),
                ],
            ],
        ]) ?>
    </div>
</div>
