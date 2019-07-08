<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190708133905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE card_activity ADD is_the_winner VARCHAR(150) DEFAULT NULL, ADD personal_score INT DEFAULT NULL, ADD PRIMARY KEY (card_id, activity_id)');
        $this->addSql('ALTER TABLE card_activity ADD CONSTRAINT FK_1545C7D94ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id)');
        $this->addSql('ALTER TABLE card_activity ADD CONSTRAINT FK_1545C7D981C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE card_activity DROP FOREIGN KEY FK_1545C7D94ACC9A20');
        $this->addSql('ALTER TABLE card_activity DROP FOREIGN KEY FK_1545C7D981C06096');
        $this->addSql('ALTER TABLE card_activity DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE card_activity DROP is_the_winner, DROP personal_score');
    }
}
