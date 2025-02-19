<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218080259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actor_role (id SERIAL NOT NULL, person_id INT DEFAULT NULL, film_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6721B899217BBB47 ON actor_role (person_id)');
        $this->addSql('CREATE INDEX IDX_6721B899567F5183 ON actor_role (film_id)');
        $this->addSql('CREATE TABLE assessment (id SERIAL NOT NULL, film_id INT DEFAULT NULL, author_id INT DEFAULT NULL, rating INT NOT NULL, comment VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F7523D70567F5183 ON assessment (film_id)');
        $this->addSql('CREATE INDEX IDX_F7523D70F675F31B ON assessment (author_id)');
        $this->addSql('CREATE TABLE film (id SERIAL NOT NULL, directed_by_id INT DEFAULT NULL, producer_id INT DEFAULT NULL, writer_id INT DEFAULT NULL, composer_id INT DEFAULT NULL, publisher_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, genres JSON NOT NULL, release_year INT NOT NULL, description TEXT NOT NULL, rating DOUBLE PRECISION NOT NULL, duration TIME(0) WITHOUT TIME ZONE NOT NULL, age INT NOT NULL, slogan VARCHAR(255) DEFAULT NULL, cover VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8244BE22C52E0AEA ON film (directed_by_id)');
        $this->addSql('CREATE INDEX IDX_8244BE2289B658FE ON film (producer_id)');
        $this->addSql('CREATE INDEX IDX_8244BE221BC7E6B6 ON film (writer_id)');
        $this->addSql('CREATE INDEX IDX_8244BE227A8D2620 ON film (composer_id)');
        $this->addSql('CREATE INDEX IDX_8244BE2240C86FCE ON film (publisher_id)');
        $this->addSql('COMMENT ON COLUMN film.duration IS \'(DC2Type:time_immutable)\'');
        $this->addSql('CREATE TABLE film_person (film_id INT NOT NULL, person_id INT NOT NULL, PRIMARY KEY(film_id, person_id))');
        $this->addSql('CREATE INDEX IDX_5F2EEC7C567F5183 ON film_person (film_id)');
        $this->addSql('CREATE INDEX IDX_5F2EEC7C217BBB47 ON film_person (person_id)');
        $this->addSql('CREATE TABLE person (id SERIAL NOT NULL, publisher_id INT DEFAULT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, gender SMALLINT NOT NULL, birthday TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, age SMALLINT DEFAULT NULL, specialties JSON NOT NULL, bio TEXT DEFAULT NULL, cover VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_34DCD17640C86FCE ON person (publisher_id)');
        $this->addSql('COMMENT ON COLUMN person.birthday IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE refresh_tokens (id SERIAL NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9BACE7E1C74F2195 ON refresh_tokens (refresh_token)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, age INT DEFAULT NULL, about TEXT DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, display_name VARCHAR(255) DEFAULT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, cover VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON "user" (username)');
        $this->addSql('ALTER TABLE actor_role ADD CONSTRAINT FK_6721B899217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE actor_role ADD CONSTRAINT FK_6721B899567F5183 FOREIGN KEY (film_id) REFERENCES film (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assessment ADD CONSTRAINT FK_F7523D70567F5183 FOREIGN KEY (film_id) REFERENCES film (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assessment ADD CONSTRAINT FK_F7523D70F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22C52E0AEA FOREIGN KEY (directed_by_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE2289B658FE FOREIGN KEY (producer_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE221BC7E6B6 FOREIGN KEY (writer_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE227A8D2620 FOREIGN KEY (composer_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE2240C86FCE FOREIGN KEY (publisher_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film_person ADD CONSTRAINT FK_5F2EEC7C567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film_person ADD CONSTRAINT FK_5F2EEC7C217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17640C86FCE FOREIGN KEY (publisher_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE actor_role DROP CONSTRAINT FK_6721B899217BBB47');
        $this->addSql('ALTER TABLE actor_role DROP CONSTRAINT FK_6721B899567F5183');
        $this->addSql('ALTER TABLE assessment DROP CONSTRAINT FK_F7523D70567F5183');
        $this->addSql('ALTER TABLE assessment DROP CONSTRAINT FK_F7523D70F675F31B');
        $this->addSql('ALTER TABLE film DROP CONSTRAINT FK_8244BE22C52E0AEA');
        $this->addSql('ALTER TABLE film DROP CONSTRAINT FK_8244BE2289B658FE');
        $this->addSql('ALTER TABLE film DROP CONSTRAINT FK_8244BE221BC7E6B6');
        $this->addSql('ALTER TABLE film DROP CONSTRAINT FK_8244BE227A8D2620');
        $this->addSql('ALTER TABLE film DROP CONSTRAINT FK_8244BE2240C86FCE');
        $this->addSql('ALTER TABLE film_person DROP CONSTRAINT FK_5F2EEC7C567F5183');
        $this->addSql('ALTER TABLE film_person DROP CONSTRAINT FK_5F2EEC7C217BBB47');
        $this->addSql('ALTER TABLE person DROP CONSTRAINT FK_34DCD17640C86FCE');
        $this->addSql('DROP TABLE actor_role');
        $this->addSql('DROP TABLE assessment');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE film_person');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE "user"');
    }
}
