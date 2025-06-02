<?php
$host = 'localhost';
$db   = 'proye_a'; // Cambia esto por el nombre de tu base de datos
$user = 'root';      // Cambia si tu usuario es diferente
$pass = '';          // Cambia si tienes contraseña
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    // Opcional: establecer el modo de error a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}