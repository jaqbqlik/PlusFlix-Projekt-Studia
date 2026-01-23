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
}
