<?php

namespace App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\DBAL\Connection;
use DirectoryIterator;

/**
 * Commands are configured as service in app/config/console.yml
 */
class DatabaseInsertFixturesCommand extends AbstractCommand
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var string
     */
    protected $fixturesDirectory;

    /**
     * @param null|string $name
     * @param Connection $connection
     * @param string $fixturesDirectory
     */
    public function __construct($name, Connection $connection, string $fixturesDirectory)
    {
        $this->connection = $connection;
        $this->fixturesDirectory = $fixturesDirectory;

        parent::__construct($name);

        $this->setDescription('Inserts database fixtures for testing (see app/db/fixtures/)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->connection->executeQuery('SET foreign_key_checks = 0');

        foreach (new DirectoryIterator($this->fixturesDirectory) as $file) {
            if ($file->isDot()) {
                continue;
            }

            $table = $file->getBasename('.php');
            $data = include $file->getRealPath();

            $output->write('Inserting ' . count($data) . ' fixtures into <options=bold>' . $table . '</> table... ');

            foreach ($data as $row) {
                $this->connection->insert($table, $row);
            }

            $output->writeln('<info>Done.</info>');
        }

        $this->connection->executeQuery('SET foreign_key_checks = 1');
    }
}