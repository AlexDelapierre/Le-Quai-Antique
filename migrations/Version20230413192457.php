<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413192457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE couvert (id INT AUTO_INCREMENT NOT NULL, max_couverts INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formule (id INT AUTO_INCREMENT NOT NULL, menu_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_605C9C98CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galerie (id INT AUTO_INCREMENT NOT NULL, plat_id INT NOT NULL, UNIQUE INDEX UNIQ_9E7D1590D73DB560 (plat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaire (id INT AUTO_INCREMENT NOT NULL, monday LONGTEXT NOT NULL, tuesday LONGTEXT NOT NULL, wednesday LONGTEXT NOT NULL, thursday LONGTEXT NOT NULL, friday LONGTEXT NOT NULL, saturday LONGTEXT NOT NULL, sunday LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE midi (id INT AUTO_INCREMENT NOT NULL, time TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plat (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_2038A20712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, midi_id INT DEFAULT NULL, soir_id INT DEFAULT NULL, user_id INT DEFAULT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, phone_number VARCHAR(255) NOT NULL, nb_couverts INT NOT NULL, date DATE NOT NULL, service VARCHAR(4) NOT NULL, comments LONGTEXT DEFAULT NULL, INDEX IDX_42C84955EB6AD9EF (midi_id), INDEX IDX_42C84955755AC94E (soir_id), INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE soir (id INT AUTO_INCREMENT NOT NULL, time TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, phone_number VARCHAR(255) NOT NULL, nb_couverts INT DEFAULT NULL, allergie LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formule ADD CONSTRAINT FK_605C9C98CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE galerie ADD CONSTRAINT FK_9E7D1590D73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id)');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A20712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955EB6AD9EF FOREIGN KEY (midi_id) REFERENCES midi (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955755AC94E FOREIGN KEY (soir_id) REFERENCES soir (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE formule DROP FOREIGN KEY FK_605C9C98CCD7E912');
        $this->addSql('ALTER TABLE galerie DROP FOREIGN KEY FK_9E7D1590D73DB560');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A20712469DE2');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955EB6AD9EF');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955755AC94E');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE couvert');
        $this->addSql('DROP TABLE formule');
        $this->addSql('DROP TABLE galerie');
        $this->addSql('DROP TABLE horaire');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE midi');
        $this->addSql('DROP TABLE plat');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE soir');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
