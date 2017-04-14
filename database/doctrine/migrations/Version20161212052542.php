<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20161212052542 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE jobs (id INT UNSIGNED AUTO_INCREMENT NOT NULL, account_id INT UNSIGNED NOT NULL, location_id INT UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, customer VARCHAR(255) NOT NULL, productivity LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_A8936DC59B6B5FBA (account_id), INDEX IDX_A8936DC564D218E (location_id), UNIQUE INDEX jobs_account_id_name_deleted_at_unique (account_id, name, deleted_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, account_id INT UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) DEFAULT \'admin\' NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, timezone VARCHAR(255) DEFAULT \'America/Los_Angeles\' NOT NULL, remember_token VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), INDEX IDX_1483A5E99B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reports (id VARCHAR(36) NOT NULL, account_id INT UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL, note VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, parameters LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_F11FA745BF396750 (id), INDEX IDX_F11FA7459B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accounts (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, timezone VARCHAR(255) DEFAULT \'America/Los_Angeles\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations (id INT UNSIGNED AUTO_INCREMENT NOT NULL, account_id INT UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_17E64ABA5E237E06 (name), INDEX IDX_17E64ABA9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employees (id INT UNSIGNED AUTO_INCREMENT NOT NULL, account_id INT UNSIGNED NOT NULL, location_id INT UNSIGNED NOT NULL, agency_id INT UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL, position VARCHAR(255) DEFAULT NULL, terminal_key VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_BA82C3009B6B5FBA (account_id), INDEX IDX_BA82C30064D218E (location_id), INDEX IDX_BA82C300CDEADB2A (agency_id), INDEX employees_name_index (name), UNIQUE INDEX employees_account_id_terminal_key_deleted_at_unique (account_id, terminal_key, deleted_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_shifts (id INT UNSIGNED AUTO_INCREMENT NOT NULL, account_id INT UNSIGNED NOT NULL, job_id INT UNSIGNED NOT NULL, comments VARCHAR(255) DEFAULT NULL, productivity LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\', closed TINYINT(1) NOT NULL, paused TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4D195CAE9B6B5FBA (account_id), INDEX IDX_4D195CAEBE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rounding_rules (id INT UNSIGNED AUTO_INCREMENT NOT NULL, account_id INT UNSIGNED NOT NULL, start TIME NOT NULL, end TIME NOT NULL, criteria LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', resolution TIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5CAECD8A9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agencies (id INT UNSIGNED AUTO_INCREMENT NOT NULL, account_id INT UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F65A4DC49B6B5FBA (account_id), UNIQUE INDEX agencies_account_id_name_unique (account_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE timesheets (id INT UNSIGNED AUTO_INCREMENT NOT NULL, account_id INT UNSIGNED NOT NULL, employee_id INT UNSIGNED NOT NULL, job_id INT UNSIGNED NOT NULL, job_shift_id INT UNSIGNED NOT NULL, time_in DATETIME NOT NULL, time_out DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_9AC77D2E9B6B5FBA (account_id), INDEX IDX_9AC77D2E8C03F15C (employee_id), INDEX IDX_9AC77D2EBE04EA9 (job_id), INDEX IDX_9AC77D2EDC371975 (job_shift_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paused_timesheets (id INT UNSIGNED AUTO_INCREMENT NOT NULL, account_id INT UNSIGNED NOT NULL, job_shift_id INT UNSIGNED NOT NULL, employee_id INT UNSIGNED NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3324D3E19B6B5FBA (account_id), INDEX IDX_3324D3E1DC371975 (job_shift_id), INDEX IDX_3324D3E18C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC59B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
        $this->addSql('ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC564D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E99B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA7459B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABA9B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
        $this->addSql('ALTER TABLE employees ADD CONSTRAINT FK_BA82C3009B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
        $this->addSql('ALTER TABLE employees ADD CONSTRAINT FK_BA82C30064D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE employees ADD CONSTRAINT FK_BA82C300CDEADB2A FOREIGN KEY (agency_id) REFERENCES agencies (id)');
        $this->addSql('ALTER TABLE job_shifts ADD CONSTRAINT FK_4D195CAE9B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
        $this->addSql('ALTER TABLE job_shifts ADD CONSTRAINT FK_4D195CAEBE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id)');
        $this->addSql('ALTER TABLE rounding_rules ADD CONSTRAINT FK_5CAECD8A9B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
        $this->addSql('ALTER TABLE agencies ADD CONSTRAINT FK_F65A4DC49B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
        $this->addSql('ALTER TABLE timesheets ADD CONSTRAINT FK_9AC77D2E9B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
        $this->addSql('ALTER TABLE timesheets ADD CONSTRAINT FK_9AC77D2E8C03F15C FOREIGN KEY (employee_id) REFERENCES employees (id)');
        $this->addSql('ALTER TABLE timesheets ADD CONSTRAINT FK_9AC77D2EBE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id)');
        $this->addSql('ALTER TABLE timesheets ADD CONSTRAINT FK_9AC77D2EDC371975 FOREIGN KEY (job_shift_id) REFERENCES job_shifts (id)');
        $this->addSql('ALTER TABLE paused_timesheets ADD CONSTRAINT FK_3324D3E19B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
        $this->addSql('ALTER TABLE paused_timesheets ADD CONSTRAINT FK_3324D3E1DC371975 FOREIGN KEY (job_shift_id) REFERENCES job_shifts (id)');
        $this->addSql('ALTER TABLE paused_timesheets ADD CONSTRAINT FK_3324D3E18C03F15C FOREIGN KEY (employee_id) REFERENCES employees (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE job_shifts DROP FOREIGN KEY FK_4D195CAEBE04EA9');
        $this->addSql('ALTER TABLE timesheets DROP FOREIGN KEY FK_9AC77D2EBE04EA9');
        $this->addSql('ALTER TABLE jobs DROP FOREIGN KEY FK_A8936DC59B6B5FBA');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E99B6B5FBA');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA7459B6B5FBA');
        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_17E64ABA9B6B5FBA');
        $this->addSql('ALTER TABLE employees DROP FOREIGN KEY FK_BA82C3009B6B5FBA');
        $this->addSql('ALTER TABLE job_shifts DROP FOREIGN KEY FK_4D195CAE9B6B5FBA');
        $this->addSql('ALTER TABLE rounding_rules DROP FOREIGN KEY FK_5CAECD8A9B6B5FBA');
        $this->addSql('ALTER TABLE agencies DROP FOREIGN KEY FK_F65A4DC49B6B5FBA');
        $this->addSql('ALTER TABLE timesheets DROP FOREIGN KEY FK_9AC77D2E9B6B5FBA');
        $this->addSql('ALTER TABLE paused_timesheets DROP FOREIGN KEY FK_3324D3E19B6B5FBA');
        $this->addSql('ALTER TABLE jobs DROP FOREIGN KEY FK_A8936DC564D218E');
        $this->addSql('ALTER TABLE employees DROP FOREIGN KEY FK_BA82C30064D218E');
        $this->addSql('ALTER TABLE timesheets DROP FOREIGN KEY FK_9AC77D2E8C03F15C');
        $this->addSql('ALTER TABLE paused_timesheets DROP FOREIGN KEY FK_3324D3E18C03F15C');
        $this->addSql('ALTER TABLE timesheets DROP FOREIGN KEY FK_9AC77D2EDC371975');
        $this->addSql('ALTER TABLE paused_timesheets DROP FOREIGN KEY FK_3324D3E1DC371975');
        $this->addSql('ALTER TABLE employees DROP FOREIGN KEY FK_BA82C300CDEADB2A');
        $this->addSql('DROP TABLE jobs');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE reports');
        $this->addSql('DROP TABLE accounts');
        $this->addSql('DROP TABLE locations');
        $this->addSql('DROP TABLE employees');
        $this->addSql('DROP TABLE job_shifts');
        $this->addSql('DROP TABLE rounding_rules');
        $this->addSql('DROP TABLE agencies');
        $this->addSql('DROP TABLE timesheets');
        $this->addSql('DROP TABLE paused_timesheets');
    }
}
