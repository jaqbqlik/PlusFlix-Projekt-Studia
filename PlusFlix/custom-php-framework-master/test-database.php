<?php
/**
 * Skrypt testowy do wypełniania i testowania bazy danych
 * Uruchom: php test-database.php
 */

// Konfiguracja bazy danych
$dbFile = __DIR__ . DIRECTORY_SEPARATOR . 'data.db';
$dbDsn = 'sqlite:' . $dbFile;

try {
    $pdo = new PDO($dbDsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== PlusFlix - Test Bazy Danych ===\n\n";

    // Funkcja do czyszczenia danych
    function clearDatabase($pdo) {
        echo "1. Czyszczenie bazy danych...\n";
        $pdo->exec("DELETE FROM production_availability");
        $pdo->exec("DELETE FROM platform");
        $pdo->exec("DELETE FROM production");
        echo "   ✓ Dane wyczyszczone\n\n";
    }

    // Funkcja do dodawania platform
    function insertPlatforms($pdo) {
        echo "2. Dodawanie platform streamingowych...\n";
        $platforms = [
            ['name' => 'Netflix', 'logo_url' => 'https://via.placeholder.com/150x50/e50914/ffffff?text=Netflix'],
            ['name' => 'HBO Max', 'logo_url' => 'https://via.placeholder.com/150x50/9747ff/ffffff?text=HBO'],
            ['name' => 'Disney+', 'logo_url' => 'https://via.placeholder.com/150x50/113ccf/ffffff?text=Disney'],
            ['name' => 'Prime Video', 'logo_url' => 'https://via.placeholder.com/150x50/00a8e1/ffffff?text=Prime']
        ];

        $stmt = $pdo->prepare("INSERT INTO platform (name, logo_url) VALUES (:name, :logo_url)");

        foreach ($platforms as $platform) {
            $stmt->execute($platform);
            echo "   ✓ " . $platform['name'] . "\n";
        }
        echo "\n";
    }

    // Funkcja do dodawania produkcji
    function insertProductions($pdo) {
        echo "3. Dodawanie produkcji filmowych...\n";
        $productions = [
            [
                'title' => 'Stranger Things',
                'type' => 'serial',
                'description' => 'When a young boy vanishes, a small town uncovers a mystery involving secret experiments, terrifying supernatural forces and one strange little girl.',
                'release_year' => 2016,
                'genre' => 'Sci-Fi, Horror, Drama',
                'poster_url' => 'https://via.placeholder.com/300x450/1a1a2e/e94560?text=Stranger+Things'
            ],
            [
                'title' => 'The Last of Us',
                'type' => 'serial',
                'description' => 'Twenty years after a fungal outbreak ravages the planet, survivors Joel and Ellie embark on a brutal journey across post-pandemic America.',
                'release_year' => 2023,
                'genre' => 'Drama, Sci-Fi, Thriller',
                'poster_url' => 'https://via.placeholder.com/300x450/16213e/0f3460?text=The+Last+of+Us'
            ],
            [
                'title' => 'Dune',
                'type' => 'film',
                'description' => 'Paul Atreides arrives on Arrakis, the most dangerous planet in the universe, to secure the future of his family and people.',
                'release_year' => 2021,
                'genre' => 'Sci-Fi, Adventure',
                'poster_url' => 'https://via.placeholder.com/300x450/533483/9b59b6?text=Dune'
            ],
            [
                'title' => 'The Mandalorian',
                'type' => 'serial',
                'description' => 'The travels of a lone bounty hunter in the outer reaches of the galaxy, far from the authority of the New Republic.',
                'release_year' => 2019,
                'genre' => 'Sci-Fi, Action, Adventure',
                'poster_url' => 'https://via.placeholder.com/300x450/0f4c75/3282b8?text=Mandalorian'
            ],
            [
                'title' => 'Oppenheimer',
                'type' => 'film',
                'description' => 'The story of American scientist J. Robert Oppenheimer and his role in the development of the atomic bomb.',
                'release_year' => 2023,
                'genre' => 'Biography, Drama, History',
                'poster_url' => 'https://via.placeholder.com/300x450/2d4059/ea5455?text=Oppenheimer'
            ],
            [
                'title' => 'Wednesday',
                'type' => 'serial',
                'description' => 'Wednesday Addams attempts to master her emerging psychic ability while investigating murders that terrorized the local town.',
                'release_year' => 2022,
                'genre' => 'Comedy, Horror, Mystery',
                'poster_url' => 'https://via.placeholder.com/300x450/1a1a2e/16a085?text=Wednesday'
            ],
            [
                'title' => 'Breaking Bad',
                'type' => 'serial',
                'description' => 'A chemistry teacher diagnosed with cancer turns to manufacturing meth to secure his family\'s future.',
                'release_year' => 2008,
                'genre' => 'Crime, Drama, Thriller',
                'poster_url' => 'https://via.placeholder.com/300x450/2c3e50/27ae60?text=Breaking+Bad'
            ],
            [
                'title' => 'The Witcher',
                'type' => 'serial',
                'description' => 'Geralt of Rivia, a solitary monster hunter, struggles to find his place in a world where people often prove more wicked than beasts.',
                'release_year' => 2019,
                'genre' => 'Fantasy, Action, Adventure',
                'poster_url' => 'https://via.placeholder.com/300x450/34495e/e74c3c?text=The+Witcher'
            ],
            [
                'title' => 'Inception',
                'type' => 'film',
                'description' => 'A thief who steals corporate secrets through dream-sharing technology is given the inverse task of planting an idea.',
                'release_year' => 2010,
                'genre' => 'Sci-Fi, Action, Thriller',
                'poster_url' => 'https://via.placeholder.com/300x450/2c3e50/3498db?text=Inception'
            ],
            [
                'title' => 'The Crown',
                'type' => 'serial',
                'description' => 'Follows the political rivalries and romance of Queen Elizabeth II\'s reign and the events that shaped the second half of the 20th century.',
                'release_year' => 2016,
                'genre' => 'Drama, History',
                'poster_url' => 'https://via.placeholder.com/300x450/8e44ad/ecf0f1?text=The+Crown'
            ]
        ];

        $stmt = $pdo->prepare("
            INSERT INTO production (title, type, description, release_year, genre, poster_url) 
            VALUES (:title, :type, :description, :release_year, :genre, :poster_url)
        ");

        foreach ($productions as $production) {
            $stmt->execute($production);
            echo "   ✓ " . $production['title'] . " (" . $production['type'] . ", " . $production['release_year'] . ")\n";
        }
        echo "\n";
    }

    // Funkcja do przypisywania platform do produkcji
    function assignPlatforms($pdo) {
        echo "4. Przypisywanie platform do produkcji...\n";

        $platforms = $pdo->query("SELECT id, name FROM platform")->fetchAll(PDO::FETCH_KEY_PAIR);

        $assignments = [
            1 => ['Netflix'],
            2 => ['HBO Max'],
            3 => ['HBO Max', 'Prime Video'],
            4 => ['Disney+'],
            5 => ['Prime Video'],
            6 => ['Netflix'],
            7 => ['Netflix'],
            8 => ['Netflix'],
            9 => ['HBO Max', 'Prime Video'],
            10 => ['Netflix']
        ];

        $stmt = $pdo->prepare("
            INSERT INTO production_availability (production_id, platform_id, is_available) 
            VALUES (:production_id, :platform_id, 1)
        ");

        foreach ($assignments as $productionId => $platformNames) {
            foreach ($platformNames as $platformName) {
                if (isset($platforms[$platformName])) {
                    $stmt->execute([
                        'production_id' => $productionId,
                        'platform_id' => $platforms[$platformName]
                    ]);
                    echo "   ✓ Produkcja #$productionId → $platformName\n";
                }
            }
        }
        echo "\n";
    }

    // Funkcja do wyświetlania danych
    function displayData($pdo) {
        echo "5. Zawartość bazy danych:\n";
        echo "================================\n\n";

        echo "PLATFORMY:\n";
        echo "----------\n";
        $platforms = $pdo->query("SELECT * FROM platform")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($platforms as $platform) {
            echo "  ID: {$platform['id']} | {$platform['name']}\n";
        }
        echo "\n";

        echo "PRODUKCJE:\n";
        echo "----------\n";
        $query = "
            SELECT 
                p.id,
                p.title,
                p.type,
                p.release_year,
                p.genre,
                GROUP_CONCAT(pl.name, ', ') as platforms
            FROM production p
            LEFT JOIN production_availability pa ON p.id = pa.production_id
            LEFT JOIN platform pl ON pa.platform_id = pl.id
            GROUP BY p.id
            ORDER BY p.title
        ";

        $productions = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($productions as $prod) {
            echo "\n  #{$prod['id']} - {$prod['title']}\n";
            echo "      Typ: {$prod['type']} | Rok: {$prod['release_year']}\n";
            echo "      Gatunek: {$prod['genre']}\n";
            echo "      Platformy: " . ($prod['platforms'] ?: 'brak') . "\n";
        }
        echo "\n";

        echo "STATYSTYKI:\n";
        echo "-----------\n";
        $stats = $pdo->query("
            SELECT 
                (SELECT COUNT(*) FROM production) as total_productions,
                (SELECT COUNT(*) FROM production WHERE type = 'film') as films,
                (SELECT COUNT(*) FROM production WHERE type = 'serial') as series,
                (SELECT COUNT(*) FROM platform) as platforms,
                (SELECT COUNT(*) FROM production_availability) as assignments
        ")->fetch(PDO::FETCH_ASSOC);

        echo "  Łączna liczba produkcji: {$stats['total_productions']}\n";
        echo "  Filmy: {$stats['films']}\n";
        echo "  Seriale: {$stats['series']}\n";
        echo "  Platformy: {$stats['platforms']}\n";
        echo "  Przypisań: {$stats['assignments']}\n";
        echo "\n";
    }

    clearDatabase($pdo);
    insertPlatforms($pdo);
    insertProductions($pdo);
    assignPlatforms($pdo);
    displayData($pdo);

    echo "================================\n";
    echo "✓ Test zakończony pomyślnie!\n";
    echo "================================\n\n";
    echo "Możesz teraz uruchomić aplikację:\n";
    echo "php -S localhost:56646 -t .\public \n\n";

} catch (PDOException $e) {
    echo "BŁĄD BAZY DANYCH: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "BŁĄD: " . $e->getMessage() . "\n";
    exit(1);
}