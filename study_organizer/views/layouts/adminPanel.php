<?php
use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/admin.css') ?>">
    </head>
    <body>
    <?php $this->beginBody() ?>

    <?php
    NavBar::begin([
        'brandLabel' => 'StudyOrganizer Admin',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar navbar-expand-lg navbar-dark bg-primary'],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-lg-0'],
        'items' => [
            ['label' => 'Teachers', 'url' => ['/teacher/index']],
            ['label' => 'Subjects', 'url' => ['/subject/index']],
        ],
    ]);

    NavBar::end();
    ?>

    <div class="container mt-4">
        <?= $content ?>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>