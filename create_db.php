<?php

$host = '127.0.0.1';
$user = 'root';
$pass = '';

try {
    $conn = new PDO('mysql:host=' . $host, $user, $pass);
    $conn->exec('CREATE DATABASE IF NOT EXISTS persil CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    echo 'Database persil berhasil dibuat!' . PHP_EOL;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
