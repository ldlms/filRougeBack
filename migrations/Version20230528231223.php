<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528231223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre CHANGE isbn id_api VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE note CHANGE livre_id livre_id INT DEFAULT NULL, CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre CHANGE id_api isbn VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE note CHANGE livre_id livre_id INT NOT NULL, CHANGE utilisateur_id utilisateur_id INT NOT NULL');
    }
}
