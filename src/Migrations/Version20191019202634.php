<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191019202634 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $encoded = password_hash('admin', PASSWORD_ARGON2I);
        $now = new \DateTime();
        $now  = $now ->format('Y-m-d H:i:s');
        $user = array('encoded' => $encoded, 'now' => $now);
        $this->addSql('INSERT INTO user(`id`, `email`, `roles`, `password`, `name`, `last_name`, `phone`, `photo`, `created_at`) VALUES (null,"admin@admin.org",\'["ROLE_ADMIN", "ROLE_USER"]\',:encoded,"admin","admin","+33126273849","default.jpg",:now)', $user);

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
