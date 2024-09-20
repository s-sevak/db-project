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
require_once __DIR__ . '/RouteHandlerFpmfcgi.php';


switch (PHP_SAPI) {
    case 'cli':
        $routeHandler = new RouteHandlerCli();
        $command = $argv[1] ?? null;
        $userId = $argv[2] ?? null;
        $routeHandler->handle($command, $userId);
        break;

    case 'fpm-fcgi':
        $handler = new RouteHandlerFpmfcgi();
        $handler->handleRequest();
        break;

    default:
        http_response_code(503);
        echo json_encode(['error' => 'Этот проект может работать только в режиме CLI или FPM/FastCGI.'], JSON_UNESCAPED_UNICODE);
        exit;
}
