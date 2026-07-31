-- database/migrations/2026_07_31_create_schema.sql
-- Initial schema for PSEMS (matches app/Models)
-- Run this against your MySQL/MariaDB database (adjust types/engine as needed)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS psems_school DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE psems_school;

-- Users
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(191) NOT NULL,
  email VARCHAR(191) NOT NULL UNIQUE,
  password VARCHAR(255) NULL,
  role VARCHAR(50) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Academic years
CREATE TABLE IF NOT EXISTS academic_years (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  start_date DATE NULL,
  end_date DATE NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Terms
CREATE TABLE IF NOT EXISTS terms (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  academic_year_id INT UNSIGNED NULL,
  name VARCHAR(100) NOT NULL,
  start_date DATE NULL,
  end_date DATE NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_terms_academic_year FOREIGN KEY (academic_year_id) REFERENCES academic_years(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Streams (classes/streams)
CREATE TABLE IF NOT EXISTS streams (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(191) NOT NULL,
  description TEXT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Teachers
CREATE TABLE IF NOT EXISTS teachers (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  middle_name VARCHAR(100) NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(191) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pupils
CREATE TABLE IF NOT EXISTS pupils (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  admission_no VARCHAR(100) NULL,
  first_name VARCHAR(100) NOT NULL,
  middle_name VARCHAR(100) NULL,
  last_name VARCHAR(100) NOT NULL,
  full_name VARCHAR(255) NULL,
  date_of_birth DATE NULL,
  gender VARCHAR(10) NULL,
  guardian_name VARCHAR(191) NULL,
  guardian_phone VARCHAR(50) NULL,
  stream_id INT UNSIGNED NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_pupils_stream FOREIGN KEY (stream_id) REFERENCES streams(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Subjects
CREATE TABLE IF NOT EXISTS subjects (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(191) NOT NULL,
  code VARCHAR(50) NULL,
  teacher_id INT UNSIGNED NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_subjects_teacher FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Examinations
CREATE TABLE IF NOT EXISTS examinations (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  date DATE NULL,
  academic_year_id INT UNSIGNED NULL,
  instructions TEXT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_examinations_academic_year FOREIGN KEY (academic_year_id) REFERENCES academic_years(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Marks
CREATE TABLE IF NOT EXISTS marks (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  score DECIMAL(8,2) NULL,
  pupil_id INT UNSIGNED NULL,
  subject_id INT UNSIGNED NULL,
  term_id INT UNSIGNED NULL,
  examination_id INT UNSIGNED NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_marks_pupil FOREIGN KEY (pupil_id) REFERENCES pupils(id) ON DELETE SET NULL,
  CONSTRAINT fk_marks_subject FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL,
  CONSTRAINT fk_marks_term FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE SET NULL,
  CONSTRAINT fk_marks_examination FOREIGN KEY (examination_id) REFERENCES examinations(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Grades
CREATE TABLE IF NOT EXISTS grades (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  value DECIMAL(8,2) NULL,
  pupil_id INT UNSIGNED NULL,
  examination_id INT UNSIGNED NULL,
  remarks TEXT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_grades_pupil FOREIGN KEY (pupil_id) REFERENCES pupils(id) ON DELETE SET NULL,
  CONSTRAINT fk_grades_examination FOREIGN KEY (examination_id) REFERENCES examinations(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Settings (key/value)
CREATE TABLE IF NOT EXISTS settings (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(191) NOT NULL UNIQUE,
  `value` TEXT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Example indexes
CREATE INDEX idx_pupils_stream ON pupils(stream_id);
CREATE INDEX idx_subjects_teacher ON subjects(teacher_id);
CREATE INDEX idx_marks_pupil ON marks(pupil_id);
CREATE INDEX idx_marks_subject ON marks(subject_id);

-- End of migration
