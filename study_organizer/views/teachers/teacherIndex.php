<?php
use yii\helpers\Html;

$this->title = 'Manage Teachers';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('<i class="bi bi-plus-lg me-1"></i> Add Teacher', ['create'], ['class'=>'btn btn-success btn-round']) ?>
</div>

<div class="row g-4">
    <?php
    $teachers = $dataProvider->getModels();
    foreach ($teachers as $teacher): ?>
        <div class="col-md-4">
            <div class="card hw-card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= Html::encode($teacher->T_name) ?></h5>
                    <p class="card-text flex-grow-1">
                        Email: <?= Html::encode($teacher->T_email ?? '-') ?>
                    </p>

                    <div class="mt-auto d-flex justify-content-end gap-2">
                        <?= Html::a('<i class="bi bi-pencil"></i>', ['update', 'T_ID'=>$teacher->T_ID], ['class'=>'btn btn-sm btn-outline-secondary']) ?>
                        <?= Html::a('<i class="bi bi-trash"></i>', ['delete', 'T_ID'=>$teacher->T_ID], [
                            'class'=>'btn btn-sm btn-outline-danger',
                            'data'=>['method'=>'post','confirm'=>'Delete this teacher?']
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
