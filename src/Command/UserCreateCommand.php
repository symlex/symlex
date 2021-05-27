<?php

namespace App\Command;

use App\Model\User;
use App\Form\FormFactory;
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

    public function __construct($name, User $user, FormFactory $formFactory)
    {
        $this->user = $user;
        $this->formFactory = $formFactory;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Create a new user');

        $this->addArgument('email', InputArgument::REQUIRED, 'E-Mail');
        $this->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'Password');
        $this->addOption('firstname', 'f', InputOption::VALUE_REQUIRED, 'First Name', 'New');
        $this->addOption('lastname', 'l', InputOption::VALUE_REQUIRED, 'Last Name', 'User');
        $this->addOption('admin', 'a', InputOption::VALUE_NONE, 'Admin');
        $this->addOption('newsletter', null, InputOption::VALUE_NONE, 'Newsletter');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    : int {
        $form = $this->formFactory->create('User\Create');

        $values = $input->getOptions() + array('email' => $input->getArgument('email'));

        $form->setDefinedWritableValues(array(
            'userEmail' => $values['email'],
            'userFirstName' => $values['firstname'],
            'userLastName' => $values['lastname'],
            'userRole' => empty($values['admin']) ? 'user' : 'admin',
            'userNewsletter' => $values['newsletter']
        ))->validate();

        if ($form->hasErrors()) {
            $output->writeln('<error>' . $form->getErrorsAsText() . '</error>');
            return 1;
        }

        $password = $input->getOption('password');

        try {
            $this->user->transactional(function () use ($form, $password) {
                $this->user->save($form->getValues());

                if($password) {
                    $this->user->updatePassword($password);
                }
            });
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return 1;
        }

        $output->writeln('Created new user with ID ' . $this->user->getId());
    }
}