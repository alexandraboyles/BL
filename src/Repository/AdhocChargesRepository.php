<?php
namespace App\Repository;

use PDO;
class AdhocChargesRepository
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
        $sql = "SELECT ac.*
                  FROM adhocCharge ac
              ORDER BY ac.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT ac.*
                  FROM adhocCharge ac
             WHERE ac.id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO adhocCharge (id, adhocCharge_name, chargeStructure, rate, descriptionTemplate, is_enabled, pageVisionOn)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['id'],
            trim($data['adhocCharge_name']),
            trim($data['chargeStructure']),
            $data['rate'],
            trim($data['descriptionTemplate']),
            $data['is_enabled'],
            trim($data['pageVisionOn'])
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE adhocCharge
                SET id = ?, adhocCharge_name = ?, chargeStructure = ?, rate = ?, descriptionTemplate = ?, is_enabled = ?, pageVisionOn = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            $data['id'],
            trim($data['adhocCharge_name']),
            trim($data['chargeStructure']),
            $data['rate'],
            trim($data['descriptionTemplate']),
            $data['is_enabled'],
            trim($data['pageVisionOn']),
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM adhocCharge WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete adhoc charge: it is referenced by other data.");
            }
            throw $e;
        }
    }
    public function existsById(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM adhocCharge WHERE id = ?");
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }
}
