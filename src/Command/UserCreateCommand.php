<?php

namespace App\Command;

use App\Model\User;
use InputValidation\Form\Factory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Commands are configured as service in app/config/console.yml
 */
class UserCreateCommand extends CommandAbstract
{
    protected $user;
    protected $formFactory;

    public function __construct($name, User $user, Factory $formFactory)
    {
        $this->user = $user;
        $this->formFactory = $formFactory;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Creates a new user');

        $this->addArgument('email', InputArgument::REQUIRED, 'E-Mail');
        $this->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'Password');
        $this->addOption('firstname', 'f', InputOption::VALUE_REQUIRED, 'First Name', 'New');
        $this->addOption('lastname', 'l', InputOption::VALUE_REQUIRED, 'Last Name', 'User');
        $this->addOption('admin', 'a', InputOption::VALUE_NONE, 'Admin');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $form = $this->formFactory->create('User');

        $values = $input->getOptions() + array('email' => $input->getArgument('email'));

        $form->setDefinedWritableValues($values)->validate();

        if ($form->hasErrors()) {
            $output->writeln('<error>' . $form->getErrorsAsText() . '</error>');
            return 1;
        }

        $password = $input->getOption('password');

        try {
            $this->user->transactional(function () use ($form, $password) {
                $this->user->save($form->getValues());
                $this->user->updatePassword($password);
            });
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return 1;
        }

        $output->writeln('Created new user with ID ' . $this->user->getId());
    }
}