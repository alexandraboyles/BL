<?php
namespace App\Repository;

use PDO;
class ParsersRepository
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
                  FROM parser p
             LEFT JOIN Customer c ON p.customer_id = c.id
              ORDER BY p.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find(int $id): ?array
    {
        $sql = "SELECT p.*, 
                       c.customer_name AS customer_name
                  FROM parser p
             LEFT JOIN Customer c ON p.customer_id = c.id
              WHERE p.id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO parser (id, customer_id, parser_name, className, class, type, acceptedFileTypes, toAddress)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            (int)$data['id'],
            $data['customer_id'],
            trim($data['parser_name']),
            trim($data['className']),
            trim($data['class']),
            trim($data['type']),
            trim($data['acceptedFileTypes']),
            trim($data['toAddress'])
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE parser
                SET id = ?, customer_id = ?, parser_name = ?, className = ?, class = ?, type = ?, acceptedFileTypes = ?, toAddress = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            (int)$data['id'],
            $data['customer_id'],
            trim($data['parser_name']),
            trim($data['className']),
            trim($data['class']),
            trim($data['type']),
            trim($data['acceptedFileTypes']),
            trim($data['toAddress']),
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM parser WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete parser: it is referenced by other data.");
            }
            throw $e;
        }
    }
    public function existsById(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM parser WHERE id = ?");
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function existsByParserName(string $ParserName, ?string $excludeParserId = null): bool
    {
        if ($excludeParserId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM parser WHERE parser_name = ?");
            $stmt->execute([trim($ParserName)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM parser WHERE parser_name = ? AND id <> ?");
            $stmt->execute([trim($ParserName), $excludeParserId]);
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
