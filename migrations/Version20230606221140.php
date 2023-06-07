<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606221140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(10) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_representative (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(30) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(10) NOT NULL, INDEX IDX_BCF16AD979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request (id INT AUTO_INCREMENT NOT NULL, training_offer_id INT DEFAULT NULL, student_offer_id INT DEFAULT NULL, student_id INT DEFAULT NULL, company_id INT DEFAULT NULL, INDEX IDX_3B978F9FB4A36779 (training_offer_id), INDEX IDX_3B978F9FE04D3875 (student_offer_id), INDEX IDX_3B978F9FCB944F1A (student_id), INDEX IDX_3B978F9F979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, phone VARCHAR(10) NOT NULL, email VARCHAR(255) NOT NULL, nia VARCHAR(8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_course (student_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_98A8B739CB944F1A (student_id), INDEX IDX_98A8B739591CC992 (course_id), PRIMARY KEY(student_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_offer (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_A1E1FEA3CB944F1A (student_id), INDEX IDX_A1E1FEA3591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE study_center (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, phone VARCHAR(10) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE study_center_course (study_center_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_CB03CCFFCDF541E6 (study_center_id), INDEX IDX_CB03CCFF591CC992 (course_id), PRIMARY KEY(study_center_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, company_representative_id INT NOT NULL, student_id INT NOT NULL, tutor_id INT NOT NULL, company_id INT NOT NULL, start_date DATETIME NOT NULL, INDEX IDX_D5128A8FA0A261FE (company_representative_id), INDEX IDX_D5128A8FCB944F1A (student_id), INDEX IDX_D5128A8F208F64F1 (tutor_id), INDEX IDX_D5128A8F979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_offer (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_C60C0D53979B1AD6 (company_id), INDEX IDX_C60C0D53591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tutor (id INT AUTO_INCREMENT NOT NULL, study_center_id INT NOT NULL, name VARCHAR(30) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(10) NOT NULL, INDEX IDX_99074648CDF541E6 (study_center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tutor_student (tutor_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_DFDBA28C208F64F1 (tutor_id), INDEX IDX_DFDBA28CCB944F1A (student_id), PRIMARY KEY(tutor_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tutor_course (tutor_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_3320286B208F64F1 (tutor_id), INDEX IDX_3320286B591CC992 (course_id), PRIMARY KEY(tutor_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_representative ADD CONSTRAINT FK_BCF16AD979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FB4A36779 FOREIGN KEY (training_offer_id) REFERENCES training_offer (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FE04D3875 FOREIGN KEY (student_offer_id) REFERENCES student_offer (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9F979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE student_course ADD CONSTRAINT FK_98A8B739CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_course ADD CONSTRAINT FK_98A8B739591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_offer ADD CONSTRAINT FK_A1E1FEA3CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student_offer ADD CONSTRAINT FK_A1E1FEA3591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE study_center_course ADD CONSTRAINT FK_CB03CCFFCDF541E6 FOREIGN KEY (study_center_id) REFERENCES study_center (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE study_center_course ADD CONSTRAINT FK_CB03CCFF591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FA0A261FE FOREIGN KEY (company_representative_id) REFERENCES company_representative (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F208F64F1 FOREIGN KEY (tutor_id) REFERENCES tutor (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE training_offer ADD CONSTRAINT FK_C60C0D53979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE training_offer ADD CONSTRAINT FK_C60C0D53591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE tutor ADD CONSTRAINT FK_99074648CDF541E6 FOREIGN KEY (study_center_id) REFERENCES study_center (id)');
        $this->addSql('ALTER TABLE tutor_student ADD CONSTRAINT FK_DFDBA28C208F64F1 FOREIGN KEY (tutor_id) REFERENCES tutor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tutor_student ADD CONSTRAINT FK_DFDBA28CCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tutor_course ADD CONSTRAINT FK_3320286B208F64F1 FOREIGN KEY (tutor_id) REFERENCES tutor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tutor_course ADD CONSTRAINT FK_3320286B591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_representative DROP FOREIGN KEY FK_BCF16AD979B1AD6');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FB4A36779');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FE04D3875');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FCB944F1A');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9F979B1AD6');
        $this->addSql('ALTER TABLE student_course DROP FOREIGN KEY FK_98A8B739CB944F1A');
        $this->addSql('ALTER TABLE student_course DROP FOREIGN KEY FK_98A8B739591CC992');
        $this->addSql('ALTER TABLE student_offer DROP FOREIGN KEY FK_A1E1FEA3CB944F1A');
        $this->addSql('ALTER TABLE student_offer DROP FOREIGN KEY FK_A1E1FEA3591CC992');
        $this->addSql('ALTER TABLE study_center_course DROP FOREIGN KEY FK_CB03CCFFCDF541E6');
        $this->addSql('ALTER TABLE study_center_course DROP FOREIGN KEY FK_CB03CCFF591CC992');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FA0A261FE');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FCB944F1A');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F208F64F1');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F979B1AD6');
        $this->addSql('ALTER TABLE training_offer DROP FOREIGN KEY FK_C60C0D53979B1AD6');
        $this->addSql('ALTER TABLE training_offer DROP FOREIGN KEY FK_C60C0D53591CC992');
        $this->addSql('ALTER TABLE tutor DROP FOREIGN KEY FK_99074648CDF541E6');
        $this->addSql('ALTER TABLE tutor_student DROP FOREIGN KEY FK_DFDBA28C208F64F1');
        $this->addSql('ALTER TABLE tutor_student DROP FOREIGN KEY FK_DFDBA28CCB944F1A');
        $this->addSql('ALTER TABLE tutor_course DROP FOREIGN KEY FK_3320286B208F64F1');
        $this->addSql('ALTER TABLE tutor_course DROP FOREIGN KEY FK_3320286B591CC992');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_representative');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE request');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_course');
        $this->addSql('DROP TABLE student_offer');
        $this->addSql('DROP TABLE study_center');
        $this->addSql('DROP TABLE study_center_course');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE training_offer');
        $this->addSql('DROP TABLE tutor');
        $this->addSql('DROP TABLE tutor_student');
        $this->addSql('DROP TABLE tutor_course');
    }
}
