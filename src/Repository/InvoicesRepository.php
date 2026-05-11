<?php
namespace App\Repository;

use PDO;
class InvoicesRepository
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
        $sql = "SELECT i.*, 
                       c.customer_name AS customer_name,
                       rc.rates AS rateCard_name,
                       m.id AS manifest_human_id
                  FROM Invoice i
             LEFT JOIN Customer c ON i.customer_id = c.id
             LEFT JOIN rateCard rc ON i.rateCard_id = rc.id
             LEFT JOIN manifest m ON i.manifest_id = m.id
              ORDER BY i.invoice_id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT i.*, 
                       c.customer_name AS customer_name,
                       rc.rates AS rateCard_name,
                       m.id AS manifest_human_id
                  FROM Invoice i
             LEFT JOIN Customer c ON i.customer_id = c.id
             LEFT JOIN rateCard rc ON i.rateCard_id = rc.id
             LEFT JOIN manifest m ON i.manifest_id = m.id
             WHERE i.invoice_id = ?
        ";
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
            "INSERT INTO Invoice (id, invoice_id, customer_id, rateCard_id, manifest_id, income, expense, startDate, endDate, status, paymentStatus, emailStatus, internalReference, externalReference) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $uuid,
            (int)$data['invoice_id'],
            $data['customer_id'],
            (int)$data['rateCard_id'],
            (int)$data['manifest_id'],
            (float)$data['income'],
            (float)$data['expense'],
            $data['startDate'],
            $data['endDate'],
            trim($data['status']),
            trim($data['paymentStatus']),
            trim($data['emailStatus']),
            trim($data['internalReference']),
            trim($data['externalReference'])
        ]);
        return $this->pdo->lastInsertId();
    }

    public function update(int $originalInvoiceId, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE Invoice
                SET invoice_id = ?, customer_id = ?, rateCard_id = ?, manifest_id = ?, income = ?, expense = ?, startDate = ?, endDate = ?, status = ?, paymentStatus = ?, emailStatus = ?, internalReference = ?, externalReference = ?
              WHERE invoice_id = ?"
        );
        return $stmt->execute([
            (int)$data['invoice_id'],
            $data['customer_id'],
            (int)$data['rateCard_id'],
            (int)$data['manifest_id'],
            (float)$data['income'],
            (float)$data['expense'],
            $data['startDate'],
            $data['endDate'],
            trim($data['status']),
            trim($data['paymentStatus']),
            trim($data['emailStatus']),
            trim($data['internalReference']),
            trim($data['externalReference']),
            $originalInvoiceId
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Invoice WHERE invoice_id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete invoice: it is referenced by other data.");
            }
            throw $e;
        }
    }
    public function existsById(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Invoice WHERE invoice_id = ?");
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }

    // New methods to populate dropdowns
    public function getAllCustomers(): array
    {
        $stmt = $this->pdo->query("SELECT id, customer_name FROM Customer ORDER BY customer_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllRateCards(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM rateCard ORDER BY rates");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllManifests(): array
    {
        $stmt = $this->pdo->query("SELECT id FROM manifest ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}



