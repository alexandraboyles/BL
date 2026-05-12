<?php
namespace App\Repository;

use PDO;
class RateCardsRepository
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
        $sql = "SELECT rc.*, 
                       c.customer_name AS customer_name
                  FROM rateCard rc
             LEFT JOIN Customer c ON rc.customer_id = c.id
              ORDER BY rc.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find(int $id): ?array
    {
        $sql = "SELECT rc.*, 
                       c.customer_name AS customer_name
                  FROM rateCard rc
             LEFT JOIN Customer c ON rc.customer_id = c.id
              WHERE rc.id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO rateCard (customer_id, rates, contact_email)
             VALUES (?, ?, ?)"
        );
        $stmt->execute([
            $data['customer_id'],
            trim($data['rates']),
            trim($data['contact_email'])
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE rateCard
                SET customer_id = ?, rates = ?, contact_email = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            $data['customer_id'],
            trim($data['rates']),
            trim($data['contact_email']),
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM rateCard WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete rate card: it is referenced by other data.");
            }
            throw $e;
        }
    }

    public function existsByRates(string $rates, ?string $excludeRateCardId = null): bool
    {
        if ($excludeRateCardId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM rateCard WHERE rates = ?");
            $stmt->execute([trim($rates)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM rateCard WHERE rates = ? AND id <> ?");
            $stmt->execute([trim($rates), $excludeRateCardId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }
    // New methods to populate dropdowns
    public function getAllCustomers(): array
    {
        $stmt = $this->pdo->query("SELECT id, customer_name FROM Customer ORDER BY customer_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
