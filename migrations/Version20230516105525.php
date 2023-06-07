<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516105525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, note_id INT NOT NULL, texte LONGTEXT NOT NULL, INDEX IDX_67F068BCFB88E14F (utilisateur_id), INDEX IDX_67F068BC26ED0855 (note_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, livre_id INT NOT NULL, utilisateur_id INT NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_8933C43237D925CB (livre_id), INDEX IDX_8933C432FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris_utilisateur (id INT AUTO_INCREMENT NOT NULL, utilisateur1_id INT NOT NULL, utilisateur2_id INT NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_E3F1A90B30F4F973 (utilisateur1_id), INDEX IDX_E3F1A90B2241569D (utilisateur2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, date DATE NOT NULL, isbn VARCHAR(50) DEFAULT NULL, couverture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre_liste (livre_id INT NOT NULL, liste_id INT NOT NULL, INDEX IDX_6FF1B29237D925CB (livre_id), INDEX IDX_6FF1B292E85441D8 (liste_id), PRIMARY KEY(livre_id, liste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, livre_id INT NOT NULL, utilisateur_id INT NOT NULL, date DATE NOT NULL, score INT NOT NULL, critique LONGTEXT DEFAULT NULL, INDEX IDX_CFBDFA1437D925CB (livre_id), INDEX IDX_CFBDFA14FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(100) NOT NULL, mail VARCHAR(100) NOT NULL, role INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC26ED0855 FOREIGN KEY (note_id) REFERENCES note (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43237D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE favoris_utilisateur ADD CONSTRAINT FK_E3F1A90B30F4F973 FOREIGN KEY (utilisateur1_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE favoris_utilisateur ADD CONSTRAINT FK_E3F1A90B2241569D FOREIGN KEY (utilisateur2_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE livre_liste ADD CONSTRAINT FK_6FF1B29237D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_liste ADD CONSTRAINT FK_6FF1B292E85441D8 FOREIGN KEY (liste_id) REFERENCES liste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1437D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCFB88E14F');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC26ED0855');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C43237D925CB');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432FB88E14F');
        $this->addSql('ALTER TABLE favoris_utilisateur DROP FOREIGN KEY FK_E3F1A90B30F4F973');
        $this->addSql('ALTER TABLE favoris_utilisateur DROP FOREIGN KEY FK_E3F1A90B2241569D');
        $this->addSql('ALTER TABLE livre_liste DROP FOREIGN KEY FK_6FF1B29237D925CB');
        $this->addSql('ALTER TABLE livre_liste DROP FOREIGN KEY FK_6FF1B292E85441D8');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1437D925CB');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14FB88E14F');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE favoris_utilisateur');
        $this->addSql('DROP TABLE liste');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE livre_liste');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE `user`');
    }
}
