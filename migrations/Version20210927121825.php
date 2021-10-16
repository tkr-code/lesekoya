<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210927121825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_buy DROP FOREIGN KEY FK_5D9CA10DA76ED395');
        $this->addSql('DROP INDEX IDX_5D9CA10DA76ED395 ON article_buy');
        $this->addSql('ALTER TABLE article_buy CHANGE user_id client_id INT NOT NULL');
        $this->addSql('ALTER TABLE article_buy ADD CONSTRAINT FK_5D9CA10D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_5D9CA10D19EB6921 ON article_buy (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_buy DROP FOREIGN KEY FK_5D9CA10D19EB6921');
        $this->addSql('DROP INDEX IDX_5D9CA10D19EB6921 ON article_buy');
        $this->addSql('ALTER TABLE article_buy CHANGE client_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE article_buy ADD CONSTRAINT FK_5D9CA10DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5D9CA10DA76ED395 ON article_buy (user_id)');
    }
}
