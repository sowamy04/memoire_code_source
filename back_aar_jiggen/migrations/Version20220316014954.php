<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220316014954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alerte DROP FOREIGN KEY FK_3AE753AED27CD6E');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0A76ED395');
        $this->addSql('ALTER TABLE coordonnees_geographiques DROP FOREIGN KEY FK_E4766BF3A76ED395');
        $this->addSql('ALTER TABLE itineraire DROP FOREIGN KEY FK_487C9A11A76ED395');
        $this->addSql('ALTER TABLE personne_confiance DROP FOREIGN KEY FK_AF8469FAED27CD6E');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE simple_user');
        $this->addSql('DROP TABLE super_admin');
        $this->addSql('ALTER TABLE alerte DROP FOREIGN KEY FK_3AE753AED27CD6E');
        $this->addSql('ALTER TABLE alerte DROP message');
        $this->addSql('ALTER TABLE alerte ADD CONSTRAINT FK_3AE753AED27CD6E FOREIGN KEY (simple_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0A76ED395');
        $this->addSql('ALTER TABLE avis CHANGE qualite_route qualite_route VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE coordonnees_geographiques DROP FOREIGN KEY FK_E4766BF3A76ED395');
        $this->addSql('ALTER TABLE coordonnees_geographiques CHANGE latitude latitude NUMERIC(10, 0) NOT NULL, CHANGE longitude longitude NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE coordonnees_geographiques ADD CONSTRAINT FK_E4766BF3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE itineraire DROP FOREIGN KEY FK_487C9A11A76ED395');
        $this->addSql('ALTER TABLE itineraire ADD CONSTRAINT FK_487C9A11A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE personne_confiance DROP FOREIGN KEY FK_AF8469FAED27CD6E');
        $this->addSql('ALTER TABLE personne_confiance CHANGE statut statut TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE personne_confiance ADD CONSTRAINT FK_AF8469FAED27CD6E FOREIGN KEY (simple_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD profil VARCHAR(255) NOT NULL, ADD first_connexion TINYINT(1) DEFAULT NULL, ADD genre VARCHAR(255) DEFAULT NULL, ADD adresse VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, first_connexion TINYINT(1) NOT NULL, username VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, telephone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, statut TINYINT(1) NOT NULL, photo LONGBLOB DEFAULT NULL, UNIQUE INDEX UNIQ_880E0D76F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE simple_user (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, username VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, telephone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, statut TINYINT(1) NOT NULL, photo LONGBLOB DEFAULT NULL, UNIQUE INDEX UNIQ_2272B4F0F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE super_admin (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, telephone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, statut TINYINT(1) NOT NULL, photo LONGBLOB DEFAULT NULL, UNIQUE INDEX UNIQ_BC8C2783F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE alerte DROP FOREIGN KEY FK_3AE753AED27CD6E');
        $this->addSql('ALTER TABLE alerte ADD message LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE alerte ADD CONSTRAINT FK_3AE753AED27CD6E FOREIGN KEY (simple_user_id) REFERENCES simple_user (id)');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0A76ED395');
        $this->addSql('ALTER TABLE avis CHANGE qualite_route qualite_route VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0A76ED395 FOREIGN KEY (user_id) REFERENCES simple_user (id)');
        $this->addSql('ALTER TABLE coordonnees_geographiques DROP FOREIGN KEY FK_E4766BF3A76ED395');
        $this->addSql('ALTER TABLE coordonnees_geographiques CHANGE latitude latitude NUMERIC(10, 10) NOT NULL, CHANGE longitude longitude NUMERIC(10, 10) NOT NULL');
        $this->addSql('ALTER TABLE coordonnees_geographiques ADD CONSTRAINT FK_E4766BF3A76ED395 FOREIGN KEY (user_id) REFERENCES simple_user (id)');
        $this->addSql('ALTER TABLE itineraire DROP FOREIGN KEY FK_487C9A11A76ED395');
        $this->addSql('ALTER TABLE itineraire ADD CONSTRAINT FK_487C9A11A76ED395 FOREIGN KEY (user_id) REFERENCES simple_user (id)');
        $this->addSql('ALTER TABLE personne_confiance DROP FOREIGN KEY FK_AF8469FAED27CD6E');
        $this->addSql('ALTER TABLE personne_confiance CHANGE statut statut VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE personne_confiance ADD CONSTRAINT FK_AF8469FAED27CD6E FOREIGN KEY (simple_user_id) REFERENCES simple_user (id)');
        $this->addSql('ALTER TABLE user DROP profil, DROP first_connexion, DROP genre, DROP adresse');
    }
}
