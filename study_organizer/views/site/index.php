<?php

/** @var yii\web\View $this */
/** @var app\models\Homework[] $homeworks */

use yii\helpers\Html;

$this->title = 'StudyOrganizer';

$isGuest = Yii::$app->user->isGuest;
$isAdmin = !$isGuest && Yii::$app->user->identity->isAdmin();
?>

<div class="site-index">
    <div class="content-box hero-box">
        <div class="section-header">
            <h1 class="mb-0"><i class="bi bi-book-half me-2"></i>StudyOrganizer</h1>
            <div class="simple-links">
                <?php if ($isGuest): ?>
                    <?= Html::a('Login', ['/site/login'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Register', ['/site/register'], ['class' => 'btn btn-outline-secondary']) ?>
                <?php else: ?>
                    <?= Html::a('Create homework', ['/homework/create'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Show all homework', ['/homework/index'], ['class' => 'btn btn-outline-secondary']) ?>
                    <?php if ($isAdmin): ?>
                        <?= Html::a('Manage subjects', ['/subjects/index'], ['class' => 'btn btn-outline-secondary']) ?>
                        <?= Html::a('Manage teachers', ['/teachers/index'], ['class' => 'btn btn-outline-secondary']) ?>
                        <?= Html::a('Manage users', ['/users/index'], ['class' => 'btn btn-outline-secondary']) ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (!$isGuest): ?>
        <div class="content-box">
            <h2>Homework</h2>

            <?php if (empty($homeworks)): ?>
                <div class="empty-state">
                    <?= Html::a('Create homework', ['/homework/create'], ['class' => 'btn btn-primary']) ?>
                    <?php if ($isAdmin): ?>
                        <?= Html::a('Create subject', ['/subjects/create'], ['class' => 'btn btn-outline-secondary']) ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="row g-4 homework-card-grid">
                    <?php foreach (array_slice($homeworks, 0, 6) as $task): ?>
                        <div class="col-md-6 col-xl-4">
                            <?= $this->render('/homework/_card', [
                                'model' => $task,
                                'compact' => true,
                                'showDelete' => false,
                            ]) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
