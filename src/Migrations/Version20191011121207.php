<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191011121207 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD taxon_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADDE13F470 FOREIGN KEY (taxon_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADDE13F470 ON product (taxon_id)');
        $this->addSql('ALTER TABLE taxon ADD author_id INT NOT NULL, DROP author, DROP products');
        $this->addSql('ALTER TABLE taxon ADD CONSTRAINT FK_5B6723ABF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5B6723ABF675F31B ON taxon (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADDE13F470');
        $this->addSql('DROP INDEX IDX_D34A04ADDE13F470 ON product');
        $this->addSql('ALTER TABLE product DROP taxon_id');
        $this->addSql('ALTER TABLE taxon DROP FOREIGN KEY FK_5B6723ABF675F31B');
        $this->addSql('DROP INDEX IDX_5B6723ABF675F31B ON taxon');
        $this->addSql('ALTER TABLE taxon ADD author VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD products VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP author_id');
    }
}
