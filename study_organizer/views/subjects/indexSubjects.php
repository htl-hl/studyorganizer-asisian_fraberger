<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Manage Subjects';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('<i class="bi bi-plus-lg me-1"></i> Add Subject', ['create'], ['class'=>'btn btn-primary btn-round']) ?>
</div>

<div class="row g-4">
    <?php foreach ($subjects as $subject): ?>
        <div class="col-md-4">
            <div class="card hw-card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= Html::encode($subject->S_name) ?></h5>
                    <p class="card-text flex-grow-1">
                        Teacher: <?= Html::encode($subject->teacher->T_name ?? '-') ?>
                    </p>

                    <div class="mt-auto d-flex justify-content-end gap-2">
                        <?= Html::a('<i class="bi bi-pencil"></i>', ['update', 'S_ID'=>$subject->S_ID], ['class'=>'btn btn-sm btn-outline-secondary']) ?>
                        <?= Html::a('<i class="bi bi-trash"></i>', ['delete', 'S_ID'=>$subject->S_ID], [
                            'class'=>'btn btn-sm btn-outline-danger',
                            'data'=>['method'=>'post','confirm'=>'Delete this subject?']
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
