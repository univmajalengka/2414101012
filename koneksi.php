<?php
$host = '127.0.0.1';
$db   = 'buah_segar'; // <-- Pastikan ini sudah Anda ganti
$user = 'root';
$pass = '';             // <-- Pastikan password ini benar
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     // PASTIKAN NAMA VARIABEL INI ADALAH $pdo
     $pdo = new PDO($dsn, $user, $pass, $options); 
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>