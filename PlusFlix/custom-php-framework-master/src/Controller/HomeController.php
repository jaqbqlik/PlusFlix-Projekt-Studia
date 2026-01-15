<?php

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Production;
use App\Service\Router;
use App\Service\Templating;
use App\Model\ProductionAvailability;

class HomeController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $productions = Production::findAll();
        $availablePlatformsMap = ProductionAvailability::findAvailablePlatformsMap();

        $html = $templating->render('home/index.html.php', [
            'productions' => $productions,
            'availablePlatformsMap' => $availablePlatformsMap,
            'router' => $router,
        ]);

        return $html;
    }

    public function showAction(int $productionId, Templating $templating, Router $router): ?string
    {
        $production = Production::find($productionId);
        if (! $production) {
            throw new NotFoundException("Missing production with id $productionId");
        }

        $platforms = ProductionAvailability::findAllPlatformsWithAvailabilityByProduction($productionId);

        $html = $templating->render('home/show.html.php', [
            'production' => $production,
            'platforms' => $platforms,
            'router' => $router,
        ]);

        return $html;
    }

    public function createAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        if ($requestPost) {
            $production = Production::fromArray($requestPost);
            // @todo validation
            $production->save();

            $path = $router->generatePath('production-index');
            $router->redirect($path);
            return null;
        }

        $production = new Production();

        $html = $templating->render('home/create.html.php', [
            'production' => $production,
            'router' => $router,
        ]);

        return $html;
    }

    public function deleteAction(int $productionId, Router $router): ?string
    {
        $production = Production::find($productionId);
        if (! $production) {
            throw new NotFoundException("Missing production with id $productionId");
        }

        $production->delete();

        $path = $router->generatePath('production-index');
        $router->redirect($path);

        return null;
    }
}
