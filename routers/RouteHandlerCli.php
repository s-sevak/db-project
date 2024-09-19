<?php

class RouteHandlerCli
{
    private $userManager;
    private $outputHandler;

    public function __construct()
    {
        $envArr = (new EnvLoader())->loadEnv();

        if ($envArr['DB_SOURCE'] === 'mysql') {
            $dbConnection = (new Database())->getConnection();
            $userRepository = new UserRepositoryMysql($dbConnection);
        } else {
            $userRepository = new UserRepositoryJson();
        }

        $this->userManager = new UserManager($userRepository);
        $this->outputHandler = new OutputHandler();
    }

    public function handle($command, $userId = null)
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
