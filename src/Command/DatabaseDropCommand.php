<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\DBAL\Connection;

/**
 * Creates a database
 */
class DatabaseDropCommand extends Command
{
    protected $connection;

    public function __construct($name, Connection $connection)
    {
        $this->connection = $connection;

        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $db = $this->connection;

        $db->exec("DROP DATABASE `{$db->getDatabase()}`");
        $output->writeln('<info>Database "' . $db->getDatabase() . '" dropped</info>');
    }
}
