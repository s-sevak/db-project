<?php

require_once __DIR__ . '/../src/User.php';

class UserManager
{
    private $file;

    public function __construct($filePath)
    {
        $this->file = $filePath;
    }

    public function getUsers(): array
    {
        if (!file_exists($this->file)) {
            return [];
        }

        $jsonData = file_get_contents($this->file);
        $userArray = json_decode($jsonData, true);

        $users = [];
        print_r($userArray);
        foreach ($userArray as $userData) {
            $users[] = new User($userData['id'], $userData['firstName'], $userData['lastName'], $userData['email']);
        }
        return $users;
    }

    public function saveUsers($users): void
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

    public function deleteUser($id): void
    {
        $users = $this->getUsers();
        $updatedUsers = array_filter($users, function ($user) use ($id) {
            return $user->id != $id;
        });

        $this->saveUsers($updatedUsers);
    }
}
