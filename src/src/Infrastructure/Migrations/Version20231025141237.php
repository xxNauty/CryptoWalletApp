<?php

declare(strict_types=1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231025141237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO inventory(id, total_inventory_value, content) VALUES (1, 0, null)');
        $this->addSql("INSERT INTO user_base(id, email, first_name, last_name, password, role, inventory_id) VALUES (1, 'mateusz2003w@gmail.com', 'Mateusz', 'Wnuk', '$2y$13\$u3JJgAfPxnVnqBGazhnsseTMyyWc8lz4YAxyPbT/8Ghmjtjh5k1DW', 'ROLE_ADMIN', 1)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
