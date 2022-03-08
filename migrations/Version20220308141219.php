<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308141219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP address, DROP cp, DROP city, DROP country');
        $this->addSql('ALTER TABLE user_adress ADD name VARCHAR(50) NOT NULL, ADD first_name VARCHAR(50) NOT NULL, ADD phone_number VARCHAR(15) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE img img VARCHAR(200) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE product CHANGE name name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE banner_image banner_image VARCHAR(200) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD address VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD cp INT NOT NULL, ADD city VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD country VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE first_name first_name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone_number phone_number VARCHAR(20) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user_adress DROP name, DROP first_name, DROP phone_number, CHANGE adress adress VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
