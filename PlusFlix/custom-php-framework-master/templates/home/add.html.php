<?php
/** @var \App\Service\Router $router */
/** @var array $allPlatforms */

$title = 'PlusFlix';
$bodyClass = 'add-production';

ob_start(); ?>
    <main>
        <div class="container">
            <div class="form-page">
                <a href="<?= $router->generatePath('home-index') ?>" class="back-link">
                    ← Back to Home
                </a>

                <h1>Add New Production</h1>

                <form action="<?= $router->generatePath('production-add') ?>" method="post" class="production-form">
                    <div class="form-section">
                        <h2>Basic Information</h2>

                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" id="title" name="title" required placeholder="Enter title...">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="type">Type *</label>
                                <select id="type" name="type" required>
                                    <option value="film">Movie</option>
                                    <option value="serial">TV Series</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="release_year">Release Year</label>
                                <input type="number" id="release_year" name="release_year"
                                       min="1900" max="<?= date('Y') + 5 ?>"
                                       placeholder="YYYY">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="genre">Genres</label>
                            <input type="text" id="genre" name="genre"
                                   placeholder="e.g., Action, Drama, Comedy">
                        </div>

                        <div class="form-group">
                            <label for="poster_path">Poster URL</label>
                            <input type="text" id="poster_path" name="poster_path"
                                   placeholder="/images/your-poster.jpg">
                            <small>Leave empty to use default placeholder</small>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Platform Availability</h2>
                        <div class="platforms-checkboxes">
                            <?php foreach ($allPlatforms as $platform): ?>
                                <div class="checkbox-group">
                                    <input type="checkbox"
                                           id="platform-<?= $platform->getId() ?>"
                                           name="platforms[]"
                                           value="<?= $platform->getId() ?>">
                                    <label for="platform-<?= $platform->getId() ?>">
                                        <?= htmlspecialchars($platform->getName()) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Description</h2>
                        <div class="form-group">
                            <label for="description">Overview</label>
                            <textarea id="description" name="description" rows="6"
                                      placeholder="Enter production description..."></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Add Production</button>
                        <a href="<?= $router->generatePath('home-index') ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';