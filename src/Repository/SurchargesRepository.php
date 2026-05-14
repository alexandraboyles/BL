<?php
namespace App\Repository;

use PDO;
class SurchargesRepository
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
                       fg.feeCategory_name AS feeCategory_name
                  FROM surcharge s
             LEFT JOIN feeCategory fg ON s.feeCategory_id = fg.id
              ORDER BY s.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find(int $id): ?array
    {
        $sql = "SELECT s.*, 
                       fg.feeCategory_name AS feeCategory_name
                  FROM surcharge s
             LEFT JOIN feeCategory fg ON s.feeCategory_id = fg.id
              WHERE s.id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO surcharge (feeCategory_id, surcharge_name, conditions, surcharge, status)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['feeCategory_id'],
            trim($data['surcharge_name']),
            trim($data['conditions']),
            $data['surcharge'],
            trim($data['status'])
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE surcharge
                SET feeCategory_id = ?, surcharge_name = ?, conditions = ?, surcharge = ?, status = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            $data['feeCategory_id'],
            trim($data['surcharge_name']),
            trim($data['conditions']),
            $data['surcharge'],
            trim($data['status']),
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {

            $stmt = $this->pdo->prepare("DELETE FROM surcharge WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete surcharge: it is referenced by other data.");
            }
            throw $e;
        }
    }

    public function existsBySurchargeName(string $SurchargeName, ?string $excludeSurchargeId = null): bool
    {
        if ($excludeSurchargeId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM surcharge WHERE surcharge_name = ?");
            $stmt->execute([trim($SurchargeName)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM surcharge WHERE surcharge_name = ? AND id <> ?");
            $stmt->execute([trim($SurchargeName), $excludeSurchargeId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }
    // New methods to populate dropdowns
    public function getAllFeeCategories(): array
    {
        $stmt = $this->pdo->query("SELECT id, feeCategory_name FROM feeCategory ORDER BY feeCategory_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
