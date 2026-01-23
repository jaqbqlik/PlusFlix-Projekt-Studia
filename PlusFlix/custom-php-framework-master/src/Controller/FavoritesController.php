<?php

namespace App\Controller;

use App\Model\UserList;
use App\Model\ListProduction;
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

        return $templating->render('favorites/favorites.html.php', [
            'productions' => $productions,
            'router' => $router
        ]);
    }

    public function toggleAction(int $productionId, Router $router): void
    {
        $guestId = GuestSession::getGuestId();
        $session = \App\Model\Session::findByGuestId($guestId);

        $list = UserList::findOrCreateFavorites($session->getId());

        ListProduction::add($list->getId(), $productionId);

        $router->redirect($_SERVER['HTTP_REFERER'] ?? '/');
    }
}
