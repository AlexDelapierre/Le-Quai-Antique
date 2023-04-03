<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230402155506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD midi_id INT DEFAULT NULL, ADD soir_id INT DEFAULT NULL, ADD date DATE NOT NULL, DROP date_time');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955EB6AD9EF FOREIGN KEY (midi_id) REFERENCES midi (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955755AC94E FOREIGN KEY (soir_id) REFERENCES soir (id)');
        $this->addSql('CREATE INDEX IDX_42C84955EB6AD9EF ON reservation (midi_id)');
        $this->addSql('CREATE INDEX IDX_42C84955755AC94E ON reservation (soir_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955EB6AD9EF');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955755AC94E');
        $this->addSql('DROP INDEX IDX_42C84955EB6AD9EF ON reservation');
        $this->addSql('DROP INDEX IDX_42C84955755AC94E ON reservation');
        $this->addSql('ALTER TABLE reservation ADD date_time DATETIME NOT NULL, DROP midi_id, DROP soir_id, DROP date');
    }
}
