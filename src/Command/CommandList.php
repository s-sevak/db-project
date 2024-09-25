<?php

require_once __DIR__ . '/CommandInterface.php';


class CommandList implements CommandInterface
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
        $users = $this->userManager->getUsers();

        foreach ($users as $user) {
            $id = $user->getId();
            $firstName = $user->getFirstName();
            $lastName = $user->getLastName();
            $email = $user->getEmail();

            $this->outputHandler->output("ID: {$id} ||| Имя: {$firstName} ||| Фамилия: {$lastName} ||| Email: {$email}");
        }
    }
}
