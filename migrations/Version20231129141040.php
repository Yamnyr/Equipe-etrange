<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129141040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique ADD user_id INT DEFAULT NULL, ADD mission_id INT DEFAULT NULL, ADD resultat TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECBE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('CREATE INDEX IDX_EDBFD5ECA76ED395 ON historique (user_id)');
        $this->addSql('CREATE INDEX IDX_EDBFD5ECBE6CAE90 ON historique (mission_id)');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C6128735E');
        $this->addSql('DROP INDEX IDX_9067F23C6128735E ON mission');
        $this->addSql('ALTER TABLE mission DROP historique_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496128735E');
        $this->addSql('DROP INDEX IDX_8D93D6496128735E ON user');
        $this->addSql('ALTER TABLE user DROP historique_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECA76ED395');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECBE6CAE90');
        $this->addSql('DROP INDEX IDX_EDBFD5ECA76ED395 ON historique');
        $this->addSql('DROP INDEX IDX_EDBFD5ECBE6CAE90 ON historique');
        $this->addSql('ALTER TABLE historique DROP user_id, DROP mission_id, DROP resultat');
        $this->addSql('ALTER TABLE mission ADD historique_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C6128735E FOREIGN KEY (historique_id) REFERENCES historique (id)');
        $this->addSql('CREATE INDEX IDX_9067F23C6128735E ON mission (historique_id)');
        $this->addSql('ALTER TABLE user ADD historique_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496128735E FOREIGN KEY (historique_id) REFERENCES historique (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6496128735E ON user (historique_id)');
    }
}
