<?php

require_once __DIR__ . '/../src/User/UserRepositoryMysql.php';
require_once __DIR__ . '/../config/Database.php';

class RouteHandlerFpmfcgi
{
    private $userManager;

    public function __construct()
    {
        $pdo = (new Database())->getConnection();
        $this->userManager = new UserRepositoryMysql($pdo);
    }

    public function handleRequest()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];
        $uriParts = explode('/', trim($requestUri, '/'));
        $resource = $uriParts[0];
        $id = $uriParts[1] ?? null;

        switch ($requestMethod) {
            case 'GET':
                if ($resource === 'list-users') {
                    $this->listUsers();
                }
                break;

            case 'POST':
                if ($resource === 'create-user') {
                    $this->createUser();
                }
                break;

            case 'DELETE':
                if ($resource === 'delete-user' && $id) {
                    $this->deleteUser((int)$id);
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Не передан id пользователя для удаления'], JSON_UNESCAPED_UNICODE);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(['error' => 'Метод не поддерживается'], JSON_UNESCAPED_UNICODE);
                break;
        }
    }

    private function listUsers()
    {
        header('Content-Type: application/json');
        echo json_encode($this->userManager->getUsers(), JSON_UNESCAPED_UNICODE);
    }

    private function createUser()
    {
        $inputData = json_decode(file_get_contents('php://input'), true);

        if (!isset($inputData['firstName'], $inputData['lastName'], $inputData['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Недостаточно данных для создания пользователя'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $user = [
            'firstName' => $inputData['firstName'],
            'lastName' => $inputData['lastName'],
            'email' => $inputData['email']
        ];

        $this->userManager->saveUsers([$user]);
        http_response_code(201);
        echo json_encode(['message' => 'Пользователь создан'], JSON_UNESCAPED_UNICODE);
    }

    private function deleteUser(int $id)
    {
        $this->userManager->deleteUser($id);
        http_response_code(200);
        echo json_encode(['message' => 'Пользователь удален'], JSON_UNESCAPED_UNICODE);
    }
}
