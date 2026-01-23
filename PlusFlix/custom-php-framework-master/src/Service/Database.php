<?php
namespace App\Service;
use PDO;

// Singleton do obsługi połączenia z bazą danych
// Używa wzorca projektowego Singleton, aby zapewnić jedno połączenie PDO w całej aplikacji.
//
// Po co:
// - Unikamy wielokrotnych połączeń z bazą danych, co może być kosztowne pod względem zasobów.
// - Ułatwiamy zarządzanie połączeniem z bazą danych w jednym miejscu.
// Jak używać:
// Wywołaj:
// Database::getInstance()
// aby uzyskać instancję PDO do wykonywania zapytań do bazy danych.
// zamiast tworzyć nowe połączenie za każdym razem:
// $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
//
// copilot polecił na gicie :)


class Database
{
    private static ?PDO $instance = null;


    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new PDO(
                Config::get('db_dsn'),
                Config::get('db_user'),
                Config::get('db_pass')
            );
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }


    private function __clone() {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}