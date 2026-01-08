<?php
/** @var $router \App\Service\Router */
?>
<nav>
    <div class="container">
        <a href="<?= $router->generatePath('home-index') ?>" class="logo">
            <?= htmlspecialchars($title) ?>
        </a>
        <ul class="nav-menu">
            <li><a href="<?= $router->generatePath('home-index') ?>" class="active">Home</a></li>
            <li><a href="#">Favorites</a></li>
        </ul>
    </div>
</nav>