<?php

namespace App\Controller;

use App\Model\UserList;
use App\Model\ListProduction;
use App\Model\ProductionAvailability;
use App\Service\GuestSession;
use App\Service\Router;
use App\Service\Templating;

class FavoritesController
{
    public function indexAction(Templating $templating, Router $router): string
    {
        $guestId = GuestSession::getGuestId();
        $session = \App\Model\Session::findByGuestId($guestId);

        $list = UserList::findOrCreateFavorites($session->getId());

        $productions = ListProduction::getProductions($list->getId());

        // platformy (tak jak na home/index)
        $availablePlatformsMap = ProductionAvailability::findAvailablePlatformsMap();

        // mapa ulubionych do podświetlenia serduszka
        $favoriteMap = [];
        foreach (ListProduction::getProductionIds($list->getId()) as $pid) {
            $favoriteMap[(int)$pid] = true;
        }

        return $templating->render('favorites/index.html.php', [
            'productions' => $productions,
            'availablePlatformsMap' => $availablePlatformsMap,
            'favoriteMap' => $favoriteMap,
            'router' => $router,
        ]);
    }

    public function toggleAction(int $productionId, Router $router): void
    {
        $guestId = GuestSession::getGuestId();
        $session = \App\Model\Session::findByGuestId($guestId);

        $list = UserList::findOrCreateFavorites($session->getId());

        ListProduction::toggle($list->getId(), $productionId);

        $router->redirect($_SERVER['HTTP_REFERER'] ?? $router->generatePath('home-index'));
    }
}
