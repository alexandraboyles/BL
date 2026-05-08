<?php
namespace App\Repository;

use PDO;

class FTPUsersRepository
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
        $stmt = $this->pdo->query("SELECT * FROM ftpUser ORDER BY ftpUser_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM ftpUser WHERE ftpUser_id = ?");
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
            "INSERT INTO ftpUser (id, ftpUser_id, username, password, subDirectory) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $uuid,
            (int)$data['ftpUser_id'],
            trim($data['username']),
            trim($data['password']),
            trim($data['subDirectory'])
        ]);
        return $this->pdo->lastInsertId();
    }

    public function update(int $originalFTPUserId, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE ftpUser SET ftpUser_id = ?, username = ?, password = ?, subDirectory = ? WHERE ftpUser_id = ?"
        );
        return $stmt->execute([
            (int)$data['ftpUser_id'],
            trim($data['username']),
            trim($data['password']),
            trim($data['subDirectory']),
            $originalFTPUserId
        ]);
    }

    public function existsByFTPUserId(int $ftpUserId): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM ftpUser WHERE ftpUser_id = ?");
        $stmt->execute([$ftpUserId]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function existsByUsername(string $username, ?int $excludeFTPUserId = null): bool
    {
        if ($excludeFTPUserId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM ftpUser WHERE username = ?");
            $stmt->execute([trim($username)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM ftpUser WHERE username = ? AND ftpUser_id <> ?");
            $stmt->execute([trim($username), $excludeFTPUserId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM ftpUser WHERE ftpUser_id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete FTP user: it is referenced by other data.");
            }
            throw $e;
        }
    }
}