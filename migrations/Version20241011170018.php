<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241011170018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, zone_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_3AF346689F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, etat_id INT DEFAULT NULL, dernier_mouvement_id INT DEFAULT NULL, zone_actu_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, usure INT NOT NULL, rayon VARCHAR(255) NOT NULL, etage INT NOT NULL, colone INT NOT NULL, INDEX IDX_B8B4C6F3BCF5E72D (categorie_id), INDEX IDX_B8B4C6F3D5E86FF (etat_id), INDEX IDX_B8B4C6F3E23B2ECC (dernier_mouvement_id), INDEX IDX_B8B4C6F3494AEC60 (zone_actu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mouvements (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346689F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3E23B2ECC FOREIGN KEY (dernier_mouvement_id) REFERENCES mouvements (id)');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3494AEC60 FOREIGN KEY (zone_actu_id) REFERENCES zone (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346689F2C3FAB');
        $this->addSql('ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F3BCF5E72D');
        $this->addSql('ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F3D5E86FF');
        $this->addSql('ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F3E23B2ECC');
        $this->addSql('ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F3494AEC60');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE mouvements');
    }
}
