<?php

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Production;
use App\Service\Router;
use App\Service\Templating;
use App\Model\ProductionAvailability;
use App\Model\Platform;

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

    public function addAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        $allPlatforms = Platform::findAll();

        if ($requestPost) {
            $production = Production::fromArray([
                'title' => $requestPost['title'] ?? '',
                'type' => $requestPost['type'] ?? 'film',
                'description' => $requestPost['description'] ?? '',
                'release_year' => $requestPost['release_year'] ?? null,
                'genre' => $requestPost['genre'] ?? '',
                'poster_path' => $requestPost['poster_path'] ?? '/images/placeholder-user.jpg',
            ]);

            $production->save();
            $productionId = $production->getId();

            if (isset($requestPost['platforms']) && is_array($requestPost['platforms'])) {
                foreach ($requestPost['platforms'] as $platformId) {
                    $availability = ProductionAvailability::fromArray([
                        'production_id' => $productionId,
                        'platform_id' => $platformId,
                        'is_available' => 1
                    ]);
                    $availability->save();
                }
            }

            $path = $router->generatePath('home-index');
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('home/add.html.php', [
            'router' => $router,
            'allPlatforms' => $allPlatforms,
        ]);

        return $html;
    }

    public function editAction(int $productionId, ?array $requestPost, Templating $templating, Router $router): ?string
    {
        $production = Production::find($productionId);
        if (!$production) {
            throw new NotFoundException("Missing production with id $productionId");
        }

        $allPlatforms = Platform::findAll();
        $currentPlatforms = ProductionAvailability::findAllByProduction($productionId);
        $currentPlatformIds = array_map(fn($p) => $p->getPlatformId(), $currentPlatforms);

        if ($requestPost) {
            if (isset($requestPost['delete'])) {
                $production->delete();
                $path = $router->generatePath('home-index');
                $router->redirect($path);
                return null;
            }

            $production->setTitle($requestPost['title'] ?? '');
            $production->setType($requestPost['type'] ?? 'film');
            $production->setDescription($requestPost['description'] ?? '');
            $production->setReleaseYear($requestPost['release_year'] ?? null);
            $production->setGenre($requestPost['genre'] ?? '');
            $production->setPosterPath($requestPost['poster_path'] ?? '/images/placeholder-user.jpg');
            $production->save();

            $selectedPlatformIds = $requestPost['platforms'] ?? [];

            foreach ($currentPlatforms as $platform) {
                if (!in_array($platform->getPlatformId(), $selectedPlatformIds)) {
                    $platform->delete();
                }
            }

            foreach ($selectedPlatformIds as $platformId) {
                if (!in_array($platformId, $currentPlatformIds)) {
                    $availability = ProductionAvailability::fromArray([
                        'production_id' => $productionId,
                        'platform_id' => $platformId,
                        'is_available' => 1
                    ]);
                    $availability->save();
                }
            }

            $path = $router->generatePath('home-show', ['id' => $productionId]);
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('home/edit.html.php', [
            'production' => $production,
            'allPlatforms' => $allPlatforms,
            'currentPlatformIds' => $currentPlatformIds,
            'router' => $router,
        ]);

        return $html;
    }

    public function searchAction(?string $query): string
    {
        $results = [];

        if ($query) {
            $pdo = new \PDO(\App\Service\Config::get('db_dsn'),
                \App\Service\Config::get('db_user'),
                \App\Service\Config::get('db_pass'));
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $sql = 'SELECT id, title, type FROM production WHERE title LIKE :q ORDER BY title LIMIT 10';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['q' => '%' . $query . '%']);
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        header('Content-Type: application/json');
        echo json_encode($results);
        exit;
    }
}