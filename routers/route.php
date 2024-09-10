<?php

require_once __DIR__ . '/../src/UserManager.php';

$command = $argv[1] ?? null;
$userManager = new UserManager('users.json');

switch ($command) {
    case 'list':
        $users = $userManager->getUsers();
        foreach ($users as $user) {
            echo "ID: {$user->id}  ||| Имя: {$user->firstName} ||| Фамилия: {$user->lastName} ||| Email: {$user->email}" . PHP_EOL;
        }
        break;

    case 'add':
        $userManager->addUser();
        echo 'Пользователь добавлен';
        break;

    case 'delete':
        $userId = $argv[2] ?? null;
        if ($userId) {
            $userManager->deleteUser($userId);
            echo "Пользователь номер $userId удалён!" . PHP_EOL;
        } else {
            echo "Укажите ID пользователя для удаления" . PHP_EOL;
        }
        break;
}
