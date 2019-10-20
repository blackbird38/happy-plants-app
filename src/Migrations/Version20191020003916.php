<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020003916 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $mediums = array(
            array('name'=>'loam soil'),
            array('name'=>'sandy soil'),
            array('name'=>'clay soil'),
            array('name'=>'lightweight expanded clay aggregate'),
            array('name'=>'perlite'),
            array('name'=>'vermiculite'),
            array('name'=>'rockwool'),
            array('name'=>'oasis cubes'),
            array('name'=>'coco coir'),
            array('name'=>'parboiled rice husks'),
            array('name'=>'pine bark')
        );
        foreach ($mediums as $medium)
        {
            $this->addSql('INSERT INTO medium(`id`, `name`) VALUES (null, :name)', $medium);
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
