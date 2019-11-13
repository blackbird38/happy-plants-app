<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113013432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action_history DROP FOREIGN KEY FK_FD18F8AA4D48BAC7');
        $this->addSql('ALTER TABLE action_history ADD CONSTRAINT FK_FD18F8AA4D48BAC7 FOREIGN KEY (id_plant_id) REFERENCES plant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plant DROP FOREIGN KEY FK_AB030D725D7D4E8C');
        $this->addSql('ALTER TABLE plant ADD CONSTRAINT FK_AB030D725D7D4E8C FOREIGN KEY (id_place_id) REFERENCES place (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage_history DROP FOREIGN KEY FK_AD4330064D48BAC7');
        $this->addSql('ALTER TABLE stage_history CHANGE id_plant_id id_plant_id INT NOT NULL');
        $this->addSql('ALTER TABLE stage_history ADD CONSTRAINT FK_AD4330064D48BAC7 FOREIGN KEY (id_plant_id) REFERENCES plant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action_history DROP FOREIGN KEY FK_FD18F8AA4D48BAC7');
        $this->addSql('ALTER TABLE action_history ADD CONSTRAINT FK_FD18F8AA4D48BAC7 FOREIGN KEY (id_plant_id) REFERENCES plant (id)');
        $this->addSql('ALTER TABLE plant DROP FOREIGN KEY FK_AB030D725D7D4E8C');
        $this->addSql('ALTER TABLE plant ADD CONSTRAINT FK_AB030D725D7D4E8C FOREIGN KEY (id_place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE stage_history DROP FOREIGN KEY FK_AD4330064D48BAC7');
        $this->addSql('ALTER TABLE stage_history CHANGE id_plant_id id_plant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stage_history ADD CONSTRAINT FK_AD4330064D48BAC7 FOREIGN KEY (id_plant_id) REFERENCES plant (id)');
    }
}
