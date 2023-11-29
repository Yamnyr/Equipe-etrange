<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129140704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, mdj_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8F87BF96A48167EF (mdj_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, classe_id INT DEFAULT NULL, historique_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_9067F23C8F5EA509 (classe_id), INDEX IDX_9067F23C6128735E (historique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, classe_id INT DEFAULT NULL, historique_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, pv INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6498F5EA509 (classe_id), INDEX IDX_8D93D6496128735E (historique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96A48167EF FOREIGN KEY (mdj_id) REFERENCES mission (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C6128735E FOREIGN KEY (historique_id) REFERENCES historique (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496128735E FOREIGN KEY (historique_id) REFERENCES historique (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96A48167EF');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C8F5EA509');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C6128735E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498F5EA509');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496128735E');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE user');
    }
}
