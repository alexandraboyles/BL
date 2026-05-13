<?php
namespace App\Repository;

use PDO;

class UsersRepository
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
        $sql = "SELECT u.*, 
                       c.customer_name AS customer_name,
                       w.warehouse AS warehouse
                  FROM user u
             LEFT JOIN customer c ON u.customer_id = c.id
             LEFT JOIN warehouses w ON u.warehouses_id = w.id
             ORDER BY u.fullName DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(string $id): ?array
    {
        $sql = "SELECT u.*, 
                       c.customer_name AS customer_name,
                       w.warehouse AS warehouse
                  FROM user u
             LEFT JOIN customer c ON u.customer_id = c.id
             LEFT JOIN warehouses w ON u.warehouses_id = w.id
             WHERE u.id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result['roles']) {
            $result['roles_id'] = json_decode($result['roles'], true) ?: [];
        } else {
            $result['roles_id'] = [];
        }
        return $result ?: null;
    }

    public function save(array $data): string
    {
        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            random_int(0, 0xffff), random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000,
            random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff)
        );
    
        $rolesId = $data['roles_id'] ?? [];
        $rolesJson = !empty($rolesId) ? json_encode($rolesId) : null;

        $stmt = $this->pdo->prepare(
            "INSERT INTO user (id, customer_id, fullName, email, warehouses_id, mfa, is_email_verified, roles) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $uuid,
            $data['customer_id'],
            trim($data['fullName']),
            trim($data['email']),
            $data['warehouses_id'],
            trim($data['mfa']),
            (int)$data['is_email_verified'],
            $rolesJson
        ]);

        return $uuid;
    }

    public function update(string $originalUserId, array $data): bool
    {
        $rolesId = $data['roles_id'] ?? [];
        $rolesJson = !empty($rolesId) ? json_encode($rolesId) : null;

        $stmt = $this->pdo->prepare(
            "UPDATE user SET customer_id = ?, fullName = ?, email = ?, warehouses_id = ?, mfa = ?, is_email_verified = ?, roles = ? WHERE id = ?"
        );
        return $stmt->execute([
            $data['customer_id'],
            trim($data['fullName']),
            trim($data['email']),
            $data['warehouses_id'],
            trim($data['mfa']),
            (int)$data['is_email_verified'],
            $rolesJson,
            $originalUserId
        ]);
    }

    public function delete(string $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM user WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete user: it is referenced by other data.");
            }
            throw $e;
        }
    }

    public function existsByFullName(string $FullName, ?string $excludeUserId = null): bool
    {
        if ($excludeUserId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM user WHERE fullName = ?");
            $stmt->execute([trim($FullName)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM user WHERE fullName = ? AND id <> ?");
            $stmt->execute([trim($FullName), $excludeUserId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

    public function existsByEmail(string $Email, ?string $excludeUserId = null): bool
    {
        if ($excludeUserId === null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
            $stmt->execute([trim($Email)]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM user WHERE email = ? AND id <> ?");
            $stmt->execute([trim($Email), $excludeUserId]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

    // New method to populate dropdowns
    public function getAllCustomers(): array
    {
        $stmt = $this->pdo->query("SELECT id, customer_name FROM Customer ORDER BY customer_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllRoles(): array
    {
        $stmt = $this->pdo->query("SELECT id, role_name FROM roles ORDER BY role_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllWarehouses(): array
    {
        $stmt = $this->pdo->query("SELECT id, warehouse FROM warehouses ORDER BY warehouse");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}