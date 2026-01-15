<?php

/** @var \App\Model\Production $production */
/** @var array $platforms */
/** @var \App\Service\Router $router */

$title = 'PlusFlix';
$bodyClass = 'show';

ob_start(); ?>
    <main>
        <div class="container">
            <div class="detail-page">
                <a href="<?= $router->generatePath('home-index') ?>" class="back-link">
                    Back to Home
                </a>

                <div class="detail-container">
                    <div>
                        <?php
                        $titleText = $production->getTitle() ?? '';
                        $typeDb = strtolower((string)($production->getType() ?? ''));
                        $typeLabel = ($typeDb === 'movie' || $typeDb === 'film') ? 'Movie' : 'Series';

                        $poster = $production->getPosterPath();
                        $poster = $poster ? trim($poster) : '';
                        $posterSrc = $poster !== '' ? $poster : '/images/ostatnieznas.jpg';

                        $platformUi = [
                                'Netflix' => ['class' => 'netflix', 'letter' => 'N', 'label' => 'Netflix'],
                                'Prime Video' => ['class' => 'prime', 'letter' => 'P', 'label' => 'Prime Video'],
                                'Disney+' => ['class' => 'disney', 'letter' => 'D', 'label' => 'Disney+'],
                                'HBO Max' => ['class' => 'hbo', 'letter' => 'H', 'label' => 'HBO Max'],
                                'Apple TV+' => ['class' => 'apple', 'letter' => 'A', 'label' => 'Apple TV+'],
                        ];
                        ?>

                        <img src="<?= htmlspecialchars($posterSrc) ?>"
                             alt="<?= htmlspecialchars($titleText) ?>"
                             class="detail-poster">
                    </div>

                    <div class="detail-content">
                        <div class="detail-header">
                            <h1><?= htmlspecialchars($titleText) ?></h1>
                            <button class="favorite-btn-detail active" type="button">♥</button>
                        </div>

                        <div class="detail-meta">
                            <span><?= htmlspecialchars($typeLabel) ?></span>
                            <span><?= htmlspecialchars((string)($production->getReleaseYear() ?? '')) ?></span>
                            <span>-</span>
                        </div>

                        <div class="platforms-section">
                            <h3>Available on</h3>
                            <div class="platform-badges">
                                <?php foreach ($platforms as $p): ?>
                                    <?php
                                    $name = $p['name'] ?? '';
                                    $isAvailable = (int)($p['is_available'] ?? 0) === 1;

                                    $ui = $platformUi[$name] ?? [
                                            'class' => 'netflix',
                                            'letter' => strtoupper(substr($name, 0, 1)),
                                            'label' => $name,
                                    ];

                                    $inactiveClass = $isAvailable ? '' : ' inactive';
                                    ?>

                                    <div class="platform-badge <?= htmlspecialchars($ui['class']) ?><?= $inactiveClass ?>">
                                        <span><?= htmlspecialchars($ui['letter']) ?></span>
                                        <?= htmlspecialchars($ui['label']) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="overview-section">
                            <h3>Overview</h3>
                            <p><?= nl2br(htmlspecialchars($production->getDescription() ?? '')) ?></p>
                        </div>

                        <div class="info-grid">
                            <div class="info-item">
                                <h3>Cast</h3>
                                <p>-</p>
                            </div>
                            <div class="info-item">
                                <h3>Genres</h3>
                                <p><?= htmlspecialchars($production->getGenre() ?? '') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.querySelector('.favorite-btn-detail').addEventListener('click', function() {
            if (this.classList.contains('active')) {
                this.classList.remove('active');
                this.innerHTML = '♡';
            } else {
                this.classList.add('active');
                this.innerHTML = '♥';
            }
        });
    </script>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
