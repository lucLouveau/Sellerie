<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241011182048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F3494AEC60');
        $this->addSql('DROP INDEX IDX_B8B4C6F3494AEC60 ON equipement');
        $this->addSql('ALTER TABLE equipement DROP zone_actu_id, DROP rayon, DROP etage, DROP colone');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipement ADD zone_actu_id INT DEFAULT NULL, ADD rayon VARCHAR(255) NOT NULL, ADD etage INT NOT NULL, ADD colone INT NOT NULL');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3494AEC60 FOREIGN KEY (zone_actu_id) REFERENCES zone (id)');
        $this->addSql('CREATE INDEX IDX_B8B4C6F3494AEC60 ON equipement (zone_actu_id)');
    }
}
