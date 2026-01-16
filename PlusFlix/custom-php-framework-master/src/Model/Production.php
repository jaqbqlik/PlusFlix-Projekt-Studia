<?php

namespace App\Model;

use App\Service\Database;

class Production
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $type = null;
    private ?string $description = null;
    private ?int $releaseYear = null;
    private ?string $genre = null;
    private ?string $posterPath = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Production
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Production
    {
        $this->title = $title;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): Production
    {
        $this->type = $type;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Production
    {
        $this->description = $description;
        return $this;
    }

    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(?int $releaseYear): Production
    {
        $this->releaseYear = $releaseYear;
        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): Production
    {
        $this->genre = $genre;
        return $this;
    }

    public function getPosterPath(): ?string
    {
        return $this->posterPath;
    }

    public function setPosterPath(?string $posterPath): Production
    {
        $this->posterPath = $posterPath;
        return $this;
    }

    public static function fromArray($array): Production
    {
        $production = new self();
        $production->fill($array);
        return $production;
    }

    public function fill($array): Production
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['title'])) {
            $this->setTitle($array['title']);
        }
        if (isset($array['type'])) {
            $this->setType($array['type']);
        }
        if (isset($array['description'])) {
            $this->setDescription($array['description']);
        }
        if (isset($array['release_year'])) {
            $this->setReleaseYear($array['release_year']);
        }
        if (isset($array['genre'])) {
            $this->setGenre($array['genre']);
        }
        if (isset($array['poster_path'])) {
            $this->setPosterPath($array['poster_path']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT * FROM production';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $items = [];
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $items[] = self::fromArray($row);
        }

        return $items;
    }

    public static function find($id): ?Production
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT * FROM production WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $row) {
            return null;
        }

        return self::fromArray($row);
    }

    public function save(): void
    {
        $pdo = Database::getInstance();

        if (! $this->getId()) {
            $sql = 'INSERT INTO production (title, type, description, release_year, genre, poster_path)
                    VALUES (:title, :type, :description, :release_year, :genre, :poster_path)';
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'title' => $this->getTitle(),
                'type' => $this->getType(),
                'description' => $this->getDescription(),
                'release_year' => $this->getReleaseYear(),
                'genre' => $this->getGenre(),
                'poster_path' => $this->getPosterPath(),
            ]);

            $this->setId($pdo->lastInsertId());
        } else {
            $sql = 'UPDATE production
                    SET title = :title,
                        type = :type,
                        description = :description,
                        release_year = :release_year,
                        genre = :genre,
                        poster_path = :poster_path
                    WHERE id = :id';
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'title' => $this->getTitle(),
                'type' => $this->getType(),
                'description' => $this->getDescription(),
                'release_year' => $this->getReleaseYear(),
                'genre' => $this->getGenre(),
                'poster_path' => $this->getPosterPath(),
                'id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = Database::getInstance();

        $sql = 'DELETE FROM production WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setTitle(null);
        $this->setType(null);
        $this->setDescription(null);
        $this->setReleaseYear(null);
        $this->setGenre(null);
        $this->setPosterPath(null);
    }
}