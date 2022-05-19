<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220316015051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alerte (id INT AUTO_INCREMENT NOT NULL, meritoire_id INT DEFAULT NULL, simple_user_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_3AE753A8222A6E1 (meritoire_id), INDEX IDX_3AE753AED27CD6E (simple_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, quartier_id INT DEFAULT NULL, eclairage_publique INT NOT NULL, vol INT NOT NULL, viol INT NOT NULL, agression INT NOT NULL, transport INT NOT NULL, qualite_route VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_8F91ABF0A76ED395 (user_id), INDEX IDX_8F91ABF0DF1E57AB (quartier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coordonnees_geographiques (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, latitude NUMERIC(10, 0) NOT NULL, longitude NUMERIC(10, 0) NOT NULL, date DATETIME NOT NULL, INDEX IDX_E4766BF3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, nom_dept VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_C1765B6398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE itineraire (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, depart VARCHAR(255) NOT NULL, arrivee VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_487C9A11A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organe (id INT AUTO_INCREMENT NOT NULL, ville_id INT DEFAULT NULL, nom_organe VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, INDEX IDX_E23012D0A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne_confiance (id INT AUTO_INCREMENT NOT NULL, simple_user_id INT DEFAULT NULL, itineraire_id INT DEFAULT NULL, nom_complet VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, date DATETIME NOT NULL, INDEX IDX_AF8469FAED27CD6E (simple_user_id), INDEX IDX_AF8469FAA9B853B8 (itineraire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quartier (id INT AUTO_INCREMENT NOT NULL, ville_id INT DEFAULT NULL, nom_quartier VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_FEE8962DA73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, nom_region VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, departement_id INT DEFAULT NULL, nom_ville VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_43C3D9C3CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alerte ADD CONSTRAINT FK_3AE753A8222A6E1 FOREIGN KEY (meritoire_id) REFERENCES personne_confiance (id)');
        $this->addSql('ALTER TABLE alerte ADD CONSTRAINT FK_3AE753AED27CD6E FOREIGN KEY (simple_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0DF1E57AB FOREIGN KEY (quartier_id) REFERENCES quartier (id)');
        $this->addSql('ALTER TABLE coordonnees_geographiques ADD CONSTRAINT FK_E4766BF3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE itineraire ADD CONSTRAINT FK_487C9A11A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE organe ADD CONSTRAINT FK_E23012D0A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE personne_confiance ADD CONSTRAINT FK_AF8469FAED27CD6E FOREIGN KEY (simple_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE personne_confiance ADD CONSTRAINT FK_AF8469FAA9B853B8 FOREIGN KEY (itineraire_id) REFERENCES itineraire (id)');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962DA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE user ADD profil_id INT DEFAULT NULL, ADD username VARCHAR(180) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD telephone VARCHAR(255) NOT NULL, ADD statut TINYINT(1) NOT NULL, ADD photo LONGBLOB DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD first_connexion TINYINT(1) DEFAULT NULL, ADD genre VARCHAR(255) DEFAULT NULL, ADD adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE INDEX IDX_8D93D649275ED078 ON user (profil_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3CCF9E01E');
        $this->addSql('ALTER TABLE personne_confiance DROP FOREIGN KEY FK_AF8469FAA9B853B8');
        $this->addSql('ALTER TABLE alerte DROP FOREIGN KEY FK_3AE753A8222A6E1');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649275ED078');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0DF1E57AB');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6398260155');
        $this->addSql('ALTER TABLE organe DROP FOREIGN KEY FK_E23012D0A73F0036');
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962DA73F0036');
        $this->addSql('DROP TABLE alerte');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE coordonnees_geographiques');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE itineraire');
        $this->addSql('DROP TABLE organe');
        $this->addSql('DROP TABLE personne_confiance');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE quartier');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649275ED078 ON user');
        $this->addSql('ALTER TABLE user DROP profil_id, DROP username, DROP password, DROP prenom, DROP nom, DROP telephone, DROP statut, DROP photo, DROP email, DROP first_connexion, DROP genre, DROP adresse');
    }
}
