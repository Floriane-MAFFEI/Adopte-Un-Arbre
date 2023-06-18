<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505132114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture ADD tree_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8978B64A2 FOREIGN KEY (tree_id) REFERENCES tree (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F8978B64A2 ON picture (tree_id)');
        $this->addSql('ALTER TABLE tree ADD specie_id INT NOT NULL, ADD user_id INT DEFAULT NULL, ADD project_id INT NOT NULL');
        $this->addSql('ALTER TABLE tree ADD CONSTRAINT FK_B73E5EDCD5436AB7 FOREIGN KEY (specie_id) REFERENCES specie (id)');
        $this->addSql('ALTER TABLE tree ADD CONSTRAINT FK_B73E5EDCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tree ADD CONSTRAINT FK_B73E5EDC166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_B73E5EDCD5436AB7 ON tree (specie_id)');
        $this->addSql('CREATE INDEX IDX_B73E5EDCA76ED395 ON tree (user_id)');
        $this->addSql('CREATE INDEX IDX_B73E5EDC166D1F9C ON tree (project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tree DROP FOREIGN KEY FK_B73E5EDCD5436AB7');
        $this->addSql('ALTER TABLE tree DROP FOREIGN KEY FK_B73E5EDCA76ED395');
        $this->addSql('ALTER TABLE tree DROP FOREIGN KEY FK_B73E5EDC166D1F9C');
        $this->addSql('DROP INDEX IDX_B73E5EDCD5436AB7 ON tree');
        $this->addSql('DROP INDEX IDX_B73E5EDCA76ED395 ON tree');
        $this->addSql('DROP INDEX IDX_B73E5EDC166D1F9C ON tree');
        $this->addSql('ALTER TABLE tree DROP specie_id, DROP user_id, DROP project_id');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8978B64A2');
        $this->addSql('DROP INDEX IDX_16DB4F8978B64A2 ON picture');
        $this->addSql('ALTER TABLE picture DROP tree_id');
    }
}
