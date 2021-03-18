<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210317104919 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP service, DROP ajustement');
        $this->addSql('ALTER TABLE vehicule ADD mark VARCHAR(255) NOT NULL, ADD status SMALLINT NOT NULL, DROP mode_financement, DROP date_debut_contrat, DROP apport, DROP duree_financement, DROP loyer_mensuel');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location ADD service NUMERIC(10, 0) NOT NULL, ADD ajustement NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD mode_financement VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD date_debut_contrat DATE NOT NULL, ADD apport NUMERIC(10, 0) DEFAULT NULL, ADD duree_financement INT DEFAULT NULL, ADD loyer_mensuel NUMERIC(10, 0) DEFAULT NULL, DROP mark, DROP status');
    }
}
