<?php

require_once __DIR__ . '/CommandInterface.php';

class CommandAdd implements CommandInterface
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
        $this->userManager->addUser();
        $this->outputHandler->output("Пользователь добавлен");
    }
}
