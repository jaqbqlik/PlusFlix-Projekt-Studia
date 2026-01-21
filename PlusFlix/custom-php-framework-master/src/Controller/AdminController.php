<?php
namespace App\Controller;

use App\Model\Admin;
use App\Service\Router;
use App\Service\Templating;

class AdminController
{
    public function loginAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        //czy admin zalogowany?
        session_start();
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            $router->redirect($router->generatePath('home-index'));
            return null;
        }

        $error = null;

        if ($requestPost) {
            $username = $requestPost['username'] ?? '';
            $password = $requestPost['password'] ?? '';

            $admin = Admin::findByUsername($username);

            if ($admin && $admin->verifyPassword($password)) {

                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin->getId();
                $_SESSION['admin_username'] = $admin->getUsername();

                //przekierowanie po zalogowaniu
                $redirectTo = $_SESSION['admin_redirect_after_login'] ?? $router->generatePath('home-index');
                unset($_SESSION['admin_redirect_after_login']);

                $router->redirect($redirectTo);
                return null;
            } else {
                $error = 'Nieprawidłowa nazwa użytkownika lub hasło';
            }
        }

        $html = $templating->render('admin/login.html.php', [
            'router' => $router,
            'error' => $error,
        ]);

        return $html;
    }

    public function logoutAction(Router $router): ?string
    {
        session_start();

        unset($_SESSION['admin_logged_in']);
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);

        session_destroy();

        $router->redirect($router->generatePath('home-index'));
        return null;
    }

    public static function isAdminLoggedIn(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    public static function requireAdmin(Router $router): void
    {
        if (!self::isAdminLoggedIn()) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['admin_redirect_after_login'] = $_SERVER['REQUEST_URI'];

            $router->redirect($router->generatePath('admin-login'));
            exit;
        }
    }
}