<?php

namespace App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\DBAL\Connection;

/**
 * Commands are configured as service in app/config/console.yml
 */
class DatabaseCreateCommand extends AbstractCommand
{
    protected $connection;

    public function __construct($name, Connection $connection)
    {
        $this->connection = $connection;

        parent::__construct($name);

        $this->setDescription('Creates a new database with the name configured in app/config/parameters.yml');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $db = $this->connection;
        $params = $db->getParams();
        unset($params['dbname']);

        $connection = new Connection($params, $db->getDriver());

        $connection->exec("CREATE DATABASE `{$db->getDatabase()}`");
        $output->writeln('<info>Database "' . $db->getDatabase() . '" created</info>');
    }
}