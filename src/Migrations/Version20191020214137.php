<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020214137 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $species = array(
            array('name'=>'Flowering Plants', 'photo' => 'default-plant-type.jpg'),
            array('name'=>'Foliage Plants', 'photo' =>'default-plant-type.jpg'),
            array('name'=>'Cactus Plants', 'photo' =>'default-plant-type.jpg'),
            array('name'=>'Indoor Palm Plants', 'photo' => 'default-plant-type.jpg'),
            array('name'=>'Trailing & Climbing Plants', 'photo' =>'default-plant-type.jpg'),
            array('name'=>'Tree Type Plants', 'photo' =>'default-plant-type.jpg'),
            array('name'=>'Succulent Plants', 'photo' =>'default-plant-type.jpg'),
            array('name'=>'Living Stone Types', 'photo' =>'default-plant-type.jpg'),
            array('name'=>'Unusual Plants', 'photo' =>'default-plant-type.jpg'),
            array('name'=>'Aromatic Plants', 'photo' =>'default-plant-type.jpg'),
            array('name'=>'Vegetables', 'photo' =>'default-plant-type.jpg'),
            array('name'=>'Trees', 'photo' =>'default-plant-type.jpg'),
        );

        foreach ($species as $spec)
        {
            $this->addSql('INSERT INTO species(`id`, `name`, `photo`) VALUES (null, :name, :photo)', $spec);
        }

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
