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
              `email` varchar(127) NOT NULL,
              `password` varchar(255) NOT NULL DEFAULT \'\',
              `password_reset_token` varchar(128) DEFAULT \'\',
              `firstname` varchar(64) NOT NULL DEFAULT \'\',
              `lastname` varchar(64) NOT NULL DEFAULT \'\',
              `admin` tinyint(1) NOT NULL DEFAULT \'0\',
              `created` datetime DEFAULT NULL,
              `updated` datetime DEFAULT NULL,
              PRIMARY KEY (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

        $this->addSql('INSERT INTO `users` VALUES (1,\'admin@example.com\',\'$6$5ygXjBO2gNbW$p1eaS7isBLD1JfN6PaQzrGKJHf9UGmUOBCZiqq3VnhDSPhdbIzOnu3kbKO2mcKEFiD11jFoPE5YSyvA7cYbbK1\',\'\',\'Admin\',\'Silex\',1,NULL,NULL),(2,\'user@example.com\',\'$6$5ygXjBO2gNbW$p1eaS7isBLD1JfN6PaQzrGKJHf9UGmUOBCZiqq3VnhDSPhdbIzOnu3kbKO2mcKEFiD11jFoPE5YSyvA7cYbbK1\',\'\',\'User\',\'Silex\',0,\'2014-08-04 06:51:35\',\'2014-08-04 06:51:35\');');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
