<?php

/** @var yii\web\View $this */
/** @var app\models\Homework[] $homeworks */

use yii\helpers\Html;

$this->title = 'StudyOrganizer';

$isGuest = Yii::$app->user->isGuest;
$isAdmin = !$isGuest && Yii::$app->user->identity->U_role === 'admin';

$totalTasks = count($homeworks);
$doneTasks = count(array_filter($homeworks, static function ($task) {
    return (int) $task->H_is_done === 1;
}));
$openTasks = $totalTasks - $doneTasks;
$overdueTasks = count(array_filter($homeworks, static function ($task) {
    return (int) $task->H_is_done === 0 && strtotime($task->H_due_date) < strtotime('today');
}));
?>

<div class="site-index">
    <div class="p-5 mb-4 bg-white border rounded-4 shadow-sm">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="badge text-bg-primary mb-3">Study organizer for everyday school work</span>
                <h1 class="display-5 fw-semibold mb-3">Keep homework, subjects, and teachers in one place.</h1>
                <p class="lead text-muted mb-0">
                    Plan upcoming work, mark tasks as done, and keep the most important information easy to find.
                </p>
            </div>
            <div class="col-lg-4">
                <div class="d-grid gap-2">
                    <?php if ($isGuest): ?>
                        <?= Html::a('Login', ['/site/login'], ['class' => 'btn btn-primary btn-lg']) ?>
                        <?= Html::a('Create account', ['/site/register'], ['class' => 'btn btn-outline-primary btn-lg']) ?>
                    <?php else: ?>
                        <?= Html::a('Add homework', ['/homework/create'], ['class' => 'btn btn-primary btn-lg']) ?>
                        <?= Html::a('Manage subjects', ['/subjects/index'], ['class' => 'btn btn-outline-secondary btn-lg']) ?>
                        <?= Html::a('Manage teachers', ['/teachers/index'], ['class' => 'btn btn-outline-secondary btn-lg']) ?>
                        <?php if ($isAdmin): ?>
                            <?= Html::a('Manage users', ['/users/index'], ['class' => 'btn btn-outline-dark btn-lg']) ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($isGuest): ?>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="h5">Track homework</h2>
                        <p class="text-muted mb-0">See upcoming due dates at a glance and keep completed work out of the way.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="h5">Organize subjects</h2>
                        <p class="text-muted mb-0">Connect every assignment to the correct subject so your dashboard stays clear.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="h5">Manage teachers</h2>
                        <p class="text-muted mb-0">Keep subject and teacher information tidy so adding new homework stays fast.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small mb-2">Total homework</div>
                        <div class="display-6 fw-semibold"><?= $totalTasks ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small mb-2">Open tasks</div>
                        <div class="display-6 fw-semibold"><?= $openTasks ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small mb-2">Overdue</div>
                        <div class="display-6 fw-semibold"><?= $overdueTasks ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
            <div>
                <h2 class="h3 mb-1">Upcoming homework</h2>
                <p class="text-muted mb-0">Sorted by status first, then due date.</p>
            </div>
            <div class="d-flex gap-2">
                <?= Html::a('All homework', ['/homework/index'], ['class' => 'btn btn-outline-secondary']) ?>
                <?= Html::a('Add homework', ['/homework/create'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php if (empty($homeworks)): ?>
            <div class="alert alert-info mb-0">
                No homework has been added yet. Start by
                <?= Html::a('creating a subject', ['/subjects/create']) ?>
                and then add your first homework item.
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($homeworks as $task): ?>
                    <?php
                    $dueTimestamp = strtotime($task->H_due_date);
                    $isDone = (int) $task->H_is_done === 1;
                    $isOverdue = !$isDone && $dueTimestamp < strtotime('today');
                    $cardClass = $isDone ? 'border-success' : ($isOverdue ? 'border-danger' : 'border-light');
                    ?>
                    <div class="col-lg-6">
                        <div class="card h-100 shadow-sm <?= $cardClass ?>">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                    <div>
                                        <span class="badge text-bg-light mb-2">
                                            <?= Html::encode($task->subject ? $task->subject->S_name : 'No subject') ?>
                                        </span>
                                        <h3 class="h5 mb-1"><?= Html::encode($task->H_title) ?></h3>
                                        <div class="text-muted small">
                                            Due <?= Yii::$app->formatter->asDate($task->H_due_date) ?>
                                        </div>
                                    </div>
                                    <?php if ($isDone): ?>
                                        <span class="badge text-bg-success">Done</span>
                                    <?php elseif ($isOverdue): ?>
                                        <span class="badge text-bg-danger">Overdue</span>
                                    <?php else: ?>
                                        <span class="badge text-bg-warning">Open</span>
                                    <?php endif; ?>
                                </div>

                                <p class="text-muted flex-grow-1 mb-4">
                                    <?= Html::encode($task->H_description ?: 'No description added yet.') ?>
                                </p>

                                <div class="d-flex flex-wrap gap-2">
                                    <?= Html::a('View', ['/homework/view', 'H_ID' => $task->H_ID], ['class' => 'btn btn-outline-secondary btn-sm']) ?>
                                    <?= Html::a('Edit', ['/homework/update', 'H_ID' => $task->H_ID], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                                    <?php if (!$isDone): ?>
                                        <?= Html::a('Mark done', ['/homework/done', 'H_ID' => $task->H_ID], [
                                            'class' => 'btn btn-success btn-sm',
                                            'data' => [
                                                'method' => 'post',
                                                'confirm' => 'Mark this homework as done?',
                                            ],
                                        ]) ?>
                                    <?php endif; ?>
                                    <?= Html::a('Delete', ['/homework/delete', 'H_ID' => $task->H_ID], [
                                        'class' => 'btn btn-outline-danger btn-sm',
                                        'data' => [
                                            'method' => 'post',
                                            'confirm' => 'Delete this homework item?',
                                        ],
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
