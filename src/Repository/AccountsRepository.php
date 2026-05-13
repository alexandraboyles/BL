<?php
namespace App\Repository;

use PDO;
class AccountsRepository
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
        $sql = "SELECT a.*
                  FROM account a
              ORDER BY a.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT a.*
                  FROM account a
             WHERE a.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO account (account_name, description, display_when_no_value)
             VALUES (?, ?, ?)"
        );
        $stmt->execute([
            trim($data['account_name']),
            trim($data['description']),
            trim($data['display_when_no_value'])
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE account
                SET account_name = ?, description = ?, display_when_no_value = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            trim($data['account_name']),
            trim($data['description']),
            trim($data['display_when_no_value']),
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM account WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete account: it is referenced by other data.");
            }
            throw $e;
        }
    }

    public function existsByAccountName(string $AccountName, ?string $excludeAccountId = null): bool
    {
        if ($excludeAccountId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM account WHERE account_name = ?");
            $stmt->execute([trim($AccountName)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM account WHERE account_name = ? AND id <> ?");
            $stmt->execute([trim($AccountName), $excludeAccountId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }
}
