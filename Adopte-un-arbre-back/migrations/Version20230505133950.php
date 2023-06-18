<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505133950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture ADD project_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F89166D1F9C ON picture (project_id)');
        $this->addSql('ALTER TABLE project ADD organism_id INT NOT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE64180A36 FOREIGN KEY (organism_id) REFERENCES organism (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE64180A36 ON project (organism_id)');
        $this->addSql('ALTER TABLE user ADD organism_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64964180A36 FOREIGN KEY (organism_id) REFERENCES organism (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64964180A36 ON user (organism_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE64180A36');
        $this->addSql('DROP INDEX IDX_2FB3D0EE64180A36 ON project');
        $this->addSql('ALTER TABLE project DROP organism_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64964180A36');
        $this->addSql('DROP INDEX IDX_8D93D64964180A36 ON user');
        $this->addSql('ALTER TABLE user DROP organism_id');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89166D1F9C');
        $this->addSql('DROP INDEX IDX_16DB4F89166D1F9C ON picture');
        $this->addSql('ALTER TABLE picture DROP project_id');
    }
}
