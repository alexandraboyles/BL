<?php
namespace App\Repository;

use PDO;

class AddressRepository
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
        $stmt = $this->pdo->query("SELECT * FROM Address ORDER BY address_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Address WHERE address_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function save(array $data): int
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
            "INSERT INTO Address (id, address_id, address_name, street_1, street_2, suburb, state, postcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $uuid,
            (int)$data['address_id'],
            trim($data['address_name']),
            trim($data['street_1']),
            trim($data['street_2'] ?? ''),
            trim($data['suburb']),
            trim($data['state']),
            trim($data['postcode'])
        ]);
        return $this->pdo->lastInsertId();
    }

    public function update(int $originalAddressId, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE Address SET address_id = ?, address_name = ?, street_1 = ?, street_2 = ?, suburb = ?, state = ?, postcode = ? WHERE address_id = ?"
        );
        return $stmt->execute([
            (int)$data['address_id'],
            trim($data['address_name']),
            trim($data['street_1']),
            trim($data['street_2'] ?? ''),
            trim($data['suburb']),
            trim($data['state']),
            trim($data['postcode']),
            $originalAddressId
        ]);
    }

    public function existsByAddressId(int $addressId): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Address WHERE address_id = ?");
        $stmt->execute([$addressId]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function existsByAddressName(string $addressName, ?int $excludeAddressId = null): bool
    {
        if ($excludeAddressId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Address WHERE address_name = ?");
            $stmt->execute([trim($addressName)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Address WHERE address_name = ? AND address_id <> ?");
            $stmt->execute([trim($addressName), $excludeAddressId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Address WHERE address_id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete address: it is referenced by other data.");
            }
            throw $e;
        }
    }
}