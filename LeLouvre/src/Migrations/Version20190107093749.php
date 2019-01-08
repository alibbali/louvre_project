<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190107093749 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation ADD billets_id INT NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD pays VARCHAR(255) NOT NULL, ADD prix INT NOT NULL, ADD reduction TINYINT(1) NOT NULL, DROP email, DROP type_billet, DROP code_billet, CHANGE date_visite naissance DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B9EBD317 FOREIGN KEY (billets_id) REFERENCES billets (id)');
        $this->addSql('CREATE INDEX IDX_42C84955B9EBD317 ON reservation (billets_id)');
        $this->addSql('ALTER TABLE billets DROP FOREIGN KEY FK_4FCF9B6885542AE1');
        $this->addSql('DROP INDEX IDX_4FCF9B6885542AE1 ON billets');
        $this->addSql('ALTER TABLE billets ADD date_visite DATETIME NOT NULL, ADD email LONGTEXT NOT NULL, ADD type TINYINT(1) NOT NULL, DROP id_reservation_id, DROP nom, DROP prenom, DROP reduced, DROP code_reservation, CHANGE birthday date DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billets ADD id_reservation_id INT NOT NULL, ADD nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD birthday DATETIME NOT NULL, ADD reduced TINYINT(1) DEFAULT NULL, ADD code_reservation VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP date, DROP date_visite, DROP email, DROP type');
        $this->addSql('ALTER TABLE billets ADD CONSTRAINT FK_4FCF9B6885542AE1 FOREIGN KEY (id_reservation_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_4FCF9B6885542AE1 ON billets (id_reservation_id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B9EBD317');
        $this->addSql('DROP INDEX IDX_42C84955B9EBD317 ON reservation');
        $this->addSql('ALTER TABLE reservation ADD email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD type_billet VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD code_billet VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP billets_id, DROP nom, DROP prenom, DROP pays, DROP prix, DROP reduction, CHANGE naissance date_visite DATETIME NOT NULL');
    }
}
