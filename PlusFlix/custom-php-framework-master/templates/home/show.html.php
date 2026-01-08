<?php

/** @var \App\Service\Router $router */

$title = 'PlusFlix';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stranger Things - <?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/dist/style.min.css">
</head>
<body>
<nav>
    <div class="container">
        <a href="<?= $router->generatePath('home-index') ?>" class="logo">
            <?= htmlspecialchars($title) ?>
        </a>
        <ul class="nav-menu">
            <li><a href="<?= $router->generatePath('home-index') ?>">Home</a></li>
            <li><a href="#">Favorites</a></li>
        </ul>
    </div>
</nav>

<main>

</main>

<footer>
    <div class="container">
        <p>&copy; 2025 <?= htmlspecialchars($title) ?>. Find where to watch your favorite content.</p>
        <ul class="footer-links">
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Privacy</a></li>
        </ul>
    </div>
</footer>
</body>
</html>