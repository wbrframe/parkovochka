<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230731125855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE file_relations (id UUID NOT NULL, file_id UUID NOT NULL, parking_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9A63000E93CB796C ON file_relations (file_id)');
        $this->addSql('CREATE INDEX IDX_9A63000EF17B2DD ON file_relations (parking_id)');
        $this->addSql('COMMENT ON COLUMN file_relations.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN file_relations.file_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN file_relations.parking_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN file_relations.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE files (id UUID NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, file_name VARCHAR(255) DEFAULT NULL, file_original_name VARCHAR(255) DEFAULT NULL, file_mime_type VARCHAR(255) DEFAULT NULL, file_size INT DEFAULT NULL, file_dimensions TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN files.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN files.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN files.file_dimensions IS \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE file_relations ADD CONSTRAINT FK_9A63000E93CB796C FOREIGN KEY (file_id) REFERENCES files (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE file_relations ADD CONSTRAINT FK_9A63000EF17B2DD FOREIGN KEY (parking_id) REFERENCES parkings (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parkings ADD photo_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN parkings.photo_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE parkings ADD CONSTRAINT FK_AB6C607B7E9E4C8C FOREIGN KEY (photo_id) REFERENCES file_relations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB6C607B7E9E4C8C ON parkings (photo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parkings DROP CONSTRAINT FK_AB6C607B7E9E4C8C');
        $this->addSql('ALTER TABLE file_relations DROP CONSTRAINT FK_9A63000E93CB796C');
        $this->addSql('ALTER TABLE file_relations DROP CONSTRAINT FK_9A63000EF17B2DD');
        $this->addSql('DROP TABLE file_relations');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP INDEX UNIQ_AB6C607B7E9E4C8C');
        $this->addSql('ALTER TABLE parkings DROP photo_id');
    }
}
