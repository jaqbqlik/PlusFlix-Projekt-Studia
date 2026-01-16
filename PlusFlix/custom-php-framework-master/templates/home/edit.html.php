<?php
/** @var \App\Model\Production $production */
/** @var array $allPlatforms */
/** @var array $currentPlatformIds */
/** @var \App\Service\Router $router */

$title = 'PlusFlix';
$bodyClass = 'edit-production';

ob_start(); ?>
    <main>
        <div class="container">
            <div class="form-page">
                <a href="<?= $router->generatePath('home-show', ['id' => $production->getId()]) ?>" class="back-link">
                    ← Back to Production
                </a>

                <h1>Edit: <?= htmlspecialchars($production->getTitle()) ?></h1>

                <form action="<?= $router->generatePath('production-edit', ['id' => $production->getId()]) ?>" method="post" class="production-form">
                    <div class="form-section">
                        <h2>Basic Information</h2>

                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" id="title" name="title" required
                                   value="<?= htmlspecialchars($production->getTitle() ?? '') ?>"
                                   placeholder="Enter title...">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="type">Type *</label>
                                <select id="type" name="type" required>
                                    <option value="film" <?= $production->getType() === 'film' ? 'selected' : '' ?>>Movie</option>
                                    <option value="serial" <?= $production->getType() === 'serial' ? 'selected' : '' ?>>TV Series</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="release_year">Release Year</label>
                                <input type="number" id="release_year" name="release_year"
                                       value="<?= htmlspecialchars($production->getReleaseYear() ?? '') ?>"
                                       min="1900" max="<?= date('Y') + 5 ?>"
                                       placeholder="YYYY">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="genre">Genres</label>
                            <input type="text" id="genre" name="genre"
                                   value="<?= htmlspecialchars($production->getGenre() ?? '') ?>"
                                   placeholder="e.g., Action, Drama, Comedy">
                        </div>

                        <div class="form-group">
                            <label for="poster_path">Poster URL</label>
                            <input type="text" id="poster_path" name="poster_path"
                                   value="<?= htmlspecialchars($production->getPosterPath() ?? '') ?>"
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
                                           value="<?= $platform->getId() ?>"
                                        <?= in_array($platform->getId(), $currentPlatformIds) ? 'checked' : '' ?>>
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
                                      placeholder="Enter production description..."><?= htmlspecialchars($production->getDescription() ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="submit" name="delete" value="1" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this production?');">
                            Delete Production
                        </button>
                        <a href="<?= $router->generatePath('home-show', ['id' => $production->getId()]) ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';