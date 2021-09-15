<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210913191809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD delivery_space_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984236B22C FOREIGN KEY (delivery_space_id) REFERENCES delivery_space (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993984236B22C ON `order` (delivery_space_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984236B22C');
        $this->addSql('DROP INDEX UNIQ_F52993984236B22C ON `order`');
        $this->addSql('ALTER TABLE `order` DROP delivery_space_id');
    }
}
