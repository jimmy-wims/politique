<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330160201 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9C3F18EF8947610D ON affaire (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3946A25443C3D9C3 ON mairie (ville)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_94225E846C6E55B5 ON parti (nom)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7F73E4D6C6E55B5 ON politicien (nom)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX UNIQ_9C3F18EF8947610D ON affaire');
        $this->addSql('DROP INDEX UNIQ_3946A25443C3D9C3 ON mairie');
        $this->addSql('DROP INDEX UNIQ_94225E846C6E55B5 ON parti');
        $this->addSql('DROP INDEX UNIQ_D7F73E4D6C6E55B5 ON politicien');
    }
}
