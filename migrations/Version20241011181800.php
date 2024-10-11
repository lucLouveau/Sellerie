<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241011181800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346689F2C3FAB');
        $this->addSql('DROP INDEX IDX_3AF346689F2C3FAB ON categories');
        $this->addSql('ALTER TABLE categories DROP zone_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories ADD zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346689F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('CREATE INDEX IDX_3AF346689F2C3FAB ON categories (zone_id)');
    }
}
