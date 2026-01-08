<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\HomeController;
use App\Service\Config;
use App\Service\Templating;
use App\Service\Router;

$config = new Config();
$templating = new Templating();
$router = new Router();

$action = $_REQUEST['action'] ?? 'home-index';

switch ($action) {
    case 'home-index':
    case null:
        $controller = new HomeController();
        $view = $controller->indexAction($templating, $router);
        break;

    case 'home-show':
        $controller = new HomeController();
        $view = $controller->showAction($templating, $router);
        break;

    default:
        $view = 'Not found';
}

echo $view;