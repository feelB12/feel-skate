<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404154111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D044D5D4A76ED395 ON session (user_id)');
        $this->addSql('ALTER TABLE shop ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AC6A4CA2A76ED395 ON shop (user_id)');
        $this->addSql('ALTER TABLE skatepark ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skatepark ADD CONSTRAINT FK_AB4505C7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AB4505C7A76ED395 ON skatepark (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4A76ED395');
        $this->addSql('DROP INDEX IDX_D044D5D4A76ED395 ON session');
        $this->addSql('ALTER TABLE session DROP user_id');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA2A76ED395');
        $this->addSql('DROP INDEX IDX_AC6A4CA2A76ED395 ON shop');
        $this->addSql('ALTER TABLE shop DROP user_id');
        $this->addSql('ALTER TABLE skatepark DROP FOREIGN KEY FK_AB4505C7A76ED395');
        $this->addSql('DROP INDEX IDX_AB4505C7A76ED395 ON skatepark');
        $this->addSql('ALTER TABLE skatepark DROP user_id');
    }
}
