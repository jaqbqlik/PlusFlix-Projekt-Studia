<?php

namespace App\Model;

use App\Service\Config;

class Platform
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $posterPath = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Platform
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Platform
    {
        $this->name = $name;
        return $this;
    }

    public function getPosterPath(): ?string
    {
        return $this->posterPath;
    }

    public function setPosterPath(?string $posterPath): Platform
    {
        $this->posterPath = $posterPath;
        return $this;
    }

    public static function fromArray($array): Platform
    {
        $platform = new self();
        $platform->fill($array);
        return $platform;
    }

    public function fill($array): Platform
    {
        if (isset($array['id']) && !$this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['name'])) {
            $this->setName($array['name']);
        }
        if (isset($array['poster_path'])) {
            $this->setPosterPath($array['poster_path']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT * FROM platform ORDER BY name';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $items = [];
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $items[] = self::fromArray($row);
        }

        return $items;
    }

    public static function find($id): ?Platform
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT * FROM platform WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

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
            $sql = 'INSERT INTO platform (name, poster_path) VALUES (:name, :poster_path)';
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'name' => $this->getName(),
                'poster_path' => $this->getPosterPath(),
            ]);

            $this->setId($pdo->lastInsertId());
        } else {
            $sql = 'UPDATE platform SET name = :name, poster_path = :poster_path WHERE id = :id';
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'name' => $this->getName(),
                'poster_path' => $this->getPosterPath(),
                'id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = Database::getInstance();

        $sql = 'DELETE FROM platform WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setName(null);
        $this->setPosterPath(null);
    }
}