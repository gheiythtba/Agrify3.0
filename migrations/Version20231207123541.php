<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231207123541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F809303D');
        $this->addSql('CREATE TABLE animal_stock (id INT AUTO_INCREMENT NOT NULL, vente_id INT DEFAULT NULL, nom_animal VARCHAR(255) NOT NULL, sexe_animal VARCHAR(255) NOT NULL, age_animal INT NOT NULL, poids_animal DOUBLE PRECISION NOT NULL, health VARCHAR(255) NOT NULL, date_entree_stock DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_6AC58F947DC7170A (vente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance (id INT AUTO_INCREMENT NOT NULL, type_materiel_id INT DEFAULT NULL, date_debut DATE NOT NULL, durée INT NOT NULL, description VARCHAR(200) DEFAULT NULL, INDEX IDX_2F84F8E95D91DD3E (type_materiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(100) NOT NULL, etat VARCHAR(100) NOT NULL, capacite_masse INT NOT NULL, capacite_volume INT DEFAULT NULL, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plante_stock (id INT AUTO_INCREMENT NOT NULL, vente_id INT DEFAULT NULL, nom_plante VARCHAR(255) NOT NULL, etat_plante VARCHAR(255) NOT NULL, health VARCHAR(255) NOT NULL, quantite_plante DOUBLE PRECISION NOT NULL, date_entree_stock DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_2E8D916B7DC7170A (vente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_divers (id INT AUTO_INCREMENT NOT NULL, vente_id INT DEFAULT NULL, nom_sd VARCHAR(255) NOT NULL, quantite_sd DOUBLE PRECISION NOT NULL, health VARCHAR(255) NOT NULL, date_entree_stock DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_A8EEE63C7DC7170A (vente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, quantite_v DOUBLE PRECISION NOT NULL, prix_total DOUBLE PRECISION NOT NULL, date_vente DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_stock ADD CONSTRAINT FK_6AC58F947DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E95D91DD3E FOREIGN KEY (type_materiel_id) REFERENCES materiel (id)');
        $this->addSql('ALTER TABLE plante_stock ADD CONSTRAINT FK_2E8D916B7DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id)');
        $this->addSql('ALTER TABLE stock_divers ADD CONSTRAINT FK_A8EEE63C7DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id)');
        $this->addSql('DROP TABLE animal_batch');
        $this->addSql('DROP INDEX IDX_6AAB231F809303D ON animal');
        $this->addSql('ALTER TABLE animal ADD unit_animal VARCHAR(255) NOT NULL, DROP animalbatch_id');
        $this->addSql('ALTER TABLE gestation ADD preparation_velage DATE NOT NULL, ADD velage_prevu DATE NOT NULL, DROP preparation_vêlage, DROP vêlage_prévu');
        $this->addSql('ALTER TABLE presence CHANGE id_p id_p INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE user_nom user_nom VARCHAR(100) NOT NULL, CHANGE user_prenom user_prenom VARCHAR(100) NOT NULL, CHANGE user_email user_email VARCHAR(100) NOT NULL, CHANGE user_telephone user_telephone VARCHAR(100) NOT NULL, CHANGE user_role user_role VARCHAR(100) NOT NULL, CHANGE user_genre user_genre VARCHAR(100) NOT NULL, CHANGE username username VARCHAR(100) NOT NULL, CHANGE password password VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_batch (id INT AUTO_INCREMENT NOT NULL, espece_animal_batch VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sexe_ration VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, poidsmax_ration DOUBLE PRECISION NOT NULL, poidsmin_ration DOUBLE PRECISION NOT NULL, age_animal_batch VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nombre_animal_batch INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE animal_stock DROP FOREIGN KEY FK_6AC58F947DC7170A');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E95D91DD3E');
        $this->addSql('ALTER TABLE plante_stock DROP FOREIGN KEY FK_2E8D916B7DC7170A');
        $this->addSql('ALTER TABLE stock_divers DROP FOREIGN KEY FK_A8EEE63C7DC7170A');
        $this->addSql('DROP TABLE animal_stock');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE plante_stock');
        $this->addSql('DROP TABLE stock_divers');
        $this->addSql('DROP TABLE vente');
        $this->addSql('ALTER TABLE animal ADD animalbatch_id INT DEFAULT NULL, DROP unit_animal');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F809303D FOREIGN KEY (animalbatch_id) REFERENCES animal_batch (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F809303D ON animal (animalbatch_id)');
        $this->addSql('ALTER TABLE gestation ADD preparation_vêlage DATE NOT NULL, ADD vêlage_prévu DATE NOT NULL, DROP preparation_velage, DROP velage_prevu');
        $this->addSql('ALTER TABLE presence CHANGE id_p id_p INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE user_nom user_nom VARCHAR(255) NOT NULL, CHANGE user_prenom user_prenom VARCHAR(255) NOT NULL, CHANGE user_email user_email VARCHAR(255) NOT NULL, CHANGE user_telephone user_telephone VARCHAR(255) NOT NULL, CHANGE user_role user_role VARCHAR(255) NOT NULL, CHANGE user_genre user_genre VARCHAR(255) NOT NULL, CHANGE username username VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL');
    }
}
