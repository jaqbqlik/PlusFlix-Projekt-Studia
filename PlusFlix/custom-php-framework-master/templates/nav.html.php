<?php
/** @var $router \App\Service\Router */
?>
<nav>
    <div class="container">
        <a href="<?= $router->generatePath('home-index') ?>" class="logo">
            <?= htmlspecialchars($title) ?>
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
        </ul>
    </div>
</nav>