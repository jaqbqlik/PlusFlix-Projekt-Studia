<?php

/** @var \App\Model\Production[] $productions */
/** @var array $availablePlatformsMap */
/** @var array $favoriteMap */
/** @var \App\Service\Router $router */

$title = 'My Favorites';
$bodyClass = 'favorites';

ob_start(); ?>
    <div class="search-section">
        <div class="container">
            <div class="search-bar">
                <input type="text" id="search-input" placeholder="Search in favorites." autocomplete="off">
                <ul id="search-suggestions" class="search-suggestions"></ul>
            </div>
        </div>
    </div>

    <main>
        <div class="container">
            <h2 class="section-title">❤️ My Favorites</h2>

            <?php if (!$productions): ?>
                <p>No favorites yet.</p>
            <?php else: ?>
                <div class="production-grid">
                    <?php foreach ($productions as $production): ?>
                        <?php
                        $id = (int)$production->getId();
                        $titleText = $production->getTitle() ?? '';

                        $typeDb = strtolower((string)($production->getType() ?? ''));
                        $typeLabel = ($typeDb === 'movie' || $typeDb === 'film') ? 'Movie' : 'Series';

                        $poster = $production->getPosterPath();
                        $poster = $poster ? trim($poster) : '';
                        $posterSrc = $poster !== '' ? $poster : '/images/placeholder-user.jpg';

                        $availableNames = $availablePlatformsMap[$id] ?? [];

                        $platformUi = [
                                'Netflix' => ['class' => 'netflix', 'letter' => 'N'],
                                'Prime Video' => ['class' => 'prime', 'letter' => 'P'],
                                'Disney+' => ['class' => 'disney', 'letter' => 'D'],
                                'HBO Max' => ['class' => 'hbo', 'letter' => 'H'],
                                'Apple TV+' => ['class' => 'apple', 'letter' => 'A'],
                        ];

                        $isFav = isset($favoriteMap[$id]);
                        ?>

                        <a href="<?= $router->generatePath('home-show', ['id' => $id]) ?>" class="production-card">
                            <button
                                    class="favorite-btn-detail smoll-fav-btn <?= $isFav ? 'active' : '' ?>"
                                    data-production-id="<?= $id ?>"
                                    type="button">
                                <?= $isFav ? '♥' : '♡' ?>
                            </button>

                            <img src="<?= htmlspecialchars($posterSrc) ?>"
                                 alt="<?= htmlspecialchars($titleText) ?>"
                                 class="poster">

                            <div class="card-content">
                                <h3 class="card-title"><?= htmlspecialchars($titleText) ?></h3>
                                <div class="card-meta">
                                    <span><?= htmlspecialchars($typeLabel) ?></span>
                                </div>

                                <div class="platforms">
                                    <?php foreach ($availableNames as $pName): ?>
                                        <?php
                                        $ui = $platformUi[$pName] ?? [
                                                'class' => 'netflix',
                                                'letter' => strtoupper(substr($pName, 0, 1)),
                                        ];
                                        ?>
                                        <div class="platform-icon <?= htmlspecialchars($ui['class']) ?>">
                                            <?= htmlspecialchars($ui['letter']) ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
