<?php

namespace App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\DBAL\Connection;

/**
 * Commands are configured as service in app/config/console.yml
 */
class DatabaseDropCommand extends CommandAbstract
{
    protected $connection;

    public function __construct($name, Connection $connection)
    {
        $this->connection = $connection;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Drop the database configured in app/config/parameters.yml');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    : int {
        $db = $this->connection;

        $question = 'Are you sure you wish to drop the database "' . $db->getDatabase() . '"? (y/n)';

        if (! $this->canExecute($question, $input, $output)) {
            $output->writeln('<error>Database "' . $db->getDatabase() . '" was not dropped</error>');

            return 1;
        }

        try {
            $db->exec("DROP DATABASE `{$db->getDatabase()}`");
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return 1;
        }

        $output->writeln('<info>Database "' . $db->getDatabase() . '" dropped</info>');
    }
}
