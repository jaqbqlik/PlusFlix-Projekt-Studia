<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/dist/style.min.css">
    <title><?= $title ?? 'PlusFlix' ?></title>
</head>
<body <?= isset($bodyClass) ? "class='$bodyClass'" : '' ?>>
<?php require(__DIR__ . DIRECTORY_SEPARATOR . 'nav.html.php') ?>
<?= $main ?? null ?>
<footer>
    <div class="container">
        <p>&copy; <?= date('Y') ?> PlusFlix. Find where to watch your favorite content.</p>
        <ul class="footer-links">
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Privacy</a></li>
        </ul>
    </div>
</footer>
<script src="/assets/js/app.js"></script>
</body>
</html>