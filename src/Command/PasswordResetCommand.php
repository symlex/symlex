<?php

namespace App\Command;

use App\Service\Mail;
use App\Model\UserModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Commands are configured as service in app/config/console.yml
 */
class PasswordResetCommand extends Command
{
    protected $mail;
    protected $user;

    public function __construct($name, Mail $mail, UserModel $user)
    {
        $this->mail = $mail;
        $this->user = $user;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument('email', InputArgument::REQUIRED, 'User E-Mail');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');

        $user = $this->user->findByEmail($email);

        $this->mail->passwordReset($user);
    }
}
