<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116213553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vente ADD category VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD quantite_v DOUBLE PRECISION NOT NULL, DROP quantite_avendre, DROP prix_unitaire, CHANGE date_vente date_vente DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vente ADD prix_unitaire DOUBLE PRECISION NOT NULL, DROP category, DROP nom, CHANGE date_vente date_vente DATE DEFAULT NULL, CHANGE quantite_v quantite_avendre DOUBLE PRECISION NOT NULL');
    }
}
