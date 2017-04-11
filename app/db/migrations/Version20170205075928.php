<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170205075928 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `users` (
              `user_id` int(11) NOT NULL AUTO_INCREMENT,
              `email` varchar(127) UNIQUE NOT NULL,
              `password` varchar(255) NOT NULL DEFAULT \'\',
              `password_reset_token` varchar(128) DEFAULT \'\',
              `firstname` varchar(64) NOT NULL DEFAULT \'\',
              `lastname` varchar(64) NOT NULL DEFAULT \'\',
              `admin` tinyint(1) NOT NULL DEFAULT \'0\',
              `created` datetime DEFAULT NULL,
              `updated` datetime DEFAULT NULL,
              PRIMARY KEY (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
