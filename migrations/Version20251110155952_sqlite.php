<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251110185952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE luogo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome_card TEXT NOT NULL, descrizione_card TEXT DEFAULT NULL, via_card TEXT DEFAULT NULL, img_card TEXT DEFAULT NULL, slug TEXT NOT NULL, nome_cover TEXT NOT NULL, img_cover TEXT DEFAULT NULL, descrizione_cover TEXT DEFAULT NULL, meta_title TEXT DEFAULT NULL, meta_description TEXT DEFAULT NULL, menu TEXT DEFAULT NULL, link_maps TEXT DEFAULT NULL, img_mappa TEXT DEFAULT NULL, indirizzo_full TEXT DEFAULT NULL, orari_full TEXT DEFAULT NULL, url_instagram TEXT DEFAULT NULL, url_facebook TEXT DEFAULT NULL, url_recensione TEXT DEFAULT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email TEXT NOT NULL, nome TEXT NOT NULL, cognome TEXT NOT NULL, img_profilo TEXT DEFAULT NULL, roles TEXT NOT NULL, password TEXT NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name TEXT NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE TABLE event_requests (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name TEXT NOT NULL, email TEXT NOT NULL, phone TEXT DEFAULT NULL, localita TEXT DEFAULT NULL, event_date TEXT DEFAULT NULL, drink_service TEXT DEFAULT "Non richiesto", event_type TEXT NOT NULL, meal TEXT DEFAULT NULL, people INTEGER DEFAULT NULL, start_time TEXT DEFAULT NULL, end_time TEXT DEFAULT NULL, services TEXT DEFAULT NULL, message TEXT DEFAULT NULL, created_at DATETIME NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE luogo');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE event_requests');
    }
}
