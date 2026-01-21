<?php

namespace App\Model;

use App\Service\Database;

class Admin
{
    private ?int $id = null;
    private ?string $username = null;
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Admin
    {
        $this->id = $id;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): Admin
    {
        $this->username = $username;
        return $this;
    }

    public function setPassword(?string $password): Admin
    {
        $this->password = $password;
        return $this;
    }

    public static function fromArray($array): Admin
    {
        $admin = new self();
        $admin->fill($array);
        return $admin;
    }

    public function fill($array): Admin
    {
        if (isset($array['id']) && !$this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['username'])) {
            $this->setUsername($array['username']);
        }
        if (isset($array['password_hash'])) {
            $this->setPassword($array['password_hash']);
        }

        return $this;
    }

    public static function findByUsername(string $username): ?Admin
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT * FROM admin WHERE username = :username';
        $statement = $pdo->prepare($sql);
        $statement->execute(['username' => $username]);

        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        return self::fromArray($row);
    }

    public function verifyPassword(string $password): bool
    {
        return $this->password === $password;
    }
}