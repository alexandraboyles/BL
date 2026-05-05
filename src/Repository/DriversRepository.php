<?php
namespace App\Repository;

use PDO;

class DriversRepository
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        if (!isset($pdo)) {
            throw new \RuntimeException("Database connection not available");
        }
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $sql = "SELECT *
                  FROM driver
             ORDER BY driver_name DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(string $id): ?array
    {
        $sql = "SELECT *
                  FROM driver
             WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function save(array $data): string
    {
        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            random_int(0, 0xffff), random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000,
            random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff)
        );
    
        $stmt = $this->pdo->prepare(
            "INSERT INTO driver (id, driver_name, email, is_online, location_access_available) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $uuid,
            trim($data['driver_name']),
            trim($data['email']),
            (int)$data['is_online'],
            (int)$data['location_access_available'],
        ]);
        return $uuid;
    }

    public function update(string $originalDriverId, array $data): bool
    {

        $stmt = $this->pdo->prepare(
            "UPDATE driver SET driver_name = ?, email = ?, is_online = ?, location_access_available = ? WHERE id = ?"
        );
        return $stmt->execute([
            trim($data['driver_name']),
            trim($data['email']),
            (int)$data['is_online'],
            (int)$data['location_access_available'],
            $originalDriverId
        ]);
    }

    public function existsByDriverName(string $DriverName, ?string $excludeDriverId = null): bool
    {
        if ($excludeDriverId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM driver WHERE driver_name = ?");
            $stmt->execute([trim($DriverName)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM driver WHERE driver_name = ? AND id <> ?");
            $stmt->execute([trim($DriverName), $excludeDriverId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

    public function delete(string $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM driver WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete driver: it is referenced by other data.");
            }
            throw $e;
        }
    }
}