<?php

require_once __DIR__ . '/UserRepositoryInterface.php';
require_once __DIR__ . '/../../src/Database/Database.php';
require_once __DIR__ . '/../../config/EnvLoader.php';

class UserRepositoryMysql implements UserRepositoryInterface
{
    private PDO $dbConnection;

    public function __construct(PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function getUsers(): array
    {
        $stmt = $this->dbConnection->query("SELECT * FROM users");
        $userDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($userDataArray as $userData) {
            $users[] = UserDTO::create($userData['id'], $userData['first_name'], $userData['last_name'], $userData['email']);
        }
        return $users;
    }

    public function saveUsers(array $users): void
    {
        $stmt = $this->dbConnection->prepare("INSERT INTO users (first_name, last_name, email) VALUES (:firstName, :lastName, :email)");
        foreach ($users as $user) {
            $stmt->execute([
                ':firstName' => $user->getFirstName(),
                ':lastName' => $user->getLastName(),
                ':email' => $user->getEmail(),
            ]);
        }
    }


    public function addUser(): void
    {
        $firstName = 'Имя_' . rand(1000, 9999);
        $lastName = 'Фамилия_' . rand(1000, 9999);
        $email = strtolower($firstName) . '@example.com';

        $stmt = $this->dbConnection->prepare("INSERT INTO users (first_name, last_name, email) VALUES (:firstName, :lastName, :email)");
        $stmt->execute([
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':email' => $email,
        ]);
    }

    public function deleteUser(int $id): void
    {
        $stmt = $this->dbConnection->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
