<?php
// KOneksi DB dan PHP
$host = "db";
$user = "user";
$pass = "bintangsatu";
$db   = "mydb";

$conn = new mysqli($host, $user, $pass, $db);

// Cek Koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tabel Admin
$admin = "CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20),
    password VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL
)";

// Tabel Siswa
$siswa = "CREATE TABLE siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20),
    nama VARCHAR(100),
    kelas VARCHAR(50),
    jurusan VARCHAR(100)
    created_at TIMESTAMP CURRENT_TIMESTAMP,
    updated_at TIMESTAMP CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
)";

// Tabel Guru
$guru = "CREATE TABLE guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nip VARCHAR(20),
    nama VARCHAR(100),
    mapel VARCHAR(100)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL
)";

// Tabel Jurusan
$jurusan = "CREATE TABLE jurusan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10),
    nama_jurusan VARCHAR(100)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL
)";

// Tabel Mata Pelajaran
$mata_pelajaran = "CREATE TABLE mata_pelajaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
	nama_mapel VARCHAR (50),
	kelas VARCHAR (10),
	guru_pengajar VARCHAR (100) 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL
)";

// Tabel Ekstrakurikuler
$ekstrakulikuler = "CREATE TABLE ekstrakurikuler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_ekstra VARCHAR(50),
    jadwal VARCHAR(20),
    guru_ekstra VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL
)";

// Tabel Audit Log (untuk mengecek data yang dibuat atau diubah)
$audit_log = "CREATE TABLE audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(10),
    table_name VARCHAR(50),
    record_id INT,
    old_data JSON,
    new_data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL
)";

// Buat table dengan struktur data di atas
$conn->query($admin);
$conn->query($guru);
$conn->query($siswa);
$conn->query($jurusan);
$conn->query($mata_pelajaran);
$conn->query($ekstrakulikuler);
$conn->query($audit_log);
?>