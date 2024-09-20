<?php

require_once __DIR__ . '/CommandInterface.php';

class CommandDelete implements CommandInterface
{
    private UserManager $userManager;
    private OutputHandler $outputHandler;

    public function __construct(UserManager $userManager, OutputHandler $outputHandler)
    {
        $this->userManager = $userManager;
        $this->outputHandler = $outputHandler;
    }

    public function execute(...$params): void
    {
        $userId = $params[0] ?? null;

        if ($userId) {
            $this->userManager->deleteUser($userId);

            $this->outputHandler->output("Пользователь с ID $userId удалён!");
        } else {
            $this->outputHandler->output("Укажите ID пользователя для удаления");
        }
    }
}
