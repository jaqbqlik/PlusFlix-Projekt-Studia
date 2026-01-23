<?php

namespace App\Model;

use App\Service\Database;

class UserList
{
    private ?int $id = null;
    private ?string $sessionId = null;
    private ?string $name = null;

    public function getId(): ?int { return $this->id; }
    public function getSessionId(): ?string { return $this->sessionId; }
    public function getName(): ?string { return $this->name; }

    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function setSessionId(?string $sid): self { $this->sessionId = $sid; return $this; }
    public function setName(?string $name): self { $this->name = $name; return $this; }

    public static function findOrCreateFavorites(string $sessionId): UserList
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT * FROM user_list WHERE session_id = :sid AND name = "favorites"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['sid' => $sessionId]);

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            return self::fromArray($row);
        }

        $sql = 'INSERT INTO user_list (session_id, name) VALUES (:sid, "favorites")';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['sid' => $sessionId]);

        return self::fromArray([
            'id' => $pdo->lastInsertId(),
            'session_id' => $sessionId,
            'name' => 'favorites'
        ]);
    }

    public static function fromArray(array $row): self
    {
        return (new self())
            ->setId($row['id'])
            ->setSessionId($row['session_id'])
            ->setName($row['name']);
    }
}
