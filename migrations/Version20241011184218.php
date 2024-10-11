<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241011184218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historiques (id INT AUTO_INCREMENT NOT NULL, mouvement_id INT DEFAULT NULL, zone_id INT DEFAULT NULL, equipement_id INT DEFAULT NULL, INDEX IDX_B25FDE8DECD1C222 (mouvement_id), INDEX IDX_B25FDE8D9F2C3FAB (zone_id), INDEX IDX_B25FDE8D806F0F5C (equipement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historiques ADD CONSTRAINT FK_B25FDE8DECD1C222 FOREIGN KEY (mouvement_id) REFERENCES mouvements (id)');
        $this->addSql('ALTER TABLE historiques ADD CONSTRAINT FK_B25FDE8D9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE historiques ADD CONSTRAINT FK_B25FDE8D806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id)');
        $this->addSql('ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F3E23B2ECC');
        $this->addSql('DROP INDEX IDX_B8B4C6F3E23B2ECC ON equipement');
        $this->addSql('ALTER TABLE equipement DROP dernier_mouvement_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historiques DROP FOREIGN KEY FK_B25FDE8DECD1C222');
        $this->addSql('ALTER TABLE historiques DROP FOREIGN KEY FK_B25FDE8D9F2C3FAB');
        $this->addSql('ALTER TABLE historiques DROP FOREIGN KEY FK_B25FDE8D806F0F5C');
        $this->addSql('DROP TABLE historiques');
        $this->addSql('ALTER TABLE equipement ADD dernier_mouvement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3E23B2ECC FOREIGN KEY (dernier_mouvement_id) REFERENCES mouvements (id)');
        $this->addSql('CREATE INDEX IDX_B8B4C6F3E23B2ECC ON equipement (dernier_mouvement_id)');
    }
}
