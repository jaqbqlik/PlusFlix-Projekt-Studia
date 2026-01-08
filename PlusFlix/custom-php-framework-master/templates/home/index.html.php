<?php

/** @var \App\Model\Home[] $homes */
/** @var \App\Service\Router $router */

$title = 'Post List';
$bodyClass = 'index';

ob_start(); ?>
    <div class="search-section">
        <div class="container">
            <div class="search-bar">
                <input type="text" placeholder="Search for movies or series...">
            </div>
        </div>
    </div>

    <main>
        <div class="container">
            <h2 class="section-title">Popular Movies & Series</h2>

            <div class="production-grid">
                <!-- Stranger Things -->
                <a href="<?= $router->generatePath('home-show') ?>" class="production-card">
                    <button class="favorite-btn active">♥</button>
                    <img src="https://via.placeholder.com/300x450/1a1a2e/e94560?text=Stranger+Things"
                         alt="Stranger Things"
                         class="poster">
                    <div class="card-content">
                        <h3 class="card-title">Stranger Things</h3>
                        <div class="card-meta">
                            <span>Series</span>
                        </div>
                        <div class="platforms">
                            <div class="platform-icon netflix">N</div>
                            <div class="platform-icon prime">P</div>
                            <div class="platform-icon disney">D</div>
                            <div class="platform-icon apple">A</div>
                        </div>
                    </div>
                </a>

                <!-- The Last of Us -->
                <a href="<?= $router->generatePath('home-show') ?>" class="production-card">
                    <button class="favorite-btn active">♥</button>
                    <img src="https://via.placeholder.com/300x450/16213e/0f3460?text=The+Last+of+Us"
                         alt="The Last of Us"
                         class="poster">
                    <div class="card-content">
                        <h3 class="card-title">The Last of Us</h3>
                        <div class="card-meta">
                            <span>Series</span>
                        </div>
                        <div class="platforms">
                            <div class="platform-icon netflix">N</div>
                            <div class="platform-icon prime">P</div>
                            <div class="platform-icon disney">D</div>
                            <div class="platform-icon hbo">H</div>
                        </div>
                    </div>
                </a>

                <!-- Dune -->
                <a href="<?= $router->generatePath('home-show') ?>" class="production-card">
                    <button class="favorite-btn">♡</button>
                    <img src="https://via.placeholder.com/300x450/533483/9b59b6?text=Dune"
                         alt="Dune"
                         class="poster">
                    <div class="card-content">
                        <h3 class="card-title">Dune</h3>
                        <div class="card-meta">
                            <span>Movie</span>
                        </div>
                        <div class="platforms">
                            <div class="platform-icon netflix">N</div>
                            <div class="platform-icon prime">P</div>
                            <div class="platform-icon disney">D</div>
                            <div class="platform-icon hbo">H</div>
                        </div>
                    </div>
                </a>

                <!-- The Mandalorian -->
                <a href="<?= $router->generatePath('home-show') ?>" class="production-card">
                    <button class="favorite-btn">♡</button>
                    <img src="https://via.placeholder.com/300x450/0f4c75/3282b8?text=Mandalorian"
                         alt="The Mandalorian"
                         class="poster">
                    <div class="card-content">
                        <h3 class="card-title">The Mandalorian</h3>
                        <div class="card-meta">
                            <span>Series</span>
                        </div>
                        <div class="platforms">
                            <div class="platform-icon netflix">N</div>
                            <div class="platform-icon prime">P</div>
                            <div class="platform-icon disney">D</div>
                            <div class="platform-icon apple">A</div>
                        </div>
                    </div>
                </a>

                <!-- Oppenheimer -->
                <a href="<?= $router->generatePath('home-show') ?>" class="production-card">
                    <button class="favorite-btn">♡</button>
                    <img src="https://via.placeholder.com/300x450/2d4059/ea5455?text=Oppenheimer"
                         alt="Oppenheimer"
                         class="poster">
                    <div class="card-content">
                        <h3 class="card-title">Oppenheimer</h3>
                        <div class="card-meta">
                            <span>Movie</span>
                        </div>
                        <div class="platforms">
                            <div class="platform-icon netflix">N</div>
                            <div class="platform-icon prime">P</div>
                            <div class="platform-icon disney">D</div>
                            <div class="platform-icon apple">A</div>
                        </div>
                    </div>
                </a>

                <!-- Wednesday -->
                <a href="<?= $router->generatePath('home-show') ?>" class="production-card">
                    <button class="favorite-btn">♡</button>
                    <img src="https://via.placeholder.com/300x450/1a1a2e/16a085?text=Wednesday"
                         alt="Wednesday"
                         class="poster">
                    <div class="card-content">
                        <h3 class="card-title">Wednesday</h3>
                        <div class="card-meta">
                            <span>Series</span>
                        </div>
                        <div class="platforms">
                            <div class="platform-icon netflix">N</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <script>
        document.querySelectorAll('.favorite-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                if (this.classList.contains('active')) {
                    this.classList.remove('active');
                    this.innerHTML = '♡';
                } else {
                    this.classList.add('active');
                    this.innerHTML = '♥';
                }
            });
        });
    </script>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';