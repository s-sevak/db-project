<?php


class EnvLoader
{
    private static ?array $dbConnectData = null;
    private string $filePath;

    public function __construct(string $filePath = null)
    {
        $this->filePath = $filePath ?? dirname(__DIR__) . '/.env';
    }

    public function loadEnv(): array
    {
        $instance = new self();
        $dbConnectData = [];

        if (!file_exists($instance->filePath)) {
            print_r(".env файл не найден");
            die;
        }

        $lines = file($instance->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);

            $key = trim($key);
            $value = trim($value);
            $dbConnectData[$key] = $value;
            if ($dbConnectData['DB_SOURCE'] === 'json') {
                break;
            }
        }

        return $dbConnectData;
    }

    public static function createAndLoadEnv(): array
    {
        $instance = new self();
        return $instance->loadEnv();
    }
}
