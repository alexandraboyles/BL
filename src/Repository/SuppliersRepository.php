<?php
namespace App\Repository;

use PDO;
class SuppliersRepository
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
        $sql = "SELECT s.*, 
                       rc.rates AS rateCard_name
                  FROM supplier s
             LEFT JOIN rateCard rc ON s.rateCard_id = rc.id
              ORDER BY s.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT s.*, 
                       rc.rates AS rateCard_name
                  FROM supplier s
             LEFT JOIN rateCard rc ON s.rateCard_id = rc.id
             WHERE s.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO supplier (id, rateCard_id, companyName, email, telNo, accountingConnector)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            (int)$data['id'],
            (int)$data['rateCard_id'],
            trim($data['companyName']),
            trim($data['email']),
            trim($data['telNo']),
            trim($data['accountingConnector'])
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE supplier
                SET id = ?, rateCard_id = ?, companyName = ?, email = ?, telNo = ?, accountingConnector = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            (int)$data['id'],
            (int)$data['rateCard_id'],
            trim($data['companyName']),
            trim($data['email']),
            trim($data['telNo']),
            trim($data['accountingConnector']),
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM supplier WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete supplier: it is referenced by other data.");
            }
            throw $e;
        }
    }

    public function existsById(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM supplier WHERE id = ?");
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function existsByCompanyName(string $CompanyName, ?string $excludeSupplierId = null): bool
    {
        if ($excludeSupplierId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM supplier WHERE CompanyName = ?");
            $stmt->execute([trim($CompanyName)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM supplier WHERE CompanyName = ? AND id <> ?");
            $stmt->execute([trim($CompanyName), $excludeSupplierId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

    public function existsByEmail(string $Email, ?string $excludeSupplierId = null): bool
    {
        if ($excludeSupplierId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM supplier WHERE email = ?");
            $stmt->execute([trim($Email)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM supplier WHERE email = ? AND id <> ?");
            $stmt->execute([trim($Email), $excludeSupplierId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

    // New methods to populate dropdowns
    public function getAllRateCards(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM rateCard ORDER BY rates");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
