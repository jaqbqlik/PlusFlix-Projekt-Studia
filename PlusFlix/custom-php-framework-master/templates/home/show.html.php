<?php

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
                        <img src="/images/dziwnerzeczy.png"
                             alt="Stranger Things"
                             class="detail-poster">
                    </div>

                    <div class="detail-content">
                        <div class="detail-header">
                            <h1>Stranger Things</h1>
                            <button class="favorite-btn-detail active" type="button">♥</button>
                        </div>

                        <div class="detail-meta">
                            <span>Series</span>
                            <span>2016</span>
                            <span>8.7/10</span>
                        </div>

                        <div class="platforms-section">
                            <h3>Available on</h3>
                            <div class="platform-badges">
                                <div class="platform-badge netflix">
                                    <span>N</span>
                                    Netflix
                                </div>
                                <div class="platform-badge prime inactive">
                                    <span>P</span>
                                    Prime Video
                                </div>
                                <div class="platform-badge disney inactive">
                                    <span>D</span>
                                    Disney+
                                </div>
                                <div class="platform-badge hbo inactive">
                                    <span>H</span>
                                    HBO Max
                                </div>
                            </div>
                        </div>

                        <div class="overview-section">
                            <h3>Overview</h3>
                            <p>When a young boy vanishes, a small town uncovers a mystery involving secret experiments, terrifying supernatural forces and one strange little girl.</p>
                        </div>

                        <div class="info-grid">
                            <div class="info-item">
                                <h3>Cast</h3>
                                <p>Millie Bobby Brown, Finn Wolfhard, Winona Ryder</p>
                            </div>
                            <div class="info-item">
                                <h3>Genres</h3>
                                <p>Drama, Fantasy, Horror</p>
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