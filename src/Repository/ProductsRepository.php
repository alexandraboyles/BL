<?php
namespace App\Repository;

use PDO;
class ProductsRepository
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
        $sql = "SELECT p.*, 
                       c.customer_name AS customer_name
                  FROM Product p
             LEFT JOIN Customer c ON p.customer_id = c.id
              ORDER BY p.product_id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT p.*, 
                       c.customer_name AS customer_name
                  FROM Product p
             LEFT JOIN Customer c ON p.customer_id = c.id
             WHERE p.product_id = ?
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
            "INSERT INTO Product (id, product_id, customer_id, title, description, sku, unitOfMeasure, width, length, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $uuid,
            (int)$data['product_id'],
            $data['customer_id'],
            trim($data['title']),
            trim($data['description']),
            trim($data['sku']),
            trim($data['unitOfMeasure']),
            $data['width'],
            $data['length'],
            $data['height'],
            $data['weight']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function update(int $originalProductId, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE Product
                SET product_id = ?, customer_id = ?, title = ?, description = ?, sku = ?, unitOfMeasure = ?, width = ?, length = ?, height = ?, weight = ?
              WHERE product_id = ?"
        );
        return $stmt->execute([
            (int)$data['product_id'],
            $data['customer_id'],
            trim($data['title']),
            trim($data['description']),
            trim($data['sku']),
            trim($data['unitOfMeasure']),
            $data['width'],
            $data['length'],
            $data['height'],
            $data['weight'],
            $originalProductId
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Product WHERE product_id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete product: it is referenced by other data.");
            }
            throw $e;
        }
    }
    public function existsById(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Product WHERE product_id = ?");
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }

        public function existsByTitle(string $Title, ?string $excludeProductId = null): bool
    {
        if ($excludeProductId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Product WHERE title = ?");
            $stmt->execute([trim($Title)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Product WHERE title = ? AND product_id <> ?");
            $stmt->execute([trim($Title), $excludeProductId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

        public function existsBySKU(string $SKU, ?string $excludeProductId = null): bool
    {
        if ($excludeProductId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Product WHERE sku = ?");
            $stmt->execute([trim($SKU)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Product WHERE sku = ? AND product_id <> ?");
            $stmt->execute([trim($SKU), $excludeProductId]);
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



