<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210306182328 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depenses (id INT AUTO_INCREMENT NOT NULL, id_vehicule_id INT NOT NULL, date DATE NOT NULL, nature_libelle LONGTEXT NOT NULL, prix NUMERIC(10, 0) NOT NULL, kilometrage INT NOT NULL, INDEX IDX_EE350ECB5258F8E6 (id_vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, id_vehicule_id INT NOT NULL, plateforme_location LONGTEXT NOT NULL, parc_stationnement LONGTEXT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, remarque LONGTEXT DEFAULT NULL, prix NUMERIC(10, 0) NOT NULL, service NUMERIC(10, 0) NOT NULL, ajustement NUMERIC(10, 0) DEFAULT NULL, INDEX IDX_5E9E89CB5258F8E6 (id_vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, mode_financement VARCHAR(255) DEFAULT NULL, parc_stationnement_ville VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, immatriculation LONGTEXT NOT NULL, date_immatriculation DATE NOT NULL, nombre_place INT NOT NULL, nombre_porte INT NOT NULL, phase_finition VARCHAR(255) NOT NULL, energie VARCHAR(255) NOT NULL, couleur VARCHAR(255) NOT NULL, date_debut_contrat DATE NOT NULL, apport NUMERIC(10, 0) DEFAULT NULL, duree_financement INT DEFAULT NULL, loyer_mensuel NUMERIC(10, 0) DEFAULT NULL, data_achat DATE NOT NULL, kilometrage_achat INT DEFAULT NULL, prix NUMERIC(10, 0) NOT NULL, options LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE depenses ADD CONSTRAINT FK_EE350ECB5258F8E6 FOREIGN KEY (id_vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB5258F8E6 FOREIGN KEY (id_vehicule_id) REFERENCES vehicule (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depenses DROP FOREIGN KEY FK_EE350ECB5258F8E6');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB5258F8E6');
        $this->addSql('DROP TABLE depenses');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE vehicule');
    }
}
