<?php
/**
 * Skrypt testowy do wypełniania i testowania bazy danych
 * Uruchom: php test-database.php
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Service\Database;
use App\Model\Production;
use App\Model\Platform;
use App\Model\ProductionAvailability;

try {
    $pdo = Database::getInstance();

    echo "+++ PlusFlix - Test Bazy Danych +++\n\n";

    function clearDatabase($pdo) {
        echo "1. Czyszczenie bazy danych...\n";
        $pdo->exec("DELETE FROM production_availability");
        $pdo->exec("DELETE FROM platform");
        $pdo->exec("DELETE FROM production");
        echo "   ✓ Dane wyczyszczone\n\n";
    }

    function insertPlatforms() {
        echo "2. Dodawanie platform streamingowych...\n";
        $platformsData = [
            ['name' => 'Netflix', 'logo_url' => 'https://via.placeholder.com/150x50/e50914/ffffff?text=Netflix'],
            ['name' => 'HBO Max', 'logo_url' => 'https://via.placeholder.com/150x50/9747ff/ffffff?text=HBO'],
            ['name' => 'Disney+', 'logo_url' => 'https://via.placeholder.com/150x50/113ccf/ffffff?text=Disney'],
            ['name' => 'Prime Video', 'logo_url' => 'https://via.placeholder.com/150x50/00a8e1/ffffff?text=Prime']
        ];

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO platform (name, logo_url) VALUES (:name, :logo_url)");

        foreach ($platformsData as $platformData) {
            $stmt->execute($platformData);
            echo "   ✓ " . $platformData['name'] . "\n";
        }
        echo "\n";
    }

    function insertProductions() {
        echo "3. Dodawanie produkcji filmowych...\n";
        $productionsData = [
            [
                'title' => 'Stranger Things',
                'type' => 'serial',
                'description' => 'When a young boy vanishes, a small town uncovers a mystery involving secret experiments, terrifying supernatural forces and one strange little girl.',
                'release_year' => 2016,
                'genre' => 'Sci-Fi, Horror, Drama',
                'poster_path' => '/images/dziwnerzeczy.png'
            ],
            [
                'title' => 'The Last of Us',
                'type' => 'serial',
                'description' => 'Twenty years after a fungal outbreak ravages the planet, survivors Joel and Ellie embark on a brutal journey across post-pandemic America.',
                'release_year' => 2023,
                'genre' => 'Drama, Sci-Fi, Thriller',
                'poster_path' => '/images/ostatnieznas.jpg'
            ],
            [
                'title' => 'Dune',
                'type' => 'film',
                'description' => 'Paul Atreides arrives on Arrakis, the most dangerous planet in the universe, to secure the future of his family and people.',
                'release_year' => 2021,
                'genre' => 'Sci-Fi, Adventure',
                'poster_path' => '/images/diunka.png'
            ],
            [
                'title' => 'The Mandalorian',
                'type' => 'serial',
                'description' => 'The travels of a lone bounty hunter in the outer reaches of the galaxy, far from the authority of the New Republic.',
                'release_year' => 2019,
                'genre' => 'Sci-Fi, Action, Adventure',
                'poster_path' => '/images/mandek.png'
            ],
            [
                'title' => 'Oppenheimer',
                'type' => 'film',
                'description' => 'The story of American scientist J. Robert Oppenheimer and his role in the development of the atomic bomb.',
                'release_year' => 2023,
                'genre' => 'Biography, Drama, History',
                'poster_path' => '/images/posters/oppenheimer-poster.png'
            ],
            [
                'title' => 'Wednesday',
                'type' => 'serial',
                'description' => 'Wednesday Addams attempts to master her emerging psychic ability while investigating murders that terrorized the local town.',
                'release_year' => 2022,
                'genre' => 'Comedy, Horror, Mystery',
                'poster_path' => '/images/czwartek.jpg'
            ]
        ];

        foreach ($productionsData as $productionData) {
            $production = Production::fromArray($productionData);
            $production->save();
            echo "   ✓ " . $productionData['title'] . " (" . $productionData['type'] . ", " . $productionData['release_year'] . ")\n";
        }
        echo "\n";
    }

    function assignPlatforms() {
        echo "4. Przypisywanie platform do produkcji...\n";

        $platforms = Platform::findAll();
        $platformMap = [];
        foreach ($platforms as $platform) {
            $platformMap[$platform->getName()] = $platform->getId();
        }

        $assignments = [
            1 => ['Netflix'],
            2 => ['HBO Max'],
            3 => ['HBO Max', 'Prime Video'],
            4 => ['Disney+'],
            5 => ['Prime Video'],
            6 => ['Netflix']
        ];

        foreach ($assignments as $productionId => $platformNames) {
            foreach ($platformNames as $platformName) {
                if (isset($platformMap[$platformName])) {
                    $availability = ProductionAvailability::fromArray([
                        'production_id' => $productionId,
                        'platform_id' => $platformMap[$platformName],
                        'is_available' => 1
                    ]);
                    $availability->save();
                    echo "   ✓ Produkcja #$productionId → $platformName\n";
                }
            }
        }
        echo "\n";
    }

    function displayData($pdo) {
        echo "5. Zawartość bazy danych:\n";


        echo "PLATFORMY:\n";
        echo "----------\n";
        $platforms = Platform::findAll();
        foreach ($platforms as $platform) {
            echo "  ID: {$platform->getId()} | {$platform->getName()}\n";
        }
        echo "\n";

        echo "PRODUKCJE:\n";
        echo "----------\n";
        $productions = Production::findAll();

        foreach ($productions as $prod) {
            $platforms = ProductionAvailability::findAllPlatformsWithAvailabilityByProduction($prod->getId());
            $platformNames = array_map(fn($p) => $p['name'], array_filter($platforms, fn($p) => $p['is_available']));

            echo "\n  #{$prod->getId()} - {$prod->getTitle()}\n";
            echo "      Typ: {$prod->getType()} | Rok: {$prod->getReleaseYear()}\n";
            echo "      Gatunek: {$prod->getGenre()}\n";
            echo "      Platformy: " . (count($platformNames) > 0 ? implode(', ', $platformNames) : 'brak') . "\n";
        }
        echo "\n";

        echo "STATYSTYKI:\n";
        echo "-----------\n";
        $allProductions = Production::findAll();
        $films = array_filter($allProductions, fn($p) => strtolower($p->getType()) === 'film');
        $series = array_filter($allProductions, fn($p) => strtolower($p->getType()) === 'serial');

        echo "  Łączna liczba produkcji: " . count($allProductions) . "\n";
        echo "  Filmy: " . count($films) . "\n";
        echo "  Seriale: " . count($series) . "\n";
        echo "  Platformy: " . count(Platform::findAll()) . "\n";
        echo "\n";
    }

    clearDatabase($pdo);
    insertPlatforms();
    insertProductions();
    assignPlatforms();
    displayData($pdo);

    echo " Test zakończony pomyślnie!\n";
    echo "Możesz teraz uruchomić aplikację:\n";
    echo "php -S localhost:56646 -t public\n\n";

} catch (PDOException $e) {
    echo "BŁĄD BAZY DANYCH: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "BŁĄD: " . $e->getMessage() . "\n";
    exit(1);
}