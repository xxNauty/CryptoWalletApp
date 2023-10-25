<?php

declare(strict_types=1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023194254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE inventory_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE inventory (id INT NOT NULL, total_inventory_value DOUBLE PRECISION NOT NULL, content JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE user_base ADD inventory_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_base ADD CONSTRAINT FK_BA35B2A89EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA35B2A89EEA759 ON user_base (inventory_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_base DROP CONSTRAINT FK_BA35B2A89EEA759');
        $this->addSql('DROP SEQUENCE inventory_id_seq CASCADE');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP INDEX UNIQ_BA35B2A89EEA759');
        $this->addSql('ALTER TABLE user_base DROP inventory_id');
    }
}
