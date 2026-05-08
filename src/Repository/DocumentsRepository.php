<?php
namespace App\Repository;

use PDO;
class DocumentsRepository
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
        $sql = "SELECT d.*, 
                       so.saleOrder_id AS saleOrder_human_id, 
                       c.customer_name, 
                       co.consignment_id AS consignment_human_id
                  FROM document d
             LEFT JOIN saleOrder so ON d.saleOrder_id = so.id
             LEFT JOIN Customer c ON d.customer_id = c.id
             LEFT JOIN Consignment co ON d.consignment_id = co.id
              ORDER BY d.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find(int $id): ?array
    {
        $sql = "SELECT d.*, 
                       so.saleOrder_id AS saleOrder_human_id, 
                       c.customer_name, 
                       co.consignment_id AS consignment_human_id
                  FROM document d
             LEFT JOIN saleOrder so ON d.saleOrder_id = so.id
             LEFT JOIN Customer c ON d.customer_id = c.id
             LEFT JOIN Consignment co ON d.consignment_id = co.id
             WHERE d.id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO document (id, saleOrder_id, customer_id, consignment_id, fileType)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['id'],
            $data['saleOrder_id'],
            $data['customer_id'],
            $data['consignment_id'],
            trim($data['fileType'])
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE document
                SET id = ?, saleOrder_id = ?, customer_id = ?, consignment_id = ?, fileType = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            $data['id'],
            $data['saleOrder_id'],
            $data['customer_id'],
            $data['consignment_id'],
            trim($data['fileType']),
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM  document WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete document: it is referenced by other data.");
            }
            throw $e;
        }
    }
    public function existsById(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM document WHERE id = ?");
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }
    // New methods to populate dropdowns
    public function getAllSaleOrders(): array
    {
        $stmt = $this->pdo->query("SELECT id, saleOrder_id FROM saleOrder ORDER BY saleOrder_id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllCustomers(): array
    {
        $stmt = $this->pdo->query("SELECT id, customer_name FROM Customer ORDER BY customer_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllConsignments(): array
    {
        $stmt = $this->pdo->query("SELECT id, consignment_id FROM Consignment ORDER BY consignment_id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
