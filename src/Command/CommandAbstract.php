<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Commands are configured as service in app/config/console.yml
 */
class CommandAbstract extends Command
{
    /**
     * @param string $question
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool
     */
    protected function canExecute(string $question, InputInterface $input, OutputInterface $output): bool
    {
        if ($input->isInteractive() && !$this->askConfirmation($question, $input, $output)) {
            return false;
        }

        return true;
    }

    /**
     * @param $question
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    protected function askConfirmation(string $question, InputInterface $input, OutputInterface $output)
    {
        return $this->getHelper('question')->ask($input, $output, new ConfirmationQuestion($question));
    }
}