<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'StudyOrganizer Dashboard';

// Homework-CSS einbinden
$this->registerCssFile('@web/css/styleSheetHomework.css', [
        'depends' => [\yii\bootstrap5\BootstrapAsset::class],
]);

$user = Yii::$app->user->identity;
$isGuest = Yii::$app->user->isGuest;
$isAdmin = !$isGuest && $user->U_role === 'admin';
?>

<?= Html::a(
        '<i class="bi bi-plus-lg me-2"></i> Add Homework',
        ['/homework/create'],
        ['class' => 'btn btn-primary']
) ?>
    <div class="container mt-5">

        <div class="text-center mb-5">
            <h1 class="display-4">📚 StudyOrganizer</h1>
            <p class="lead">Organize your homework and subjects easily.</p>
        </div>

        <?php if ($isGuest): ?>

            <div class="alert alert-info text-center">
                Please <?= Html::a('Login', ['/site/login'], ['class' => 'btn btn-primary']) ?>
                or <?= Html::a('Register', ['/site/register'], ['class' => 'btn btn-success']) ?>
                to manage your homework.
            </div>

        <?php endif; ?>


        <div class="row">

            <?php $homework = $homework ?? [];
            foreach ($homework as $task): ?>

                <?php

                $due = strtotime($task->H_due_date);
                $now = time();
                $diff = ($due - $now) / 86400;

                $color = "";

                if ($diff < 1) {
                    $color = "danger";
                } elseif ($diff < 7) {
                    $color = "warning";
                } elseif ($diff < 14) {
                    $color = "primary";
                }

                if ($task->H_is_done) {
                    $color = "success";
                }

                ?>

                <div class="col-md-4 mb-4">

                    <div class="card border-<?= $color ?> shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">
                                <?= Html::encode($task->H_title) ?>
                            </h5>

                            <h6 class="card-subtitle mb-2 text-muted">
                                <?= Html::encode($task->hS->S_name ?? 'No Subject') ?>
                            </h6>

                            <p class="card-text">
                                <?= Html::encode($task->H_description) ?>
                            </p>

                            <p>
                                <strong>Due:</strong>
                                <?= Html::encode($task->H_due_date) ?>
                            </p>

                            <?php if ($task->H_is_done): ?>

                                <span class="badge bg-success">Completed</span>

                            <?php endif; ?>


                            <div class="mt-3">

                                <?php if (!$isGuest && ($isAdmin || (isset($task->H_U_ID) && $task->H_U_ID == $user->U_ID))): ?>

                                    <?=
                                    Html::a('Edit',
                                            ['/homework/update', 'H_ID' => $task->H_ID],
                                            ['class' => 'btn btn-sm btn-warning']
                                    )
                                    ?>

                                <?php endif; ?>


                                <?php if (!$isGuest && ($isAdmin || (isset($task->H_U_ID) && $task->H_U_ID == $user->U_ID))): ?>

                                    <?=
                                    Html::a('Delete',
                                            ['/homework/delete', 'H_ID' => $task->H_ID],
                                            [
                                                    'class' => 'btn btn-sm btn-danger',
                                                    'data' => [
                                                            'method' => 'post',
                                                            'confirm' => 'Delete this task?'
                                                    ]
                                            ]
                                    )
                                    ?>

                                <?php endif; ?>


                                <?php if (!$task->H_is_done && !$isGuest && ($isAdmin || (isset($task->H_U_ID) && $task->H_U_ID == $user->U_ID))): ?>

                                    <?=
                                    Html::a('Mark Done',
                                            ['/homework/done', 'H_ID' => $task->H_ID],
                                            ['class' => 'btn btn-sm btn-success']
                                    )
                                    ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


<?php
$totalTasks = count($homework);

$doneTasks = 0;
foreach ($homework as $task) {
    if ($task->H_is_done) {
        $doneTasks++;
    }
}
?>

