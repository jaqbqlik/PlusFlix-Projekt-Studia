<?php

namespace App\Model;

use App\Service\Database;

class ListProduction
{
    public static function add(int $listId, int $productionId): void
    {
        $pdo = Database::getInstance();
        $sql = 'INSERT OR IGNORE INTO list_production (list_id, production_id)
                VALUES (:lid, :pid)';
        $pdo->prepare($sql)->execute([
            'lid' => $listId,
            'pid' => $productionId
        ]);
    }

    public static function remove(int $listId, int $productionId): void
    {
        $pdo = Database::getInstance();
        $sql = 'DELETE FROM list_production WHERE list_id = :lid AND production_id = :pid';
        $pdo->prepare($sql)->execute([
            'lid' => $listId,
            'pid' => $productionId
        ]);
    }

    public static function exists(int $listId, int $productionId): bool
    {
        $pdo = Database::getInstance();
        $sql = 'SELECT 1 FROM list_production WHERE list_id = :lid AND production_id = :pid LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'lid' => $listId,
            'pid' => $productionId
        ]);
        return (bool)$stmt->fetchColumn();
    }

    /**
     * Toggle: jeśli jest w ulubionych -> usuń, jeśli nie ma -> dodaj
     * Zwraca true jeśli po operacji jest ulubione, false jeśli zostało usunięte.
     */
    public static function toggle(int $listId, int $productionId): bool
    {
        if (self::exists($listId, $productionId)) {
            self::remove($listId, $productionId);
            return false;
        }

        self::add($listId, $productionId);
        return true;
    }

    public static function getProductions(int $listId): array
    {
        $pdo = Database::getInstance();

        $sql = '
            SELECT p.*
            FROM list_production lp
            JOIN production p ON p.id = lp.production_id
            WHERE lp.list_id = :lid
            ORDER BY lp.added_at DESC
        ';

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['lid' => $listId]);

        $items = [];
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $items[] = Production::fromArray($row);
        }

        return $items;
    }

    public static function getProductionIds(int $listId): array
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT production_id FROM list_production WHERE list_id = :lid';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['lid' => $listId]);

        $ids = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $ids = array_map('intval', $ids);

        return $ids;
    }
}
