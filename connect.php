<?php
$host = 'db';
$user = 'user';
$pass = 'bintangsatu';
$db = 'mydb';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

$admin = "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20),
    password VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
)";

$siswa = "CREATE TABLE IF NOT EXISTS siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20),
    nama VARCHAR(100),
    kelas VARCHAR(50),
    jurusan VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
)";

$guru = "CREATE TABLE IF NOT EXISTS guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nip VARCHAR(20),
    nama VARCHAR(100),
    mapel VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
)";

$jurusan = "CREATE TABLE IF NOT EXISTS jurusan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10),
    nama_jurusan VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
)";

$mata_pelajaran = "CREATE TABLE IF NOT EXISTS mata_pelajaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_mapel VARCHAR(50),
    kelas VARCHAR(10),
    guru_pengajar VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
)";

$ekstrakulikuler = "CREATE TABLE IF NOT EXISTS ekstrakurikuler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_ekstra VARCHAR(50),
    jadwal VARCHAR(20),
    guru_ekstra VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
)";

$audit_log = "CREATE TABLE IF NOT EXISTS audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(10),
    table_name VARCHAR(50),
    record_id INT,
    old_data JSON,
    new_data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
)";

$conn->query($admin);
$conn->query($guru);
$conn->query($siswa);
$conn->query($jurusan);
$conn->query($mata_pelajaran);
$conn->query($ekstrakulikuler);
$conn->query($audit_log);
?>
