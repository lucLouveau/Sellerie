<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241012080112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emplacements ADD rayon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emplacements ADD CONSTRAINT FK_4F105747D3202E52 FOREIGN KEY (rayon_id) REFERENCES rayons (id)');
        $this->addSql('CREATE INDEX IDX_4F105747D3202E52 ON emplacements (rayon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emplacements DROP FOREIGN KEY FK_4F105747D3202E52');
        $this->addSql('DROP INDEX IDX_4F105747D3202E52 ON emplacements');
        $this->addSql('ALTER TABLE emplacements DROP rayon_id');
    }
}
