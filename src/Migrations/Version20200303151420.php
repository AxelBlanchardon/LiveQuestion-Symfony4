<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303151420 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE utiliateur');
        $this->addSql('ALTER TABLE question ADD auteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E60BB6FE6 ON question (auteur_id)');
        $this->addSql('ALTER TABLE reponse ADD auteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC760BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC760BB6FE6 ON reponse (auteur_id)');
        $this->addSql('ALTER TABLE utilisateur ADD email VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, CHANGE avatar_image mot_de_passe VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE utiliateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_10BC8ABEE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E60BB6FE6');
        $this->addSql('DROP INDEX IDX_B6F7494E60BB6FE6 ON question');
        $this->addSql('ALTER TABLE question DROP auteur_id');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC760BB6FE6');
        $this->addSql('DROP INDEX IDX_5FB6DEC760BB6FE6 ON reponse');
        $this->addSql('ALTER TABLE reponse DROP auteur_id');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP email, DROP roles, CHANGE mot_de_passe avatar_image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
