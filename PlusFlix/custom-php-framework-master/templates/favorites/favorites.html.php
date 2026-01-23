<?php
/** @var \App\Model\Production[] $productions */
/** @var \App\Service\Router $router */

$title = 'My Favorites';
$bodyClass = 'favorites';

ob_start(); ?>

    <main>
        <div class="container">
            <h1>❤️ My Favorites</h1>

            <?php if (!$productions): ?>
                <p>No favorites yet.</p>
            <?php else: ?>
                <div class="production-grid">
                    <?php foreach ($productions as $p): ?>
                        <a href="<?= $router->generatePath('home-show', ['id' => $p->getId()]) ?>"
                           class="production-card">
                            <img src="<?= htmlspecialchars($p->getPosterPath()) ?>" class="poster">
                            <h3><?= htmlspecialchars($p->getTitle()) ?></h3>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

<?php
$main = ob_get_clean();
include __DIR__ . '/../base.html.php';

