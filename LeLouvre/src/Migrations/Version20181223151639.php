<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181223151639 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, date_visite DATETIME NOT NULL, type_billet VARCHAR(255) NOT NULL, quantite INT NOT NULL, code_billet VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billets (id INT AUTO_INCREMENT NOT NULL, id_reservation_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, birthday DATETIME NOT NULL, reduced TINYINT(1) DEFAULT NULL, code_reservation VARCHAR(255) NOT NULL, INDEX IDX_4FCF9B6885542AE1 (id_reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billets ADD CONSTRAINT FK_4FCF9B6885542AE1 FOREIGN KEY (id_reservation_id) REFERENCES reservation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billets DROP FOREIGN KEY FK_4FCF9B6885542AE1');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE billets');
    }
}
