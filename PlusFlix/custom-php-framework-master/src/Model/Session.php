<?php

namespace App\Model;

use App\Service\Database;

/**
 * działanie
 * gdy gość wchodzi na stronę, GuestSession tworzy nowy rekord w tabeli
 * guest_id z bazy jest taki sam jak wartość w ciasteczku przeglądarki
 * Dzięki temu możemy łączyć akcje użytkownika z jego sesją
 * Sesje wygasłe są automatycznie usuwane przez cleanExpiredSessions()
 */
class Session
{
    private ?string $id = null;
    private ?string $guestId = null;
    private ?string $cookieData = null;
    private ?string $createdAt = null;
    private ?string $expiresAt = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): Session
    {
        $this->id = $id;
        return $this;
    }

    public function getGuestId(): ?string
    {
        return $this->guestId;
    }

    public function setGuestId(?string $guestId): Session
    {
        $this->guestId = $guestId;
        return $this;
    }

    public function getCookieData(): ?string
    {
        return $this->cookieData;
    }

    public function setCookieData(?string $cookieData): Session
    {
        $this->cookieData = $cookieData;
        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): Session
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getExpiresAt(): ?string
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?string $expiresAt): Session
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    public static function fromArray($array): Session
    {
        $session = new self();
        $session->fill($array);
        return $session;
    }

    public function fill($array): Session
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['guest_id'])) {
            $this->setGuestId($array['guest_id']);
        }
        if (isset($array['cookie_data'])) {
            $this->setCookieData($array['cookie_data']);
        }
        if (isset($array['created_at'])) {
            $this->setCreatedAt($array['created_at']);
        }
        if (isset($array['expires_at'])) {
            $this->setExpiresAt($array['expires_at']);
        }

        return $this;
    }

    public static function find(string $id): ?Session
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT * FROM session WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        return self::fromArray($row);
    }

    public static function findByGuestId(string $guestId): ?Session
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT * FROM session WHERE guest_id = :guest_id ORDER BY created_at DESC LIMIT 1';
        $statement = $pdo->prepare($sql);
        $statement->execute(['guest_id' => $guestId]);

        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        return self::fromArray($row);
    }

    public function save(): void
    {
        $pdo = Database::getInstance();

        if (!$this->getId()) {
            // Generuj unikalny ID sesji
            $this->setId($this->generateSessionId());
        }

        $sql = 'INSERT OR REPLACE INTO session (id, guest_id, cookie_data, created_at, expires_at)
                VALUES (:id, :guest_id, :cookie_data, :created_at, :expires_at)';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'id' => $this->getId(),
            'guest_id' => $this->getGuestId(),
            'cookie_data' => $this->getCookieData(),
            'created_at' => $this->getCreatedAt() ?? date('Y-m-d H:i:s'),
            'expires_at' => $this->getExpiresAt(),
        ]);
    }

    public function delete(): void
    {
        $pdo = Database::getInstance();

        $sql = 'DELETE FROM session WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'id' => $this->getId(),
        ]);
    }

    private function generateSessionId(): string
    {
        return bin2hex(random_bytes(32));
    }

    public static function generateGuestId(): string
    {
        return 'guest_' . bin2hex(random_bytes(16));
    }

    public static function cleanExpiredSessions(): void
    {
        $pdo = Database::getInstance();

        $sql = 'DELETE FROM session WHERE expires_at < :now';
        $statement = $pdo->prepare($sql);
        $statement->execute(['now' => date('Y-m-d H:i:s')]);
    }
}