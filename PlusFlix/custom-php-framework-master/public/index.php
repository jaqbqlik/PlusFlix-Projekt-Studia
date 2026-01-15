<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$config = new \App\Service\Config();

$templating = new \App\Service\Templating();
$router = new \App\Service\Router();

$action = $_REQUEST['action'] ?? null;

switch ($action) {

    case 'home-index':
    case null:
        $controller = new \App\Controller\HomeController();
        $view = $controller->indexAction($templating, $router);
        break;

    case 'home-show':
        if (!isset($_REQUEST['id'])) {
            break;
        }
        $controller = new \App\Controller\HomeController();
        $view = $controller->showAction((int)$_REQUEST['id'], $templating, $router);
        break;

    case 'production-add':
        $controller = new \App\Controller\HomeController();
        $view = $controller->addAction($_POST, $templating, $router);
        break;

    case 'production-edit':
        if (!isset($_REQUEST['id'])) {
            break;
        }
        $controller = new \App\Controller\HomeController();
        $view = $controller->editAction((int)$_REQUEST['id'], $_POST, $templating, $router);
        break;

    case 'home-delete':
        if (!isset($_REQUEST['id'])) {
            break;
        }
        $controller = new \App\Controller\HomeController();
        $view = $controller->deleteAction((int)$_REQUEST['id'], $router);
        break;

    default:
        $view = 'Not found';
        break;
}

if ($view) {
    echo $view;
}
