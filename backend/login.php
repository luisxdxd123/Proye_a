<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contacto = trim($_POST['contacto']);
    $contrasena = $_POST['contrasena'];
    
    // Buscar usuario por contacto (email o teléfono)
    $sql = "SELECT * FROM usuarios WHERE contacto = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$contacto]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        $autenticado = false;

        // Para admin y departamentos, comparar contraseña en texto plano
        if ($usuario['rol_user'] === 'admin' || $usuario['rol_user'] === 'departamentos') {
            $autenticado = ($contrasena === $usuario['contrasena']);
        } 
        // Para ciudadanos, usar verificación de hash
        else {
            $autenticado = password_verify($contrasena, $usuario['contrasena']);
        }

        if ($autenticado) {
            // Iniciar sesión
            session_start();
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['rol'] = $usuario['rol_user'];
            $_SESSION['nombre'] = $usuario['nombre'];

            // Redirigir según el rol
            switch($usuario['rol_user']) {
                case 'ciudadano':
                    header('Location: ../frontend/ciudadano/dash_ciud.php');
                    break;
                case 'admin':
                    header('Location: ../frontend/admin/dash_ad.php');
                    break;
                case 'departamentos':
                    header('Location: ../frontend/departamentos/dash_dep.php');
                    break;
                case 'presidencia':
                    header('Location: ../frontend/presidencia/dash_pre.php');
                    break;
                default:
                    header('Location: ../frontend/log_reg.php?error=rol');
            }
            exit();
        } else {
            header('Location: ../frontend/log_reg.php?error=credenciales');
            exit();
        }
    } else {
        header('Location: ../frontend/log_reg.php?error=credenciales');
        exit();
    }
} else {
    header('Location: ../frontend/log_reg.php');
    exit();
} 