<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190628143529 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE card (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, store_id INT DEFAULT NULL, statut LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', check_sum INT NOT NULL, INDEX IDX_161498D3A76ED395 (user_id), INDEX IDX_161498D3B092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card_activity (card_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_1545C7D94ACC9A20 (card_id), INDEX IDX_1545C7D981C06096 (activity_id), PRIMARY KEY(card_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card_deal (card_id INT NOT NULL, deal_id INT NOT NULL, INDEX IDX_FCDC3B44ACC9A20 (card_id), INDEX IDX_FCDC3B4F60E2305 (deal_id), PRIMARY KEY(card_id, deal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store (id INT AUTO_INCREMENT NOT NULL, center_code INT NOT NULL, number_street INT NOT NULL, name_street VARCHAR(100) NOT NULL, zip_code VARCHAR(15) NOT NULL, city VARCHAR(100) NOT NULL, country VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', email VARCHAR(150) NOT NULL, password VARCHAR(255) NOT NULL, number_street INT DEFAULT NULL, name_street VARCHAR(150) DEFAULT NULL, zip_code VARCHAR(255) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, country VARCHAR(100) DEFAULT NULL, customer_code INT DEFAULT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_store (user_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_1D95A32FA76ED395 (user_id), INDEX IDX_1D95A32FB092A811 (store_id), PRIMARY KEY(user_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, description LONGTEXT NOT NULL, cost_point INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, personal_score INT DEFAULT NULL, fidelity_point INT DEFAULT NULL, game_date DATETIME DEFAULT NULL, is_the_winner TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('ALTER TABLE card_activity ADD CONSTRAINT FK_1545C7D94ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card_activity ADD CONSTRAINT FK_1545C7D981C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card_deal ADD CONSTRAINT FK_FCDC3B44ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card_deal ADD CONSTRAINT FK_FCDC3B4F60E2305 FOREIGN KEY (deal_id) REFERENCES deal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_store ADD CONSTRAINT FK_1D95A32FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_store ADD CONSTRAINT FK_1D95A32FB092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE card_activity DROP FOREIGN KEY FK_1545C7D94ACC9A20');
        $this->addSql('ALTER TABLE card_deal DROP FOREIGN KEY FK_FCDC3B44ACC9A20');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3B092A811');
        $this->addSql('ALTER TABLE user_store DROP FOREIGN KEY FK_1D95A32FB092A811');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3A76ED395');
        $this->addSql('ALTER TABLE user_store DROP FOREIGN KEY FK_1D95A32FA76ED395');
        $this->addSql('ALTER TABLE card_deal DROP FOREIGN KEY FK_FCDC3B4F60E2305');
        $this->addSql('ALTER TABLE card_activity DROP FOREIGN KEY FK_1545C7D981C06096');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE card_activity');
        $this->addSql('DROP TABLE card_deal');
        $this->addSql('DROP TABLE store');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_store');
        $this->addSql('DROP TABLE deal');
        $this->addSql('DROP TABLE activity');
    }
}
