<?php
require_once __DIR__ . '/../config/EnvLoader.php';

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $dbSet = (new EnvLoader())->loadEnv();

        $host = $dbSet['DB_HOST'];
        $dbname = $dbSet['DB_NAME'];
        $username = $dbSet['DB_USERNAME'];
        $password = $dbSet['DB_PASSWORD'];

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(json_encode(["error" => "Ошибка подключения: " . $e->getMessage()]));
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
