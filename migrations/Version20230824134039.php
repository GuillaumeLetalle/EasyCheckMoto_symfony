<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230824134039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(25) NOT NULL, firstname VARCHAR(25) NOT NULL, email VARCHAR(50) NOT NULL, phone VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_C7440455F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ct (id INT AUTO_INCREMENT NOT NULL, vehicule_controle_id INT DEFAULT NULL, technicien_controle_id INT DEFAULT NULL, debut DATETIME NOT NULL, fin DATETIME DEFAULT NULL, freinage TINYINT(1) DEFAULT NULL, direction TINYINT(1) DEFAULT NULL, visibilite TINYINT(1) DEFAULT NULL, eclairage_signalisation TINYINT(1) DEFAULT NULL, pneumatique TINYINT(1) DEFAULT NULL, carrosserie TINYINT(1) DEFAULT NULL, mecanique TINYINT(1) DEFAULT NULL, equipement TINYINT(1) DEFAULT NULL, pollution TINYINT(1) DEFAULT NULL, niveau_sonore TINYINT(1) DEFAULT NULL, moto_is_ok TINYINT(1) DEFAULT NULL, commentaires LONGTEXT DEFAULT NULL, INDEX IDX_58619FBE33BC8745 (vehicule_controle_id), INDEX IDX_58619FBE77DE0BA9 (technicien_controle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moto (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, marque VARCHAR(50) DEFAULT NULL, modele VARCHAR(50) DEFAULT NULL, cylindree VARCHAR(10) DEFAULT NULL, annee VARCHAR(10) DEFAULT NULL, immatriculation VARCHAR(15) NOT NULL, INDEX IDX_3DDDBCE419EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technicien (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(25) NOT NULL, firstname VARCHAR(25) NOT NULL, UNIQUE INDEX UNIQ_96282C4CF85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ct ADD CONSTRAINT FK_58619FBE33BC8745 FOREIGN KEY (vehicule_controle_id) REFERENCES moto (id)');
        $this->addSql('ALTER TABLE ct ADD CONSTRAINT FK_58619FBE77DE0BA9 FOREIGN KEY (technicien_controle_id) REFERENCES technicien (id)');
        $this->addSql('ALTER TABLE moto ADD CONSTRAINT FK_3DDDBCE419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ct DROP FOREIGN KEY FK_58619FBE33BC8745');
        $this->addSql('ALTER TABLE ct DROP FOREIGN KEY FK_58619FBE77DE0BA9');
        $this->addSql('ALTER TABLE moto DROP FOREIGN KEY FK_3DDDBCE419EB6921');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE ct');
        $this->addSql('DROP TABLE moto');
        $this->addSql('DROP TABLE technicien');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
