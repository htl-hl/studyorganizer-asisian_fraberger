<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag([
    'name' => 'viewport',
    'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no',
]);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/x-icon',
    'href' => Yii::getAlias('@web/favicon.ico'),
]);

$isGuest = Yii::$app->user->isGuest;
$isAdmin = !$isGuest && Yii::$app->user->identity->isAdmin();

$navItems = [
    ['label' => 'Home', 'url' => ['/site/index']],
];

if (!$isGuest) {
    $navItems[] = ['label' => 'Homework', 'url' => ['/homework/index']];

    if ($isAdmin) {
        $navItems[] = ['label' => 'Subjects', 'url' => ['/subjects/index']];
        $navItems[] = ['label' => 'Teachers', 'url' => ['/teachers/index']];
        $navItems[] = ['label' => 'Users', 'url' => ['/users/index']];
    }
}

$navItems[] = ['label' => 'About', 'url' => ['/site/about']];
$navItems[] = ['label' => 'Contact', 'url' => ['/site/contact']];

if ($isGuest) {
    $navItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    $navItems[] = ['label' => 'Register', 'url' => ['/site/register']];
} else {
    $navItems[] = '<li class="nav-item">'
        . Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->getUsername() . ')',
            ['class' => 'nav-link btn btn-link text-decoration-none logout']
        )
        . Html::endForm()
        . '</li>';
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column min-vh-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar navbar-expand-lg navbar-light bg-white border-bottom'],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto align-items-lg-center'],
        'items' => $navItems,
    ]);
    NavBar::end();
    ?>
</header>

<main class="flex-shrink-0">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif; ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="mt-auto border-top bg-white py-3">
    <div class="container d-flex flex-column flex-md-row justify-content-between small gap-2">
        <span>&copy; StudyOrganizer <?= date('Y') ?></span>
        <span>Simple Yii2 school project</span>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
