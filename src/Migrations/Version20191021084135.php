<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191021084135 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

       // $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, orientation VARCHAR(255) NOT NULL, medium_temperature INT NOT NULL, humidity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
       // $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
     //   $this->addSql('CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
      //  $this->addSql('CREATE TABLE action_history (id INT AUTO_INCREMENT NOT NULL, id_action_id INT NOT NULL, id_user_id INT NOT NULL, id_plant_id INT NOT NULL, date DATETIME NOT NULL, quantity DOUBLE PRECISION NOT NULL, INDEX IDX_FD18F8AA1D074C12 (id_action_id), INDEX IDX_FD18F8AA79F37AE5 (id_user_id), INDEX IDX_FD18F8AA4D48BAC7 (id_plant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
      //  $this->addSql('CREATE TABLE plant (id INT AUTO_INCREMENT NOT NULL, id_species_id INT NOT NULL, id_place_id INT NOT NULL, id_medium_id INT NOT NULL, name VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, INDEX IDX_AB030D72172B58B7 (id_species_id), INDEX IDX_AB030D725D7D4E8C (id_place_id), INDEX IDX_AB030D7262670A82 (id_medium_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
     //   $this->addSql('CREATE TABLE stage_history (id INT AUTO_INCREMENT NOT NULL, id_stage_id INT NOT NULL, id_plant_id INT DEFAULT NULL, date DATE NOT NULL, photo VARCHAR(255) NOT NULL, INDEX IDX_AD43300672433D06 (id_stage_id), INDEX IDX_AD4330064D48BAC7 (id_plant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    //    $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
      //  $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
      //  $this->addSql('CREATE TABLE medium (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    //    $this->addSql('ALTER TABLE action_history ADD CONSTRAINT FK_FD18F8AA1D074C12 FOREIGN KEY (id_action_id) REFERENCES action (id)');
     //   $this->addSql('ALTER TABLE action_history ADD CONSTRAINT FK_FD18F8AA79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
     //   $this->addSql('ALTER TABLE action_history ADD CONSTRAINT FK_FD18F8AA4D48BAC7 FOREIGN KEY (id_plant_id) REFERENCES plant (id)');
        // $this->addSql('ALTER TABLE plant ADD CONSTRAINT FK_AB030D72172B58B7 FOREIGN KEY (id_species_id) REFERENCES species (id)');
        //   $this->addSql('ALTER TABLE plant ADD CONSTRAINT FK_AB030D725D7D4E8C FOREIGN KEY (id_place_id) REFERENCES place (id)');
        //   $this->addSql('ALTER TABLE plant ADD CONSTRAINT FK_AB030D7262670A82 FOREIGN KEY (id_medium_id) REFERENCES medium (id)');
        //   $this->addSql('ALTER TABLE stage_history ADD CONSTRAINT FK_AD43300672433D06 FOREIGN KEY (id_stage_id) REFERENCES stage (id)');
        //  $this->addSql('ALTER TABLE stage_history ADD CONSTRAINT FK_AD4330064D48BAC7 FOREIGN KEY (id_plant_id) REFERENCES plant (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE plant DROP FOREIGN KEY FK_AB030D725D7D4E8C');
        $this->addSql('ALTER TABLE action_history DROP FOREIGN KEY FK_FD18F8AA79F37AE5');
        $this->addSql('ALTER TABLE plant DROP FOREIGN KEY FK_AB030D72172B58B7');
        $this->addSql('ALTER TABLE action_history DROP FOREIGN KEY FK_FD18F8AA4D48BAC7');
        $this->addSql('ALTER TABLE stage_history DROP FOREIGN KEY FK_AD4330064D48BAC7');
        $this->addSql('ALTER TABLE stage_history DROP FOREIGN KEY FK_AD43300672433D06');
        $this->addSql('ALTER TABLE action_history DROP FOREIGN KEY FK_FD18F8AA1D074C12');
        $this->addSql('ALTER TABLE plant DROP FOREIGN KEY FK_AB030D7262670A82');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE species');
        $this->addSql('DROP TABLE action_history');
        $this->addSql('DROP TABLE plant');
        $this->addSql('DROP TABLE stage_history');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE medium');
    }
}
