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
require_once __DIR__ . '/RouteHandlerCli.php';


$routeHandler = new RouteHandlerCli();
$command = $argv[1] ?? null;
$userId = $argv[2] ?? null;

$routeHandler->handle($command, $userId);
