<?php
namespace App\Repository;

use PDO;

class ContactsRepository
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
        $sql = "SELECT ct.*, 
                       c.customer_name AS customer_name
                  FROM Contact ct
             LEFT JOIN Customer c ON ct.customer_id = c.id
              ORDER BY ct.contact_name DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(string $id): ?array
    {
        $sql = "SELECT ct.*, 
                   c.customer_name AS customer_name
              FROM Contact ct
         LEFT JOIN Customer c ON ct.customer_id = c.id
             WHERE ct.id = ?";

        $stmt = $this->pdo->prepare($sql);
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
            "INSERT INTO Contact (id, customer_id, contact_name, email, phone) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $uuid,
            $data['customer_id'],
            trim($data['contact_name']),
            trim($data['email']),
            trim($data['phone'])
        ]);
        return $this->pdo->lastInsertId();
    }

    public function update(string $originalContactId, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE Contact SET customer_id = ?, contact_name = ?, email = ?, phone = ? WHERE id = ?"
        );
        return $stmt->execute([
            $data['customer_id'],
            trim($data['contact_name']),
            trim($data['email']),
            trim($data['phone']),
            $originalContactId
        ]);
    }

    public function delete(string $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Contact WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete contact: it is referenced by other data.");
            }
            throw $e;
        }
    }

    public function existsByContactName(string $contactName, ?string $excludeContactId = null): bool
    {
        if ($excludeContactId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Contact WHERE contact_name = ?");
            $stmt->execute([trim($contactName)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Contact WHERE contact_name = ? AND id <> ?");
            $stmt->execute([trim($contactName), $excludeContactId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

    // New method to populate dropdowns
    public function getAllCustomers(): array
    {
        $stmt = $this->pdo->query("SELECT id, customer_name FROM Customer ORDER BY customer_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}