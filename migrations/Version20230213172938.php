<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213172938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_midi (id INT AUTO_INCREMENT NOT NULL, horaire TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_soir (id INT AUTO_INCREMENT NOT NULL, horaire TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formule CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD service_midi_id INT DEFAULT NULL, ADD service_soir_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495524EE8B73 FOREIGN KEY (service_midi_id) REFERENCES service_midi (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955BADE9BD2 FOREIGN KEY (service_soir_id) REFERENCES service_soir (id)');
        $this->addSql('CREATE INDEX IDX_42C8495524EE8B73 ON reservation (service_midi_id)');
        $this->addSql('CREATE INDEX IDX_42C84955BADE9BD2 ON reservation (service_soir_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495524EE8B73');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955BADE9BD2');
        $this->addSql('DROP TABLE service_midi');
        $this->addSql('DROP TABLE service_soir');
        $this->addSql('ALTER TABLE formule CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX IDX_42C8495524EE8B73 ON reservation');
        $this->addSql('DROP INDEX IDX_42C84955BADE9BD2 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP service_midi_id, DROP service_soir_id');
    }
}
