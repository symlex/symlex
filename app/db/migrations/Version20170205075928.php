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
              `userId` BIGINT NOT NULL AUTO_INCREMENT,
              `userEmail` varchar(127) UNIQUE NOT NULL,
              `userPassword` varchar(255) NOT NULL DEFAULT \'\',
              `userPasswordResetToken` varchar(128) DEFAULT NULL,
              `userVerificationToken` varchar(128) DEFAULT NULL,
              `userFirstName` varchar(64) NOT NULL DEFAULT \'\',
              `userLastName` varchar(64) NOT NULL DEFAULT \'\',
              `userRole` varchar(64) NOT NULL DEFAULT \'user\',
              `userNewsletter` TINYINT UNSIGNED NOT NULL DEFAULT 0, 
              `created` datetime DEFAULT NULL,
              `updated` datetime DEFAULT NULL,
              PRIMARY KEY (`userId`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

        $this->addSql('CREATE TABLE `usersArchive` (
              `archiveId` BIGINT NOT NULL AUTO_INCREMENT,
              `userId` BIGINT NOT NULL,
              `userEmail` varchar(127) NOT NULL,
              `userPassword` varchar(255) NOT NULL DEFAULT \'\',
              `userPasswordResetToken` varchar(128) DEFAULT NULL,
              `userVerificationToken` varchar(128) DEFAULT NULL,
              `userFirstName` varchar(64) NOT NULL DEFAULT \'\',
              `userLastName` varchar(64) NOT NULL DEFAULT \'\',
              `userRole` varchar(64) NOT NULL DEFAULT \'user\',
              `userNewsletter` TINYINT UNSIGNED NOT NULL DEFAULT 0, 
              `created` datetime DEFAULT NULL,
              `updated` datetime DEFAULT NULL,
              PRIMARY KEY (`archiveId`),
              INDEX `userId` (`userId` ASC)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

        $this->addSql('
            CREATE TRIGGER `trigger_users_update` AFTER UPDATE ON `users`
            FOR EACH ROW
            BEGIN
                INSERT INTO `usersArchive` 
                (userId, userEmail, userPassword, userPasswordResetToken, userVerificationToken, userFirstName, userLastName, userRole, userNewsletter, created, updated) 
                VALUES
                (OLD.userId, OLD.userEmail, OLD.userPassword, OLD.userPasswordResetToken, OLD.userVerificationToken, OLD.userFirstName, OLD.userLastName, OLD.userRole, OLD.userNewsletter, OLD.created, OLD.updated);
            END;');

        $this->addSql('
            CREATE TRIGGER `trigger_users_delete` AFTER DELETE ON `users`
            FOR EACH ROW
            BEGIN
                INSERT INTO `usersArchive` 
                (userId, userEmail, userPassword, userPasswordResetToken, userVerificationToken, userFirstName, userLastName, userRole, userNewsletter, created, updated) 
                VALUES
                (OLD.userId, OLD.userEmail, OLD.userPassword, OLD.userPasswordResetToken, OLD.userVerificationToken, OLD.userFirstName, OLD.userLastName, OLD.userRole, OLD.userNewsletter, OLD.created, OLD.updated);
            END;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
