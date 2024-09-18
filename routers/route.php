<?php

require_once __DIR__ . '/../config/EnvLoader.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../src/User/UserRepositoryMysql.php';
require_once __DIR__ . '/../src/User/UserRepositoryJson.php';
require_once __DIR__ . '/../src/User/UserManager.php';
require_once __DIR__ . '/../src/Output/OutputHandler.php';
require_once __DIR__ . '/../src/Command/CommandList.php';
require_once __DIR__ . '/../src/Command/CommandAdd.php';
require_once __DIR__ . '/../src/Command/CommandDelete.php';

$envArr = (new EnvLoader())->loadEnv();

if ($envArr['DB_SOURCE'] === 'mysql') {

    $dbConnection = (new Database())->getConnection();
    $userRepository = new UserRepositoryMysql($dbConnection);
} else {

    $userRepository = new UserRepositoryJson();
}


$userManager = new UserManager($userRepository);
$outputHandler = new OutputHandler();

$command = $argv[1] ?? null;

switch ($command) {
    case 'list':
        $commandHandler = new CommandList($userManager, $outputHandler);
        $commandHandler->execute();
        break;

    case 'add':
        $commandHandler = new CommandAdd($userManager, $outputHandler);
        $commandHandler->execute();
        break;

    case 'delete':
        $userId = $argv[2] ?? null;
        if ($userId) {
            $commandHandler = new CommandDelete($userManager, $outputHandler);
            $commandHandler->execute($userId);
        } else {
            $outputHandler->output("Укажите ID пользователя для удаления");
        }
        break;

    default:
        $outputHandler->output('Неизвестная команда');
}
