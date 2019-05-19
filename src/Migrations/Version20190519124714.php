<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190519124714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE chauffeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, age INT NOT NULL, cin VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5CA777B835C246D5 (password), UNIQUE INDEX UNIQ_5CA777B8E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE passager (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_BFF42EE935C246D5 (password), UNIQUE INDEX UNIQ_BFF42EE9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_traj_id INT DEFAULT NULL, id_pass_id INT DEFAULT NULL, date_res DATETIME NOT NULL, INDEX IDX_42C8495574F57B44 (id_traj_id), INDEX IDX_42C8495532C9F395 (id_pass_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, voiture_id INT NOT NULL, ville_dep VARCHAR(255) NOT NULL, ville_arrivee VARCHAR(255) NOT NULL, date_dep DATE NOT NULL, heure_dep TIME NOT NULL, place_libres INT NOT NULL, INDEX IDX_2B5BA98C181A8BA (voiture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, id_ch_id INT NOT NULL, modele VARCHAR(255) NOT NULL, clim TINYINT(1) NOT NULL, fumeur TINYINT(1) NOT NULL, bagage TINYINT(1) NOT NULL, photo VARCHAR(255) NOT NULL, INDEX IDX_E9E2810F91A7787E (id_ch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495574F57B44 FOREIGN KEY (id_traj_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495532C9F395 FOREIGN KEY (id_pass_id) REFERENCES passager (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F91A7787E FOREIGN KEY (id_ch_id) REFERENCES chauffeur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F91A7787E');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495532C9F395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495574F57B44');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C181A8BA');
        $this->addSql('DROP TABLE chauffeur');
        $this->addSql('DROP TABLE passager');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE voiture');
    }
}
