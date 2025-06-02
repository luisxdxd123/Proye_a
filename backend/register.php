<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y limpiar datos del formulario
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $dia = (int)$_POST['dia'];
    $mes = (int)$_POST['mes'];
    $anio = (int)$_POST['anio'];
    $genero = $_POST['genero'];
    $genero_personalizado = ($genero === 'otro' && isset($_POST['genero_personalizado'])) ? trim($_POST['genero_personalizado']) : null;
    $contacto = trim($_POST['contacto']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $fecha_nacimiento = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
    $rol_user = 'ciudadano'; // Por defecto

    // Insertar en la base de datos
    $sql = "INSERT INTO usuarios (nombre, apellido, fecha_nacimiento, genero, genero_personalizado, contacto, contrasena, rol_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([$nombre, $apellido, $fecha_nacimiento, $genero, $genero_personalizado, $contacto, $contrasena, $rol_user]);
        header('Location: ../frontend/log_reg.php?success=1');
        exit();
    } catch (PDOException $e) {
        // Puedes personalizar el manejo de errores
        header('Location: ../frontend/log_reg.php?error=1');
        exit();
    }
} else {
    header('Location: ../frontend/log_reg.php');
    exit();
}
