<?php

namespace App\Command;

use App\Model\User;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Commands are configured as service in app/config/console.yml
 */
class UserDeleteCommand extends CommandAbstract
{
    protected $user;

    public function __construct($name, User $user)
    {
        $this->user = $user;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Delete a user');

        $this->addArgument('email', InputArgument::REQUIRED, 'E-Mail');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    : int {
        $email = $input->getArgument('email');

        try {
            $user = $this->user->findByEmail($email);
            $userId = $user->getId();
            $user->delete();
            $output->writeln('Deleted user with ID ' . $userId);

            return 0;
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');

            return 1;
        }
    }
}