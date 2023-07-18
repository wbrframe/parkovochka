<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230718215529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parkings ADD capacity VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE parkings ADD security BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE parkings ADD light BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE parkings ADD traffic VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE parkings ADD weather_protection BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE parkings ADD user_rating INT NOT NULL');
        $this->addSql('ALTER TABLE parkings ADD description VARCHAR(500) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parkings DROP capacity');
        $this->addSql('ALTER TABLE parkings DROP security');
        $this->addSql('ALTER TABLE parkings DROP light');
        $this->addSql('ALTER TABLE parkings DROP traffic');
        $this->addSql('ALTER TABLE parkings DROP weather_protection');
        $this->addSql('ALTER TABLE parkings DROP user_rating');
        $this->addSql('ALTER TABLE parkings DROP description');
    }
}
