<?php
/** @var $router \App\Service\Router */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isAdminLoggedIn = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
$adminUsername = $_SESSION['admin_username'] ?? null;
?>
<nav>
    <div class="container">
        <a href="<?= $router->generatePath('home-index') ?>" class="logo">
            <?= htmlspecialchars($title ?? 'PlusFlix') ?>
        </a>
        <ul class="nav-menu">
            <li>
                <a href="<?= $router->generatePath('home-index') ?>" class="active">
                    <span class="nav-text">Home</span>
                    <span class="nav-icon">🏠</span>
                </a>
            </li>
            <li>
                <a href="<?= $router->generatePath('production-add') ?>">
                    <span class="nav-text">+ Add production</span>
                    <span class="nav-icon">+</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="nav-text">Favorites</span>
                    <span class="nav-icon">♥</span>
                </a>
            </li>
            <?php if ($isAdminLoggedIn): ?> <!-- Czy admin jest zalogowany? (╭ರ_•́) -->
                <li>
                    <a href="<?= $router->generatePath('admin-logout') ?>" class="logout-btn">
                        <span class="nav-text">Wyloguj</span>
                        <span class="nav-icon">🚪</span>
                    </a>
                </li>
            <?php else: ?>
                <li class="admin-login">
                    <a href="<?= $router->generatePath('admin-login') ?>">
                        <span class="nav-text">Admin</span>
                        <span class="nav-icon">🔐</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>