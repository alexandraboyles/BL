<?php
namespace App\Repository;

use PDO;
class FeeCategoriesRepository
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
        $sql = "SELECT fg.*
                  FROM feeCategory fg
              ORDER BY fg.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT fg.*
                  FROM feeCategory fg
             WHERE fg.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO feeCategory (appliesTo, account, feeCategory_name, counts_toward_minimum_charges, is_name_editable)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            trim($data['appliesTo']),
            trim($data['account']),
            trim($data['feeCategory_name']),
            trim($data['counts_toward_minimum_charges']),
            trim($data['is_name_editable'])
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE feeCategory
                SET appliesTo = ?, account = ?, feeCategory_name = ?, counts_toward_minimum_charges = ?, is_name_editable = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            trim($data['appliesTo']),
            trim($data['account']),
            trim($data['feeCategory_name']),
            trim($data['counts_toward_minimum_charges']),
            trim($data['is_name_editable']),
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM feeCategory WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete fee category: it is referenced by other data.");
            }
            throw $e;
        }
    }

    public function existsByFeeCategoryName(string $FeeCategoryName, ?string $excludeFeeCategoryId = null): bool
    {
        if ($excludeFeeCategoryId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM feeCategory WHERE feeCategory_name = ?");
            $stmt->execute([trim($FeeCategoryName)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM feeCategory WHERE feeCategory_name = ? AND id <> ?");
            $stmt->execute([trim($FeeCategoryName), $excludeFeeCategoryId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }
}
