<?php
/** @var yii\web\View $this */
/** @var app\models\Homework[] $homeworks */

$this->title = 'Dashboard';
?>

<div class="container mt-4">

    <!-- Titel -->
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-5">📊 StudyOrganizer Dashboard</h1>
            <p class="text-muted">Übersicht deiner Hausübungen</p>
        </div>
    </div>

    <!-- Karten Übersicht -->
    <div class="row mb-4">

        <!-- Homework Card -->
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5 class="card-title">📚 Homework</h5>
                    <p class="card-text fs-4">
                        <?= count($homeworks) ?> Einträge
                    </p>
                    <a href="index.php?r=homework/index" class="btn btn-light btn-sm">
                        Anzeigen
                    </a>
                </div>
            </div>
        </div>

        <!-- Neue Homework -->
        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5 class="card-title">➕ Neue Homework</h5>
                    <p class="card-text">
                        Neue Hausübung hinzufügen
                    </p>
                    <a href="index.php?r=homework/create" class="btn btn-light btn-sm">
                        Erstellen
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabelle -->
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            📋 Letzte Homework
        </div>

        <div class="card-body">

            <table class="table table-hover">

                <thead>
                <tr>
                    <th>ID</th>
                    <th>Titel</th>
                    <th>Aktionen</th>
                </tr>
                </thead>

                <tbody>

                <?php foreach ($homeworks as $hw): ?>
                    <tr>
                        <td><?= $hw->id ?></td>

                        <td>
                            <strong><?= $hw->title ?></strong>
                        </td>

                        <td>

                            <a href="index.php?r=homework/view&id=<?= $hw->id ?>"
                               class="btn btn-sm btn-primary">
                                👁 View
                            </a>

                            <a href="index.php?r=homework/update&id=<?= $hw->id ?>"
                               class="btn btn-sm btn-warning">
                                ✏ Edit
                            </a>

                            <a href="index.php?r=homework/delete&id=<?= $hw->id ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Wirklich löschen?')">
                                🗑 Delete
                            </a>

                        </td>

                    </tr>
                <?php endforeach; ?>

                </tbody>

            </table>

        </div>
    </div>

</div>