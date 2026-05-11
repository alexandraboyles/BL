<?php
namespace App\Repository;

use PDO;
class AddressStringsRepository
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
        $sql = "SELECT ass.*, 
                       a.address_name AS address_name, 
                       c.customer_name AS customer_name
                  FROM addressString ass
             LEFT JOIN Address a ON ass.address_id = a.id
             LEFT JOIN Customer c ON ass.customer_id = c.id
              ORDER BY ass.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT ass.*, 
                   a.address_name AS address_name, 
                   c.customer_name AS customer_name
              FROM addressString ass
         LEFT JOIN Address a ON ass.address_id = a.id
         LEFT JOIN Customer c ON ass.customer_id = c.id
             WHERE ass.id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO addressString (id, address_id, customer_id, text)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([
            (int)$data['id'],
            $data['address_id'],
            $data['customer_id'],
            trim($data['text'])
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE addressString
                SET id = ?, address_id = ?, customer_id = ?, 
                    text = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            (int)$data['id'],
            $data['address_id'],
            $data['customer_id'],
            trim($data['text']),
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM addressString WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete address string: it is referenced by other data.");
            }
            throw $e;
        }
    }
    public function existsById(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM addressString WHERE id = ?");
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }
    // New methods to populate dropdowns
    public function getAllAddresses(): array
    {
        $stmt = $this->pdo->query("SELECT id, address_name FROM Address ORDER BY address_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllCustomers(): array
    {
        $stmt = $this->pdo->query("SELECT id, customer_name FROM Customer ORDER BY customer_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
