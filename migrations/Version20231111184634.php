<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231111184634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_stock (id INT AUTO_INCREMENT NOT NULL, vente_id INT DEFAULT NULL, nom_animal VARCHAR(255) NOT NULL, sexe_animal VARCHAR(255) NOT NULL, age_animal INT NOT NULL, poids_animal DOUBLE PRECISION NOT NULL, health VARCHAR(255) NOT NULL, date_entree_stock DATE NOT NULL, INDEX IDX_6AC58F947DC7170A (vente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plante_stock (id INT AUTO_INCREMENT NOT NULL, vente_id INT DEFAULT NULL, nom_plante VARCHAR(255) NOT NULL, etat_plante VARCHAR(255) NOT NULL, quantite_plante DOUBLE PRECISION NOT NULL, date_entree_stock DATE NOT NULL, INDEX IDX_2E8D916B7DC7170A (vente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_divers (id INT AUTO_INCREMENT NOT NULL, vente_id INT DEFAULT NULL, nom_sd VARCHAR(255) NOT NULL, quantite_sd DOUBLE PRECISION NOT NULL, health VARCHAR(255) NOT NULL, date_entree_stock DATE NOT NULL, INDEX IDX_A8EEE63C7DC7170A (vente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_stock ADD CONSTRAINT FK_6AC58F947DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id)');
        $this->addSql('ALTER TABLE plante_stock ADD CONSTRAINT FK_2E8D916B7DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id)');
        $this->addSql('ALTER TABLE stock_divers ADD CONSTRAINT FK_A8EEE63C7DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_stock DROP FOREIGN KEY FK_6AC58F947DC7170A');
        $this->addSql('ALTER TABLE plante_stock DROP FOREIGN KEY FK_2E8D916B7DC7170A');
        $this->addSql('ALTER TABLE stock_divers DROP FOREIGN KEY FK_A8EEE63C7DC7170A');
        $this->addSql('DROP TABLE animal_stock');
        $this->addSql('DROP TABLE plante_stock');
        $this->addSql('DROP TABLE stock_divers');
        $this->addSql('DROP TABLE vente');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
