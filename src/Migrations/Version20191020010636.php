<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020010636 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $stages = array(
            array('name'=>'seeds planted'),
            array('name'=>'germination'),
            array('name'=>'growing'),
            array('name'=>'flowering'),
            array('name'=>'fruits producing'),
            array('name'=>'seeds releasing')
        );
        foreach ($stages as $stage)
        {
            $this->addSql('INSERT INTO stage(`id`, `name`) VALUES (null, :name)', $stage);
        }

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
