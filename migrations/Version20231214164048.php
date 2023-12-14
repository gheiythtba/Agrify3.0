<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214164048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, task_title VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, deadline DATE NOT NULL, status VARCHAR(255) NOT NULL, assignedChef_id INT DEFAULT NULL, INDEX IDX_527EDB25BB923E60 (assignedChef_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25BB923E60 FOREIGN KEY (assignedChef_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE todo ADD parent_task_id INT DEFAULT NULL, ADD todo_description VARCHAR(255) NOT NULL, ADD severity VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE todo ADD CONSTRAINT FK_5A0EB6A0FFFE75C0 FOREIGN KEY (parent_task_id) REFERENCES task (id)');
        $this->addSql('CREATE INDEX IDX_5A0EB6A0FFFE75C0 ON todo (parent_task_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE todo DROP FOREIGN KEY FK_5A0EB6A0FFFE75C0');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25BB923E60');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP INDEX IDX_5A0EB6A0FFFE75C0 ON todo');
        $this->addSql('ALTER TABLE todo DROP parent_task_id, DROP todo_description, DROP severity');
    }
}
