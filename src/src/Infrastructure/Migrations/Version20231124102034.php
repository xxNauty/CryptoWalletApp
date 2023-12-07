<?php

declare(strict_types=1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124102034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE currency_id_seq CASCADE');
        $this->addSql('CREATE TABLE purchase (id INT NOT NULL, inventory_id INT DEFAULT NULL, symbol VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, single_price DOUBLE PRECISION NOT NULL, bought_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, sold BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9861B36D9EEA759 ON purchase (inventory_id)');
        $this->addSql('COMMENT ON COLUMN Purchase.bought_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_9861B36D9EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE currency ALTER symbol TYPE VARCHAR(4)');
        $this->addSql('ALTER TABLE inventory DROP content');
        $this->addSql('ALTER TABLE user_base ALTER currency SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE currency_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE purchase DROP CONSTRAINT FK_9861B36D9EEA759');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('ALTER TABLE user_base ALTER currency DROP NOT NULL');
        $this->addSql('ALTER TABLE currency ALTER symbol TYPE VARCHAR(3)');
        $this->addSql('ALTER TABLE inventory ADD content JSON DEFAULT NULL');
    }
}
