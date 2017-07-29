<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20161212052641 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql(
            'CREATE TABLE `password_resets` (`email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `created_at` timestamp NOT NULL,
              KEY `password_resets_email_index` (`email`),
              KEY `password_resets_token_index` (`token`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql(
            'DROP TABLE `password_resets`'
        );
    }
}
