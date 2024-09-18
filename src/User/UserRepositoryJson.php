<?php

require_once __DIR__ . '/UserRepositoryInterface.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/../../config/EnvLoader.php';

class UserRepositoryJson implements UserRepositoryInterface
{
    private string $file;

    public function __construct()
    {

        $this->file = __DIR__ . '/../../routersusers.json';
    }

    public function getUsers(): array
    {
        if (!file_exists($this->file)) {
            return [];
        }

        $jsonData = file_get_contents($this->file);
        $userArray = json_decode($jsonData, true);

        $users = [];
        foreach ($userArray as $userData) {
            $users[] = new User($userData['id'], $userData['firstName'], $userData['lastName'], $userData['email']);
        }
        return $users;
    }

    public function saveUsers(array $users): void
    {
        $userArray = [];
        foreach ($users as $user) {
            $userArray[] = [
                'id' => $user->id,
                'firstName' => $user->firstName,
                'lastName' => $user->lastName,
                'email' => $user->email
            ];
        }
        file_put_contents($this->file, json_encode($userArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function addUser(): void
    {
        $users = $this->getUsers();
        $lastUser = count($users) > 0 ? end($users) : null;
        $lastId = $lastUser ? $lastUser->id : 0;
        $newId = $lastId + 1;


        $firstName = 'Имя_' . $newId;
        $lastName = 'Фамилия_' . $newId;
        $email = $firstName . '@' . $lastName . '.com';

        $user = new User($newId, $firstName, $lastName, $email);
        $users[] = $user;

        $this->saveUsers($users);
    }

    public function deleteUser(int $id): void
    {
        $users = $this->getUsers();
        $updatedUsers = array_filter($users, function ($user) use ($id) {
            return $user->id != $id;
        });

        $this->saveUsers($updatedUsers);
    }
}
