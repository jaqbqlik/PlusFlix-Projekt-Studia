<?php $title = 'Panel Admina'; ?>
<?php ob_start() ?>
    <div class="admin-login-container">
        <div class="admin-login-card">
            <h2>Panel Administratora</h2>
            <?php if (isset($error) && $error): ?>
                <div class="admin-login-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="post" action="<?= $router->generatePath('admin-login') ?>" class="admin-login-form">
                <div class="form-group">
                    <label for="username">Nazwa użytkownika:</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        required
                        autofocus
                    >
                </div>
                <div class="form-group">
                    <label for="password">Hasło:</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                    >
                </div>
                <div class="submit-group">
                    <button type="submit">Zaloguj się</button>
                </div>
            </form>
            <div class="admin-login-info">
                <p>Domyślne dane logowania:</p>
                <p><strong>Login:</strong> admin | <strong>Hasło:</strong> admin</p>
            </div>
            <div class="admin-login-back">
                <a href="<?= $router->generatePath('home-index') ?>">
                    ← Powrót do strony głównej
                </a>
            </div>
        </div>
    </div>
<?php $main = ob_get_clean() ?>
<?php include __DIR__ . '/../base.html.php' ?>