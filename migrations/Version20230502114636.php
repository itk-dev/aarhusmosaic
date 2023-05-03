<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502114636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE screen_tags (screen_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_6F0261A941A67722 (screen_id), INDEX IDX_6F0261A98D7B4FB4 (tags_id), PRIMARY KEY(screen_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE screen_tags ADD CONSTRAINT FK_6F0261A941A67722 FOREIGN KEY (screen_id) REFERENCES screen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE screen_tags ADD CONSTRAINT FK_6F0261A98D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE screen_tags DROP FOREIGN KEY FK_6F0261A941A67722');
        $this->addSql('ALTER TABLE screen_tags DROP FOREIGN KEY FK_6F0261A98D7B4FB4');
        $this->addSql('DROP TABLE screen_tags');
    }
}
