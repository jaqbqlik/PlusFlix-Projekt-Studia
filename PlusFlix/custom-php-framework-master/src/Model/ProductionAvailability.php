<?php

namespace App\Model;

use App\Service\Config;

class ProductionAvailability
{
    private ?int $id = null;
    private ?int $productionId = null;
    private ?int $platformId = null;
    private ?int $isAvailable = 1; // 0/1 jak w DB

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): ProductionAvailability
    {
        $this->id = $id;
        return $this;
    }

    public function getProductionId(): ?int
    {
        return $this->productionId;
    }

    public function setProductionId(?int $productionId): ProductionAvailability
    {
        $this->productionId = $productionId;
        return $this;
    }

    public function getPlatformId(): ?int
    {
        return $this->platformId;
    }

    public function setPlatformId(?int $platformId): ProductionAvailability
    {
        $this->platformId = $platformId;
        return $this;
    }

    public function getIsAvailable(): ?int
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(?int $isAvailable): ProductionAvailability
    {
        $this->isAvailable = $isAvailable;
        return $this;
    }

    public static function fromArray($array): ProductionAvailability
    {
        $a = new self();
        $a->fill($array);
        return $a;
    }

    public function fill($array): ProductionAvailability
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['production_id'])) {
            $this->setProductionId($array['production_id']);
        }
        if (isset($array['platform_id'])) {
            $this->setPlatformId($array['platform_id']);
        }
        if (isset($array['is_available'])) {
            $this->setIsAvailable((int)$array['is_available']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM production_availability';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $items = [];
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $items[] = self::fromArray($row);
        }
        return $items;
    }

    public static function findAllByProduction($productionId): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM production_availability WHERE production_id = :pid';
        $statement = $pdo->prepare($sql);
        $statement->execute(['pid' => $productionId]);

        $items = [];
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $items[] = self::fromArray($row);
        }
        return $items;
    }

    public static function findOneByPair($productionId, $platformId): ?ProductionAvailability
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM production_availability WHERE production_id = :pid AND platform_id = :plid';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'pid' => $productionId,
            'plid' => $platformId
        ]);

        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $row) {
            return null;
        }
        return self::fromArray($row);
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));

        $existing = self::findOneByPair($this->getProductionId(), $this->getPlatformId());

        if (! $existing) {
            $sql = 'INSERT INTO production_availability (production_id, platform_id, is_available)
                    VALUES (:pid, :plid, :avail)';
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'pid' => $this->getProductionId(),
                'plid' => $this->getPlatformId(),
                'avail' => (int)$this->getIsAvailable(),
            ]);
            $this->setId($pdo->lastInsertId());
        } else {
            $this->setId($existing->getId());
            $sql = 'UPDATE production_availability SET is_available = :avail WHERE id = :id';
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'avail' => (int)$this->getIsAvailable(),
                'id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));

        $sql = 'DELETE FROM production_availability WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $this->getId()]);

        $this->setId(null);
        $this->setProductionId(null);
        $this->setPlatformId(null);
        $this->setIsAvailable(null);
    }

    /**
     * SHOW: wszystkie platformy + availability dla danej produkcji
     * Zwraca array: [ ['platform_id'=>..,'name'=>..,'logo_url'=>..,'is_available'=>0/1], ... ]
     */
    public static function findAllPlatformsWithAvailabilityByProduction($productionId): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));

        $sql = '
            SELECT 
                p.id AS platform_id,
                p.name AS name,
                p.poster_path AS poster_path,
                COALESCE(pa.is_available, 0) AS is_available
            FROM platform p
            LEFT JOIN production_availability pa
                ON pa.platform_id = p.id
               AND pa.production_id = :pid
            ORDER BY p.name ASC
        ';

        $statement = $pdo->prepare($sql);
        $statement->execute(['pid' => $productionId]);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * INDEX: mapka dostępnych platform do każdej produkcji
     * Zwraca: [ productionId => [ 'Netflix', 'Prime Video', ... ], ... ]
     */
    public static function findAvailablePlatformsMap(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));

        $sql = '
            SELECT pa.production_id, p.name
            FROM production_availability pa
            JOIN platform p ON p.id = pa.platform_id
            WHERE pa.is_available = 1
            ORDER BY pa.production_id, p.name
        ';

        $statement = $pdo->prepare($sql);
        $statement->execute();

        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $map = [];
        foreach ($rows as $row) {
            $pid = (int)$row['production_id'];
            if (! isset($map[$pid])) {
                $map[$pid] = [];
            }
            $map[$pid][] = $row['name'];
        }

        return $map;
    }
}
