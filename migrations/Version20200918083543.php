<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200918083543 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09E6AD2C87');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, sku VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weather (id INT AUTO_INCREMENT NOT NULL, forecast_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weather_product_type (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, forecast_name_id INT NOT NULL, INDEX IDX_F8329464584665A (product_id), INDEX IDX_F83294696DACE6D (forecast_name_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE weather_product_type ADD CONSTRAINT FK_F8329464584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE weather_product_type ADD CONSTRAINT FK_F83294696DACE6D FOREIGN KEY (forecast_name_id) REFERENCES weather (id)');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE doctor');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE weather_product_type DROP FOREIGN KEY FK_F8329464584665A');
        $this->addSql('ALTER TABLE weather_product_type DROP FOREIGN KEY FK_F83294696DACE6D');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, fk_doctor_id INT NOT NULL, customer_first_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, customer_reservation_code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_in_appointment TINYINT(1) NOT NULL, appointment_is_finished TINYINT(1) NOT NULL, appointment_time DATETIME NOT NULL, INDEX IDX_81398E09E6AD2C87 (fk_doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE doctor (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, doctor_first_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, doctor_last_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_1FC0F36AF85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09E6AD2C87 FOREIGN KEY (fk_doctor_id) REFERENCES doctor (id)');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE weather');
        $this->addSql('DROP TABLE weather_product_type');
    }
}
