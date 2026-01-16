<?php

/** @var \App\Model\Production[] $productions */
/** @var array $availablePlatformsMap */
/** @var \App\Service\Router $router */

$title = 'PlusFlix';
$bodyClass = 'index';

ob_start(); ?>
    <div class="search-section">
        <div class="container">
            <div class="search-bar">
                <input type="text" id="search-input" placeholder="Search for movies or series...">
                <ul id="search-suggestions" class="search-suggestions"></ul>
            </div>
        </div>
    </div>

    <main>
        <div class="container">
            <h2 class="section-title">Popular Movies & Series</h2>

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

                    // Dostępne platformy dla tej produkcji
                    $availableNames = $availablePlatformsMap[$id] ?? [];

                    // mapowanie nazwy z DB -> klasa css + literka
                    $platformUi = [
                            'Netflix' => ['class' => 'netflix', 'letter' => 'N'],
                            'Prime Video' => ['class' => 'prime', 'letter' => 'P'],
                            'Disney+' => ['class' => 'disney', 'letter' => 'D'],
                            'HBO Max' => ['class' => 'hbo', 'letter' => 'H'],
                            'Apple TV+' => ['class' => 'apple', 'letter' => 'A'],
                    ];
                    ?>

                    <a href="<?= $router->generatePath('home-show', ['id' => $id]) ?>" class="production-card">
                        <button class="favorite-btn-detail smoll-fav-btn" type="button">♡</button>

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
        </div>
    </main>

    <script>
        // Search functionality - ZOSTAJE TU
        const searchInput = document.getElementById('search-input');
        const suggestions = document.getElementById('search-suggestions');

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length === 0) {
                suggestions.innerHTML = '';
                return;
            }

            fetch(`/index.php?action=home-search&q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    suggestions.innerHTML = '';
                    data.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = item.title + ' (' + (item.type === 'film' ? 'Movie' : 'Series') + ')';
                        li.addEventListener('click', () => {
                            window.location.href = `/index.php?action=home-show&id=${item.id}`;
                        });
                        suggestions.appendChild(li);
                    });
                });
        });

        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target)) {
                suggestions.innerHTML = '';
            }
        });
    </script>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';