<?php

require_once __DIR__ . '/OutputInterface.php';

class OutputHandler implements OutputInterface
{
    public function output(string $message): void
    {
        echo $message . PHP_EOL;
    }
}
