<?php

/** @var \App\Service\Router $router */

$title = 'PlusFlix';
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
                    <button class="favorite-btn active" type="button">♥</button>
                    <img src="#"
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
                    <button class="favorite-btn active" type="button">♥</button>
                    <img src="#"
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
                    <button class="favorite-btn" type="button">♡</button>
                    <img src="#"
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
                    <button class="favorite-btn" type="button">♡</button>
                    <img src="#"
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
                    <button class="favorite-btn" type="button">♡</button>
                    <img src="#"
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
                    <button class="favorite-btn" type="button">♡</button>
                    <img src="#"
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