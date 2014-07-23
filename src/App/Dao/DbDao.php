<?php

namespace App\Dao;

use Sympathy\Db\Entity as SympathyDbDao;

abstract class DbDao extends SympathyDbDao
{
    protected $_factoryNamespace = 'App\\Dao';
}