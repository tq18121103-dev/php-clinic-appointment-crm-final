<?php
$isPublicPage = ($_SERVER['REQUEST_URI'] === '/public-patients/create' || strpos($_SERVER['REQUEST_URI'], '/public-') === 0);
$isAuthPage = ($_SERVER['REQUEST_URI'] === '/login');
$showSidebar = is_logged_in() && !$isPublicPage && !$isAuthPage;
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= e($title ?? 'Clinic Appointment CRM') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

<?php if ($showSidebar): ?>
    <div class="app-layout">
        <?php partial('nav'); ?>
        <main class="main-wrapper">
            <?php partial('flash'); ?>
            <?= $content ?>
        </main>
    </div>
<?php else: ?>
    <div class="auth-layout">
        <main style="width: 100%; display: flex; justify-content: center; align-items: center; flex-direction: column;">
            <?php partial('flash'); ?>
            <?= $content ?>
        </main>
    </div>
<?php endif; ?>

</body>
</html>