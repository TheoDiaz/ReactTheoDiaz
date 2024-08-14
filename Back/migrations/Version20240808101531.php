<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240808101531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_favorite_recipes (user_id INT NOT NULL, recettes_id INT NOT NULL, INDEX IDX_83280E06A76ED395 (user_id), INDEX IDX_83280E063E2ED6D6 (recettes_id), PRIMARY KEY(user_id, recettes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_favorite_recipes ADD CONSTRAINT FK_83280E06A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_favorite_recipes ADD CONSTRAINT FK_83280E063E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE ingredients CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE recettes CHANGE added_by added_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE recettes ADD CONSTRAINT FK_EB48E72C55B127A4 FOREIGN KEY (added_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_EB48E72C55B127A4 ON recettes (added_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recettes DROP FOREIGN KEY FK_EB48E72C55B127A4');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, role VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, fav_recipes INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_favorite_recipes DROP FOREIGN KEY FK_83280E06A76ED395');
        $this->addSql('ALTER TABLE user_favorite_recipes DROP FOREIGN KEY FK_83280E063E2ED6D6');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_favorite_recipes');
        $this->addSql('ALTER TABLE ingredients CHANGE type type VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('DROP INDEX IDX_EB48E72C55B127A4 ON recettes');
        $this->addSql('ALTER TABLE recettes CHANGE added_by_id added_by INT NOT NULL');
    }
}
