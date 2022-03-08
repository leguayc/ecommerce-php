<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308141139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_adress (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, adress VARCHAR(150) NOT NULL, cp INT NOT NULL, city VARCHAR(60) NOT NULL, country VARCHAR(60) NOT NULL, name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, phone_number VARCHAR(15) NOT NULL, INDEX IDX_39BEDC83A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_adress ADD CONSTRAINT FK_39BEDC83A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user DROP address, DROP cp, DROP city, DROP country');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_adress');
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE img img VARCHAR(200) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE product CHANGE name name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE banner_image banner_image VARCHAR(200) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD address VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD cp INT NOT NULL, ADD city VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD country VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE first_name first_name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone_number phone_number VARCHAR(20) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
