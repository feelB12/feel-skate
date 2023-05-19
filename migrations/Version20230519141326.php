<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230519141326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) DEFAULT NULL, start DATETIME DEFAULT NULL, end DATETIME DEFAULT NULL, hide DATETIME DEFAULT NULL, is_published DATETIME DEFAULT NULL, creat_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, zippcode INT NOT NULL, town VARCHAR(255) NOT NULL, area VARCHAR(255) NOT NULL, start_at DATETIME DEFAULT NULL, finished_at DATETIME DEFAULT NULL, cover_filename VARCHAR(255) DEFAULT NULL, longitude_start_at DOUBLE PRECISION DEFAULT NULL, latitude_start_at DOUBLE PRECISION DEFAULT NULL, longitude_finish_at DOUBLE PRECISION DEFAULT NULL, latitude_finish_at DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event');
    }
}
