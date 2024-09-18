<?php


class EnvLoader
{
    private string $filePath;

    public function __construct(string $filePath = null)
    {
        $this->filePath = $filePath ?? dirname(__DIR__) . '/.env';
    }

    public function loadEnv(): array
    {
        $dbConnectData = [];

        if (!file_exists($this->filePath)) {
            print_r(".env файл не найден");
            die;
        }

        $lines = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);

            $key = trim($key);
            $value = trim($value);
            $dbConnectData[$key] = $value;
            if ($dbConnectData['DB_SOURCE'] === 'json') {
                break;
            }
        }

        return $dbConnectData;
    }

}
