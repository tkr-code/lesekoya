<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210926152544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adress (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, street VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, country_code VARCHAR(255) NOT NULL, province_code VARCHAR(255) DEFAULT NULL, province_name VARCHAR(255) DEFAULT NULL, INDEX IDX_5CECC7BEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, quantity INT NOT NULL, buying_price DOUBLE PRECISION NOT NULL, etat VARCHAR(255) DEFAULT NULL, INDEX IDX_23A0E6612469DE2 (category_id), FULLTEXT INDEX IDX_23A0E662B36786B6DE44026 (title, description), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_user (article_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3DD151487294869C (article_id), INDEX IDX_3DD15148A76ED395 (user_id), PRIMARY KEY(article_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_option (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_304197307294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2D5B0234F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_C7440455A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, user_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526C7294869C (article_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_space (id INT AUTO_INCREMENT NOT NULL, street_id INT NOT NULL, client_id INT DEFAULT NULL, INDEX IDX_397927A887CF8EB (street_id), INDEX IDX_397927A819EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C53D045FF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, payment_id INT DEFAULT NULL, shipping_id INT DEFAULT NULL, delivery_space_id INT DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, note LONGTEXT DEFAULT NULL, state VARCHAR(255) NOT NULL, checkout_completed_at DATETIME DEFAULT NULL, total INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, payment_due DATETIME NOT NULL, items_total INT NOT NULL, adjustments_total INT NOT NULL, INDEX IDX_F5299398A76ED395 (user_id), UNIQUE INDEX UNIQ_F52993984C3A3BB (payment_id), UNIQUE INDEX UNIQ_F52993984887F3F8 (shipping_id), UNIQUE INDEX UNIQ_F52993984236B22C (delivery_space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, article_id INT DEFAULT NULL, quantity INT DEFAULT 1 NOT NULL, unit_price INT NOT NULL, units_total INT NOT NULL, adjustments_total INT DEFAULT 1, total INT NOT NULL, produit_name VARCHAR(255) NOT NULL, variant_name VARCHAR(255) DEFAULT NULL, INDEX IDX_52EA1F0982EA2E54 (commande_id), INDEX IDX_52EA1F097294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, payment_method_id INT NOT NULL, amount INT DEFAULT 0 NOT NULL, state VARCHAR(255) NOT NULL, details LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_6D28840D5AA1164F (payment_method_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_method (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, instructions LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping (id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, state VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping_amount (id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE street (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, shipping_amount_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F0EED3D88BAC62AF (city_id), INDEX IDX_F0EED3D8DD4427AF (shipping_amount_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, personne_id INT NOT NULL, delivery_space_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, username VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649A21BD112 (personne_id), UNIQUE INDEX UNIQ_8D93D6494236B22C (delivery_space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adress ADD CONSTRAINT FK_5CECC7BEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE article_user ADD CONSTRAINT FK_3DD151487294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_user ADD CONSTRAINT FK_3DD15148A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_option ADD CONSTRAINT FK_304197307294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE delivery_space ADD CONSTRAINT FK_397927A887CF8EB FOREIGN KEY (street_id) REFERENCES street (id)');
        $this->addSql('ALTER TABLE delivery_space ADD CONSTRAINT FK_397927A819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF347EFB FOREIGN KEY (produit_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984887F3F8 FOREIGN KEY (shipping_id) REFERENCES shipping (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984236B22C FOREIGN KEY (delivery_space_id) REFERENCES delivery_space (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F0982EA2E54 FOREIGN KEY (commande_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F097294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D5AA1164F FOREIGN KEY (payment_method_id) REFERENCES payment_method (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE street ADD CONSTRAINT FK_F0EED3D88BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE street ADD CONSTRAINT FK_F0EED3D8DD4427AF FOREIGN KEY (shipping_amount_id) REFERENCES shipping_amount (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494236B22C FOREIGN KEY (delivery_space_id) REFERENCES delivery_space (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_user DROP FOREIGN KEY FK_3DD151487294869C');
        $this->addSql('ALTER TABLE article_option DROP FOREIGN KEY FK_304197307294869C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7294869C');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FF347EFB');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F097294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('ALTER TABLE street DROP FOREIGN KEY FK_F0EED3D88BAC62AF');
        $this->addSql('ALTER TABLE delivery_space DROP FOREIGN KEY FK_397927A819EB6921');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234F92F3E70');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984236B22C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494236B22C');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F0982EA2E54');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984C3A3BB');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D5AA1164F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A21BD112');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984887F3F8');
        $this->addSql('ALTER TABLE street DROP FOREIGN KEY FK_F0EED3D8DD4427AF');
        $this->addSql('ALTER TABLE delivery_space DROP FOREIGN KEY FK_397927A887CF8EB');
        $this->addSql('ALTER TABLE adress DROP FOREIGN KEY FK_5CECC7BEA76ED395');
        $this->addSql('ALTER TABLE article_user DROP FOREIGN KEY FK_3DD15148A76ED395');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE adress');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_user');
        $this->addSql('DROP TABLE article_option');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE delivery_space');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE payment_method');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE shipping');
        $this->addSql('DROP TABLE shipping_amount');
        $this->addSql('DROP TABLE street');
        $this->addSql('DROP TABLE user');
    }
}
