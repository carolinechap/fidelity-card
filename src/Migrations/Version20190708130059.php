<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190708130059 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE card_activity ADD id INT AUTO_INCREMENT NOT NULL, ADD is_the_winner VARCHAR(150) NOT NULL, ADD personal_score INT DEFAULT NULL, CHANGE card_id card_id INT DEFAULT NULL, CHANGE activity_id activity_id INT DEFAULT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE card_activity ADD CONSTRAINT FK_1545C7D94ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id)');
        $this->addSql('ALTER TABLE card_activity ADD CONSTRAINT FK_1545C7D981C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE card_activity MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE card_activity DROP FOREIGN KEY FK_1545C7D94ACC9A20');
        $this->addSql('ALTER TABLE card_activity DROP FOREIGN KEY FK_1545C7D981C06096');
        $this->addSql('ALTER TABLE card_activity DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE card_activity DROP id, DROP is_the_winner, DROP personal_score, CHANGE card_id card_id INT NOT NULL, CHANGE activity_id activity_id INT NOT NULL');
    }
}
