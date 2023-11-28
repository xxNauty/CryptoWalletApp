<?php

declare(strict_types=1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231128160753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_base DROP CONSTRAINT fk_ba35b2a89eea759');
        $this->addSql('ALTER TABLE purchase DROP CONSTRAINT fk_9861b36d9eea759');
        $this->addSql('DROP SEQUENCE inventory_id_seq CASCADE');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP INDEX idx_6117d13b9eea759');
        $this->addSql('ALTER TABLE purchase RENAME COLUMN inventory_id TO owner_id');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user_base (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6117D13B7E3C61F9 ON purchase (owner_id)');
        $this->addSql('DROP INDEX uniq_ba35b2a89eea759');
        $this->addSql('ALTER TABLE user_base DROP inventory_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE inventory_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE inventory (id INT NOT NULL, total_inventory_value DOUBLE PRECISION NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN inventory.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_base ADD inventory_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_base ADD CONSTRAINT fk_ba35b2a89eea759 FOREIGN KEY (inventory_id) REFERENCES inventory (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_ba35b2a89eea759 ON user_base (inventory_id)');
        $this->addSql('ALTER TABLE purchase DROP CONSTRAINT FK_6117D13B7E3C61F9');
        $this->addSql('DROP INDEX IDX_6117D13B7E3C61F9');
        $this->addSql('ALTER TABLE purchase RENAME COLUMN owner_id TO inventory_id');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT fk_9861b36d9eea759 FOREIGN KEY (inventory_id) REFERENCES inventory (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6117d13b9eea759 ON purchase (inventory_id)');
    }
}
