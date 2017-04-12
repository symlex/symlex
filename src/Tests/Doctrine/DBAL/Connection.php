<?php

namespace App\Tests\Doctrine\DBAL;

use TestTools\Doctrine\DBAL\Connection as TestToolsDoctrineDBALConnection;

class Connection extends TestToolsDoctrineDBALConnection
{
    public function update($tableName, array $data, array $identifier, array $types = array())
    {
        if ($this->usesFixtures()) {
            if (isset($data['updated'])) {
                $data['updated'] = '2016-03-23 23:42:05';
            }
        }

        return parent::update($tableName, $data, $identifier, $types);
    }

    public function insert($tableName, array $data, array $types = array())
    {
        if ($this->usesFixtures()) {
            if (isset($data['created'])) {
                $data['created'] = '2016-01-05 11:05:42';
            }

            if (isset($data['updated'])) {
                $data['updated'] = '2016-01-05 11:05:42';
            }
        }

        return parent::insert($tableName, $data, $types);
    }
}