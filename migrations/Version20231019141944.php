<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231019141944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D14F675F31B');
        $this->addSql('DROP INDEX IDX_95C71D14F675F31B ON cars');
        $this->addSql('ALTER TABLE cars DROP author_id');
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name, DROP picture, DROP introduction, DROP description, DROP slug');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14F675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_95C71D14F675F31B ON cars (author_id)');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD picture VARCHAR(255) NOT NULL, ADD introduction VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD slug VARCHAR(255) NOT NULL');
    }
}
