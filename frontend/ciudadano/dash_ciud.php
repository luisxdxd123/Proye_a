<?php
require_once '../../backend/auth.php';
checkRole('ciudadano');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Ciudadano</title>
    <style>
        .welcome-message {
            text-align: center;
            margin-top: 2em;
            color: #6B1024;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #6B1024;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #8B223A;
        }
    </style>
</head>
<body>
    <a href="../../backend/logout.php" class="logout-btn">Cerrar Sesión</a>
    <div class="welcome-message">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h1>
        <p>Panel de Control Ciudadano</p>
    </div>
</body>
</html>