<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

/** @var app\models\Homework $model */
/** @var bool $compact */
/** @var bool $showDelete */

$compact = $compact ?? false;
$showDelete = $showDelete ?? false;

$cardClass = 'homework-card-neutral';

if ($model->isDone()) {
    $cardClass = 'homework-card-done';
} elseif ($model->getDueCssClass() === 'due-red') {
    $cardClass = 'homework-card-red';
} elseif ($model->getDueCssClass() === 'due-yellow') {
    $cardClass = 'homework-card-yellow';
} elseif ($model->getDueCssClass() === 'due-blue') {
    $cardClass = 'homework-card-blue';
}

$description = trim((string) $model->H_description);

if ($description === '') {
    $description = 'No description';
}

$description = StringHelper::truncateWords($description, $compact ? 12 : 24, '...');
?>

<div class="card h-100 homework-card <?= $cardClass ?>">
    <div class="card-body d-flex flex-column">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
            <div class="min-w-0">
                <div class="homework-card-subject mb-2">
                    <?= Html::encode($model->subject ? $model->subject->S_name : '-') ?>
                </div>
                <h3 class="card-title h5 mb-0"><?= Html::encode($model->H_title) ?></h3>
            </div>
            <span class="due-box <?= $model->getDueCssClass() ?>">
                <?= Yii::$app->formatter->asDate($model->H_due_date, 'php:d.m.Y') ?>
            </span>
        </div>

        <div class="d-flex flex-wrap gap-2 mb-3">
            <span class="status-box <?= $model->isDone() ? 'status-done' : 'status-open' ?>">
                <?= $model->isDone() ? 'Done' : 'Open' ?>
            </span>
        </div>

        <p class="card-text text-secondary flex-grow-1 mb-4"><?= Html::encode($description) ?></p>

        <div class="d-flex flex-wrap gap-2 mt-auto">
            <?= Html::a('View', ['/homework/view', 'H_ID' => $model->H_ID], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
            <?php if ($model->isEditable()): ?>
                <?= Html::a('Edit', ['/homework/update', 'H_ID' => $model->H_ID], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                <?= Html::a('Done', ['/homework/done', 'H_ID' => $model->H_ID], [
                    'class' => 'btn btn-sm btn-outline-success',
                    'data' => [
                        'method' => 'post',
                        'confirm' => 'Mark this homework as done?',
                    ],
                ]) ?>
                <?php if ($showDelete): ?>
                    <?= Html::a('Delete', ['/homework/delete', 'H_ID' => $model->H_ID], [
                        'class' => 'btn btn-sm btn-outline-danger',
                        'data' => [
                            'method' => 'post',
                            'confirm' => 'Delete this homework item?',
                        ],
                    ]) ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
