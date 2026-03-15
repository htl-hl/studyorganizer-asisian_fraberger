<?php

/** @var yii\web\View $this */
/** @var app\models\Homework[] $homeworks */

use yii\helpers\Html;

$this->title = 'StudyOrganizer';

$isGuest = Yii::$app->user->isGuest;
$isAdmin = !$isGuest && Yii::$app->user->identity->isAdmin();
?>

<div class="site-index">
    <div class="content-box">
        <h1>StudyOrganizer</h1>
        <?php if ($isGuest): ?>
            <p>
                <?= Html::a('Login', ['/site/login']) ?>
                |
                <?= Html::a('Register', ['/site/register']) ?>
            </p>
        <?php else: ?>
            <p class="simple-links mb-0">
                <?= Html::a('Create homework', ['/homework/create']) ?>
                <?= Html::a('Show all homework', ['/homework/index']) ?>
                <?php if ($isAdmin): ?>
                    <?= Html::a('Manage subjects', ['/subjects/index']) ?>
                    <?= Html::a('Manage teachers', ['/teachers/index']) ?>
                    <?= Html::a('Manage users', ['/users/index']) ?>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>

    <?php if (!$isGuest): ?>
        <div class="content-box">
            <h2>Homework</h2>

            <?php if (empty($homeworks)): ?>
                <p class="mb-0">
                    <?= Html::a('Create homework', ['/homework/create']) ?>
                    <?php if ($isAdmin): ?>
                        |
                        <?= Html::a('Create subject', ['/subjects/create']) ?>
                    <?php endif; ?>
                </p>
            <?php else: ?>
                <table class="table table-bordered home-table mb-0">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Due date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (array_slice($homeworks, 0, 6) as $task): ?>
                        <tr class="<?= $task->getDueRowClass() ?>">
                            <td><?= Html::encode($task->H_title) ?></td>
                            <td><?= Html::encode($task->subject ? $task->subject->S_name : '-') ?></td>
                            <td>
                                <span class="due-box <?= $task->getDueCssClass() ?>">
                                    <?= Yii::$app->formatter->asDate($task->H_due_date, 'php:d.m.Y') ?>
                                </span>
                            </td>
                            <td>
                                <span class="status-box <?= $task->isDone() ? 'status-done' : 'status-open' ?>">
                                    <?= $task->isDone() ? 'Done' : 'Open' ?>
                                </span>
                            </td>
                            <td class="actions-cell">
                                <?= Html::a('View', ['/homework/view', 'H_ID' => $task->H_ID]) ?>
                                <?php if ($task->isEditable()): ?>
                                    <?= Html::a('Edit', ['/homework/update', 'H_ID' => $task->H_ID]) ?>
                                    <?= Html::a('Done', ['/homework/done', 'H_ID' => $task->H_ID], [
                                        'data' => [
                                            'method' => 'post',
                                            'confirm' => 'Mark this homework as done?',
                                        ],
                                    ]) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
