<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307024542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alerte ADD meritoire_id INT DEFAULT NULL, ADD simple_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE alerte ADD CONSTRAINT FK_3AE753A8222A6E1 FOREIGN KEY (meritoire_id) REFERENCES personne_confiance (id)');
        $this->addSql('ALTER TABLE alerte ADD CONSTRAINT FK_3AE753AED27CD6E FOREIGN KEY (simple_user_id) REFERENCES simple_user (id)');
        $this->addSql('CREATE INDEX IDX_3AE753A8222A6E1 ON alerte (meritoire_id)');
        $this->addSql('CREATE INDEX IDX_3AE753AED27CD6E ON alerte (simple_user_id)');
        $this->addSql('ALTER TABLE avis ADD user_id INT DEFAULT NULL, ADD quartier_id INT DEFAULT NULL, ADD statut TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0A76ED395 FOREIGN KEY (user_id) REFERENCES simple_user (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0DF1E57AB FOREIGN KEY (quartier_id) REFERENCES quartier (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0A76ED395 ON avis (user_id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0DF1E57AB ON avis (quartier_id)');
        $this->addSql('ALTER TABLE coordonnees_geographiques ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coordonnees_geographiques ADD CONSTRAINT FK_E4766BF3A76ED395 FOREIGN KEY (user_id) REFERENCES simple_user (id)');
        $this->addSql('CREATE INDEX IDX_E4766BF3A76ED395 ON coordonnees_geographiques (user_id)');
        $this->addSql('ALTER TABLE departement ADD region_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_C1765B6398260155 ON departement (region_id)');
        $this->addSql('ALTER TABLE itineraire ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE itineraire ADD CONSTRAINT FK_487C9A11A76ED395 FOREIGN KEY (user_id) REFERENCES simple_user (id)');
        $this->addSql('CREATE INDEX IDX_487C9A11A76ED395 ON itineraire (user_id)');
        $this->addSql('ALTER TABLE organe ADD ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE organe ADD CONSTRAINT FK_E23012D0A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_E23012D0A73F0036 ON organe (ville_id)');
        $this->addSql('ALTER TABLE personne_confiance ADD simple_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne_confiance ADD CONSTRAINT FK_AF8469FAED27CD6E FOREIGN KEY (simple_user_id) REFERENCES simple_user (id)');
        $this->addSql('CREATE INDEX IDX_AF8469FAED27CD6E ON personne_confiance (simple_user_id)');
        $this->addSql('ALTER TABLE quartier ADD ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962DA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_FEE8962DA73F0036 ON quartier (ville_id)');
        $this->addSql('ALTER TABLE user ADD profil_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649275ED078 ON user (profil_id)');
        $this->addSql('ALTER TABLE ville ADD departement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_43C3D9C3CCF9E01E ON ville (departement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE alerte DROP FOREIGN KEY FK_3AE753A8222A6E1');
        $this->addSql('ALTER TABLE alerte DROP FOREIGN KEY FK_3AE753AED27CD6E');
        $this->addSql('DROP INDEX IDX_3AE753A8222A6E1 ON alerte');
        $this->addSql('DROP INDEX IDX_3AE753AED27CD6E ON alerte');
        $this->addSql('ALTER TABLE alerte DROP meritoire_id, DROP simple_user_id, CHANGE message message LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0A76ED395');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0DF1E57AB');
        $this->addSql('DROP INDEX IDX_8F91ABF0A76ED395 ON avis');
        $this->addSql('DROP INDEX IDX_8F91ABF0DF1E57AB ON avis');
        $this->addSql('ALTER TABLE avis DROP user_id, DROP quartier_id, DROP statut, CHANGE qualite_route qualite_route VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE coordonnees_geographiques DROP FOREIGN KEY FK_E4766BF3A76ED395');
        $this->addSql('DROP INDEX IDX_E4766BF3A76ED395 ON coordonnees_geographiques');
        $this->addSql('ALTER TABLE coordonnees_geographiques DROP user_id');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6398260155');
        $this->addSql('DROP INDEX IDX_C1765B6398260155 ON departement');
        $this->addSql('ALTER TABLE departement DROP region_id, CHANGE nom_dept nom_dept VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE itineraire DROP FOREIGN KEY FK_487C9A11A76ED395');
        $this->addSql('DROP INDEX IDX_487C9A11A76ED395 ON itineraire');
        $this->addSql('ALTER TABLE itineraire DROP user_id, CHANGE depart depart VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE arrivee arrivee VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE organe DROP FOREIGN KEY FK_E23012D0A73F0036');
        $this->addSql('DROP INDEX IDX_E23012D0A73F0036 ON organe');
        $this->addSql('ALTER TABLE organe DROP ville_id, CHANGE nom_organe nom_organe VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE personne_confiance DROP FOREIGN KEY FK_AF8469FAED27CD6E');
        $this->addSql('DROP INDEX IDX_AF8469FAED27CD6E ON personne_confiance');
        $this->addSql('ALTER TABLE personne_confiance DROP simple_user_id, CHANGE nom_complet nom_complet VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE statut statut VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE profil CHANGE libelle libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962DA73F0036');
        $this->addSql('DROP INDEX IDX_FEE8962DA73F0036 ON quartier');
        $this->addSql('ALTER TABLE quartier DROP ville_id, CHANGE nom_quartier nom_quartier VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE region CHANGE nom_region nom_region VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE simple_user CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE genre genre VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE super_admin CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649275ED078');
        $this->addSql('DROP INDEX IDX_8D93D649275ED078 ON user');
        $this->addSql('ALTER TABLE user DROP profil_id, CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3CCF9E01E');
        $this->addSql('DROP INDEX IDX_43C3D9C3CCF9E01E ON ville');
        $this->addSql('ALTER TABLE ville DROP departement_id, CHANGE nom_ville nom_ville VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
