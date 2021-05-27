<?php

namespace App\Command;

use Doctrine\DBAL\Exception\DriverException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\DBAL\Connection;

/**
 * Commands are configured as service in app/config/console.yml
 */
class DatabaseCreateCommand extends CommandAbstract
{
    protected $connection;

    public function __construct($name, Connection $connection)
    {
        $this->connection = $connection;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Create the database configured in app/config/parameters.yml');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    : int {
        $db = $this->connection;
        $params = $db->getParams();
        unset($params['dbname']);

        $connection = new Connection($params, $db->getDriver());

        try {
            $connection->exec("CREATE DATABASE `{$db->getDatabase()}`");
        } catch (DriverException $e) {
            $output->writeln("<info>Database already exists: {$db->getDatabase()}</info>");
            return 0;
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return 1;
        }

        $output->writeln('<info>Database "' . $db->getDatabase() . '" created</info>');
    }
}