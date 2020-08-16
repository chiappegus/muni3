<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200813154801 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pedido (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, persona_id INT DEFAULT NULL, cantidad INT NOT NULL, precio_pedido INT NOT NULL, restaurant VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C4EC16CECCD7E912 (menu_id), UNIQUE INDEX UNIQ_C4EC16CEF5F88DB9 (persona_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CECCD7E912 FOREIGN KEY (menu_id) REFERENCES buffy (id)');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CEF5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pedido');
    }
}
