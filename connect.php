<?php
$server = 'devalvinsql-masterofunity.a.aivencloud.com';
$port = '10332';
$username = 'avnadmin'; // Ganti dengan username Anda
$password = 'AVNS_RmP6T6Qxmo-KXYTZvdh'; // Ganti dengan password Anda
$database = 'chatdeva'; // Ganti dengan nama database Anda

// Membuat koneksi ke database dengan SSL
$mysqli = new mysqli($server, $username, $password, $database, $port, 'ca.pem'); // 'ca.pem' adalah path ke sertifikat CA Anda

// Memeriksa koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Jika koneksi berhasil, Anda dapat menggunakan $mysqli untuk melakukan operasi database lainnya.
?>
