<?php
namespace App\Repository;

use PDO;
class BillsRepository
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
        $sql = "SELECT b.*, 
                       s.companyName AS supplier_name, 
                       i.invoice_id AS invoice_id,
                       m.id AS manifest_id
                  FROM bill b
             LEFT JOIN supplier s ON b.supplier_id = s.id
             LEFT JOIN invoice i ON b.invoice_id = i.id
             LEFT JOIN manifest m ON b.manifest_id = m.id
              ORDER BY b.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT b.*, 
                       s.companyName AS supplier_name, 
                       i.invoice_id AS invoice_id,
                       m.id AS manifest_id
                  FROM bill b
             LEFT JOIN supplier s ON b.supplier_id = s.id
             LEFT JOIN invoice i ON b.invoice_id = i.id
             LEFT JOIN manifest m ON b.manifest_id = m.id
             WHERE b.id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO bill (supplier_id, invoice_id, manifest_id)
             VALUES (?, ?, ?)"
        );
        $stmt->execute([
            $data['supplier_id'],
            $data['invoice_id'],
            $data['manifest_id']
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE bill 
                SET supplier_id = ?, invoice_id = ?, manifest_id = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            $data['supplier_id'],
            $data['invoice_id'],
            $data['manifest_id'],
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM bill WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete bill: it is referenced by other data.");
            }
            throw $e;
        }
    }
    // New methods to populate dropdowns
    public function getAllSuppliers(): array
    {
        $stmt = $this->pdo->query("SELECT id, companyName FROM supplier ORDER BY companyName");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllInvoices(): array
    {
        $stmt = $this->pdo->query("SELECT id, invoice_id FROM Invoice ORDER BY invoice_id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllManifests(): array
    {
        $stmt = $this->pdo->query("SELECT id FROM manifest ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
