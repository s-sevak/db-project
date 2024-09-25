<?php

class RouteHandler
{
    protected UserManager $userManager;
    protected OutputHandler $outputHandler;

    protected function initializeUserManager(): void
    {
        $envArr = EnvLoader::createAndLoadEnv();

        if ($envArr['DB_SOURCE'] === 'mysql') {
            $dbConnection = (new Database())->getConnection();
            $userRepository = new UserRepositoryMysql($dbConnection);
        } else {
            $userRepository = new UserRepositoryJson();
        }

        $this->userManager = new UserManager($userRepository);
        $this->outputHandler = new OutputHandler();
    }
}
