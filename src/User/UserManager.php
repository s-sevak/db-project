<?php

require_once __DIR__ . '/UserRepositoryJson.php';
require_once __DIR__ . '/UserRepositoryMysql.php';

class UserManager
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers(): array
    {
        return $this->userRepository->getUsers();
    }

    public function saveUsers(array $users): void
    {
        $this->userRepository->saveUsers($users);
    }

    public function addUser(): void
    {
        $this->userRepository->addUser();
    }

    public function deleteUser(int $id): void
    {
        $this->userRepository->deleteUser($id);
    }
}
