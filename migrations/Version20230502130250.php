<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502130250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE screen ADD api_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE screen ADD CONSTRAINT FK_DF4C61304A50A7F2 FOREIGN KEY (api_user_id) REFERENCES api_user (id)');
        $this->addSql('CREATE INDEX IDX_DF4C61304A50A7F2 ON screen (api_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE screen DROP FOREIGN KEY FK_DF4C61304A50A7F2');
        $this->addSql('DROP INDEX IDX_DF4C61304A50A7F2 ON screen');
        $this->addSql('ALTER TABLE screen DROP api_user_id');
    }
}
