<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321172033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire ADD tuesday LONGTEXT NOT NULL, ADD wednesday LONGTEXT NOT NULL, ADD thursday LONGTEXT NOT NULL, ADD friday LONGTEXT NOT NULL, ADD saturday LONGTEXT NOT NULL, ADD sunday LONGTEXT NOT NULL, CHANGE horaires monday LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire ADD horaires LONGTEXT NOT NULL, DROP monday, DROP tuesday, DROP wednesday, DROP thursday, DROP friday, DROP saturday, DROP sunday');
    }
}
