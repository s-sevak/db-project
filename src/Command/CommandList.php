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
            if (is_object($user)) {
                $id = $user->id;
                $firstName = $user->firstName;
                $lastName = $user->lastName;
                $email = $user->email;
            } elseif (is_array($user)) {
                $id = $user['id'];
                $firstName = $user['first_name'];
                $lastName = $user['last_name'];
                $email = $user['email'];
            } else {
                continue;
            }

            $this->outputHandler->output("ID: {$id} ||| Имя: {$firstName} ||| Фамилия: {$lastName} ||| Email: {$email}");
        }
    }

}
