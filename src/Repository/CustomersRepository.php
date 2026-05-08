<?php
namespace App\Repository;

use PDO;

class CustomersRepository
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
                  FROM Customer
             ORDER BY customer_name DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(string $id): ?array
    {
        $sql = "SELECT *
                  FROM Customer
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
            "INSERT INTO Customer (id, customer_name, contact_phone, contact_email) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([
            $uuid,
            trim($data['customer_name']),
            trim($data['contact_phone']),
            trim($data['contact_email'])
        ]);
        return $uuid;
    }

    public function update(string $originalCustomerId, array $data): bool
    {

        $stmt = $this->pdo->prepare(
            "UPDATE Customer SET customer_name = ?, contact_phone = ?, contact_email = ? WHERE id = ?"
        );
        return $stmt->execute([
            trim($data['customer_name']),
            trim($data['contact_phone']),
            trim($data['contact_email']),
            $originalCustomerId
        ]);
    }

    public function existsByCustomerName(string $CustomerName, ?string $excludeCustomerId = null): bool
    {
        if ($excludeCustomerId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Customer WHERE customer_name = ?");
            $stmt->execute([trim($CustomerName)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Customer WHERE customer_name = ? AND id <> ?");
            $stmt->execute([trim($CustomerName), $excludeCustomerId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

    public function delete(string $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Customer WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete customer: it is referenced by other data.");
            }
            throw $e;
        }
    }
}