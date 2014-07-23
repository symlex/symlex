<?php

namespace App\Model;

use Sympathy\Db\Model as SympathyDbModel;

abstract class DbModel extends SympathyDbModel
{
    protected $_factoryNamespace = 'App\\Model';
    protected $_factoryPostfix = '';
    protected $_daoFactoryNamespace = 'App\\Dao';
}