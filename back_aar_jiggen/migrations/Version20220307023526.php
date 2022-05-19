<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307023526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD username VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD telephone VARCHAR(255) NOT NULL, ADD statut TINYINT(1) NOT NULL, ADD photo LONGBLOB DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76F85E0677 ON admin (username)');
        $this->addSql('ALTER TABLE simple_user ADD username VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD telephone VARCHAR(255) NOT NULL, ADD statut TINYINT(1) NOT NULL, ADD photo LONGBLOB DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2272B4F0F85E0677 ON simple_user (username)');
        $this->addSql('ALTER TABLE super_admin ADD username VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD telephone VARCHAR(255) NOT NULL, ADD statut TINYINT(1) NOT NULL, ADD photo LONGBLOB DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BC8C2783F85E0677 ON super_admin (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_880E0D76F85E0677 ON admin');
        $this->addSql('ALTER TABLE admin DROP username, DROP roles, DROP password, DROP prenom, DROP nom, DROP email, DROP telephone, DROP statut, DROP photo');
        $this->addSql('ALTER TABLE alerte CHANGE message message LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE avis CHANGE qualite_route qualite_route VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE departement CHANGE nom_dept nom_dept VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE itineraire CHANGE depart depart VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE arrivee arrivee VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE organe CHANGE nom_organe nom_organe VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE personne_confiance CHANGE nom_complet nom_complet VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE statut statut VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE profil CHANGE libelle libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE quartier CHANGE nom_quartier nom_quartier VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE region CHANGE nom_region nom_region VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_2272B4F0F85E0677 ON simple_user');
        $this->addSql('ALTER TABLE simple_user DROP username, DROP roles, DROP password, DROP prenom, DROP nom, DROP email, DROP telephone, DROP statut, DROP photo, CHANGE genre genre VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_BC8C2783F85E0677 ON super_admin');
        $this->addSql('ALTER TABLE super_admin DROP username, DROP roles, DROP password, DROP prenom, DROP nom, DROP email, DROP telephone, DROP statut, DROP photo');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ville CHANGE nom_ville nom_ville VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
