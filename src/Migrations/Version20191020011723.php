<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020011723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $actions = array(
            array('name'=>'watering'),
            array('name'=>'fertilizing'),
            array('name'=>'cleaning'),
        );
        foreach ($actions as $action)
        {
            $this->addSql('INSERT INTO action(`id`, `name`) VALUES (null, :name)', $action);
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
