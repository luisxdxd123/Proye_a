<?php
session_start();

function checkAuth() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['rol_user'])) {
        header('Location: ../../frontend/log_reg.php');
        exit();
    }
}

function checkRole($required_role) {
    checkAuth();
    if ($_SESSION['rol_user'] !== $required_role) {
        // Redirigir según el rol actual
        switch($_SESSION['rol_user']) {
            case 'ciudadano':
                header('Location: ../../frontend/ciudadano/dash_ciud.php');
                break;
            case 'admin':
                header('Location: ../../frontend/admin/dash_ad.php');
                break;
            case 'departamentos':
                header('Location: ../../frontend/departamentos/dash_dep.php');
                break;
            case 'presidencia':
                header('Location: ../../frontend/presidencia/dash_pre.php');
                break;
            default:
                header('Location: ../../frontend/log_reg.php');
        }
        exit();
    }
} 