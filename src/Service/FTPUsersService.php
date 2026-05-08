<?php
namespace App\Service;

use App\Repository\FTPUsersRepository;
use App\Validation\FTPUsersValidator;
use InvalidArgumentException;

class FTPUsersService
{
    private $repo;
    private $validator;

    public function __construct()
    {
        $this->repo = new FTPUsersRepository();
        $this->validator = new FTPUsersValidator();
    }

    public function getAll(): array
    {
        return $this->repo->findAll();
    }

    public function getById(int $id): ?array
    {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid ID");
        }
        return $this->repo->find($id);
    }

    public function create(array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ($this->repo->existsByFTPUserId((int)$data['ftpUser_id'])) {
            return ["FTP User ID is already in use."];
        }

        if ($this->repo->existsByUsername(trim($data['username']))) {
            return ["Username is already in use."];
        }

        $this->repo->save($data);
        return true;
    }

    public function update(int $originalFTPUserId, array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ((int)$originalFTPUserId !== (int)$data['ftpUser_id'] && $this->repo->existsByFTPUserId((int)$data['ftpUser_id'])) {
            return ["FTP User ID is already in use."];
        }

        if ($this->repo->existsByUsername(trim($data['username']), (int)$originalFTPUserId)) {
            return ["Username is already in use."];
        }

        return $this->repo->update($originalFTPUserId, $data);
    }

    public function delete(int $id): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid ID");
        }
        return $this->repo->delete($id);
    }
}
