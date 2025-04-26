<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250426124448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates users, sectors and user_sectors tables with necessary relations';
    }

    public function up(Schema $schema): void
    {
        // Create sectors table
        $this->addSql(<<<'SQL'
            CREATE TABLE sectors (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);

        // Create users table
        $this->addSql(<<<'SQL'
            CREATE TABLE users (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                agree_terms TINYINT(1) NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);

        // Create pivot table user_sectors
        $this->addSql(<<<'SQL'
            CREATE TABLE user_sectors (
                user_id INT NOT NULL,
                sector_id INT NOT NULL,
                INDEX IDX_USER (user_id),
                INDEX IDX_SECTOR (sector_id),
                PRIMARY KEY(user_id, sector_id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);

        // Add foreign keys, referencing the correct table names
        $this->addSql(<<<'SQL'
            ALTER TABLE user_sectors
              ADD CONSTRAINT FK_USER FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
              ADD CONSTRAINT FK_SECTOR FOREIGN KEY (sector_id) REFERENCES sectors (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // Drop foreign keys first
        $this->addSql("ALTER TABLE user_sectors DROP FOREIGN KEY FK_USER");
        $this->addSql("ALTER TABLE user_sectors DROP FOREIGN KEY FK_SECTOR");

        // Then drop tables
        $this->addSql("DROP TABLE user_sectors");
        $this->addSql("DROP TABLE users");
        $this->addSql("DROP TABLE sectors");
    }
}
