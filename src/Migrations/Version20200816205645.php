<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200816205645 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE buffy ADD pedidos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE buffy ADD CONSTRAINT FK_2F1531B5213530F2 FOREIGN KEY (pedidos_id) REFERENCES pedido (id)');
        $this->addSql('CREATE INDEX IDX_2F1531B5213530F2 ON buffy (pedidos_id)');
        $this->addSql('ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CECCD7E912');
        $this->addSql('DROP INDEX IDX_C4EC16CECCD7E912 ON pedido');
        $this->addSql('ALTER TABLE pedido DROP menu_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE buffy DROP FOREIGN KEY FK_2F1531B5213530F2');
        $this->addSql('DROP INDEX IDX_2F1531B5213530F2 ON buffy');
        $this->addSql('ALTER TABLE buffy DROP pedidos_id');
        $this->addSql('ALTER TABLE pedido ADD menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CECCD7E912 FOREIGN KEY (menu_id) REFERENCES buffy (id)');
        $this->addSql('CREATE INDEX IDX_C4EC16CECCD7E912 ON pedido (menu_id)');
    }
}
