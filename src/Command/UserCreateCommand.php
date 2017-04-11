<?php

namespace App\Command;

use App\Model\User;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Commands are configured as service in app/config/console.yml
 */
class UserCreateCommand extends AbstractCommand
{
    protected $user;

    public function __construct($name, User $user)
    {
        $this->user = $user;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument('email', InputArgument::REQUIRED, 'E-Mail');
        $this->addArgument('password', InputArgument::REQUIRED, 'Password');

        parent::configure();

        $this->setDescription('Creates a new user without validation of email or password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $this->user->save(array(
            'email' => $email,
            'password' => $passwordHash
        ));

        $output->writeln('Created new user with ID ' . $this->user->getId());
    }
}