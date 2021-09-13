<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210909122706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shipping_amount (id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE street ADD shipping_amount_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street ADD CONSTRAINT FK_F0EED3D8DD4427AF FOREIGN KEY (shipping_amount_id) REFERENCES shipping_amount (id)');
        $this->addSql('CREATE INDEX IDX_F0EED3D8DD4427AF ON street (shipping_amount_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE street DROP FOREIGN KEY FK_F0EED3D8DD4427AF');
        $this->addSql('DROP TABLE shipping_amount');
        $this->addSql('DROP INDEX IDX_F0EED3D8DD4427AF ON street');
        $this->addSql('ALTER TABLE street DROP shipping_amount_id');
    }
}