<?php
$totalTasks = count($homework);
$doneTasks = count(array_filter($homework, fn($task) => $task->H_is_done));
?>
    <div class="container" style="margin-top: -50px;">

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card hw-card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-primary text-white shadow-sm me-3">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Gesamt</h6>
                            <span class="h4 fw-bold"><?= $totalTasks = count($homework);
                                $totalTasks ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card hw-card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-success text-white shadow-sm me-3">
                            <i class="bi bi-check-all"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Erledigt</h6>
                            <span class="h4 fw-bold"><?= $doneTasks ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card hw-card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-warning text-dark shadow-sm me-3">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Offen</h6>
                            <span class="h4 fw-bold"><?= $totalTasks - $doneTasks ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($isGuest): ?>
            <div class="card hw-card bg-info text-white p-5 text-center mb-5 border-0">
                <h2 class="fw-bold">Starte jetzt deine Organisation!</h2>
                <p class="mb-4">Melde dich an, um unbegrenzt Aufgaben und Fächer zu verwalten.</p>
                <div>
                    <?= Html::a('Login', ['/site/login'], ['class' => 'btn btn-light btn-round me-2']) ?>
                    <?= Html::a('Registrieren', ['/site/register'], ['class' => 'btn btn-outline-light btn-round']) ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">Deine aktuellen Aufgaben</h3>
            <?php if (!$isGuest): ?>
                <?= Html::a('<i class="bi bi-plus-lg me-1"></i> Neu', ['/homework/create'], ['class' => 'btn btn-primary btn-round shadow-sm']) ?>
            <?php endif; ?>
        </div>

        <div class="row g-4">

            <?php foreach ($homework as $task):

                $due = strtotime($task->H_due_date);
                $diff = ($due - time()) / 86400;

                // Standardfarbe
                $color = "primary";

                // nach Fälligkeit setzen
                if ($task->H_is_done) {
                    $color = "success";
                } elseif ($diff < 1) {
                    $color = "danger";
                } elseif ($diff < 7) {
                    $color = "warning";
                } elseif ($diff < 14) {
                    $color = "primary";
                }


                $due = strtotime($task->H_due_date);
                $diff = ($due - time()) / 86400;

                $color = $task->H_is_done ? "success" :
                        ($diff < 1 ? "danger" :
                                ($diff < 7 ? "warning" : "primary"));
                ?>

                <div class="col-md-4">

                    <div class="card hw-card h-100">

                        <div class="card-body d-flex flex-column">

                            <div class="d-flex justify-content-between mb-2">

                <span class="badge bg-<?= $color ?> bg-opacity-10 text-<?= $color ?>">
                    <?= Html::encode($task->hS->S_name ?? 'Allgemein') ?>
                </span>

                                <?php if ($task->H_is_done): ?>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                <?php endif; ?>

                            </div>

                            <h5 class="card-title">
                                <?= Html::encode($task->H_title) ?>
                            </h5>

                            <p class="text-muted flex-grow-1">
                                <?= Html::encode($task->H_description) ?>
                            </p>

                            <small class="text-muted mb-3">
                                <i class="bi bi-calendar-event"></i>
                                <?= date('d.m.Y', $due) ?>
                            </small>

                            <div class="btn-group">

                                <?= Html::a(
                                        '<i class="bi bi-pencil"></i>',
                                        ['/homework/update', 'H_ID' => $task->H_ID],
                                        ['class' => 'btn btn-sm btn-outline-secondary']
                                ) ?>

                                <?= Html::a(
                                        '<i class="bi bi-trash"></i>',
                                        ['/homework/delete', 'H_ID' => $task->H_ID],
                                        [
                                                'class' => 'btn btn-sm btn-outline-danger',
                                                'data' => [
                                                        'method' => 'post',
                                                        'confirm' => 'Delete task?'
                                                ]
                                        ]
                                ) ?>

                                <?php if (!$task->H_is_done): ?>
                                    <?= Html::a(
                                            '<i class="bi bi-check-lg"></i>',
                                            ['/homework/done', 'H_ID' => $task->H_ID],
                                            ['class' => 'btn btn-sm btn-outline-success']
                                    ) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php
