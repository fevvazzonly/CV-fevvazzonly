-- ============================================================
--  Database: db_siswa
--  Jalankan file ini di phpMyAdmin atau MySQL CLI
-- ============================================================

CREATE DATABASE IF NOT EXISTS db_siswa
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE db_siswa;

CREATE TABLE IF NOT EXISTS siswa (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nis             VARCHAR(20)  NOT NULL UNIQUE,
    nama            VARCHAR(100) NOT NULL,
    jenis_kelamin   ENUM('Laki-laki','Perempuan') NOT NULL,
    kelas           VARCHAR(20)  NOT NULL,
    alamat          TEXT,
    no_telepon      VARCHAR(20),
    email           VARCHAR(100),
    tanggal_masuk   DATE,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data dummy
INSERT INTO siswa (nis, nama, jenis_kelamin, kelas, alamat, no_telepon, email, tanggal_masuk) VALUES
('2024001', 'Ahmad Fauzi',       'Laki-laki', 'XII IPA 1', 'Jl. Merdeka No. 10, Jakarta',    '081234567890', 'ahmad@email.com',   '2022-07-15'),
('2024002', 'Siti Rahayu',       'Perempuan', 'XII IPA 2', 'Jl. Sudirman No. 5, Bandung',    '082345678901', 'siti@email.com',    '2022-07-15'),
('2024003', 'Budi Santoso',      'Laki-laki', 'XI IPS 1', 'Jl. Diponegoro No. 22, Surabaya', '083456789012', 'budi@email.com',    '2023-07-17'),
('2024004', 'Dewi Lestari',      'Perempuan', 'XI IPA 1', 'Jl. Pahlawan No. 8, Yogyakarta',  '084567890123', 'dewi@email.com',    '2023-07-17'),
('2024005', 'Rizky Pratama',     'Laki-laki', 'X IPS 2',  'Jl. Gatot Subroto No. 3, Medan',  '085678901234', 'rizky@email.com',   '2024-07-16');
