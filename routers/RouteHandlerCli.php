<?php

require_once __DIR__ . '/RouteHandler.php';

class RouteHandlerCli extends RouteHandler
{

    public function __construct()
    {
        $this->initializeUserManager();
    }

    public function handle($command, $userId = null): void
    {
        switch ($command) {
            case 'list':
                $commandHandler = new CommandList($this->userManager, $this->outputHandler);
                $commandHandler->execute();
                break;

            case 'add':
                $commandHandler = new CommandAdd($this->userManager, $this->outputHandler);
                $commandHandler->execute();
                break;

            case 'delete':
                if ($userId) {
                    $commandHandler = new CommandDelete($this->userManager, $this->outputHandler);
                    $commandHandler->execute($userId);
                } else {
                    $this->outputHandler->output("Укажите ID пользователя для удаления");
                }
                break;

            default:
                $this->outputHandler->output('Неизвестная команда');
        }
    }
}
