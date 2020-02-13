<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200213112558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE picking_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE picking ADD id INT NOT NULL');
        $this->addSql('ALTER TABLE picking ALTER date_heure DROP DEFAULT');
        $this->addSql('ALTER TABLE picking ALTER num_dossier TYPE VARCHAR(10)');
        $this->addSql('ALTER TABLE picking ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE picking_id_seq CASCADE');
        $this->addSql('DROP INDEX "primary"');
        $this->addSql('ALTER TABLE picking DROP id');
        $this->addSql('ALTER TABLE picking ALTER date_heure SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE picking ALTER num_dossier TYPE CHAR(10)');
    }
}
