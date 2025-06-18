<?php
require_once '../auth.php';
require_once '../notificaciones/crear_notificacion.php';

checkRole('ciudadano');

header('Content-Type: application/json');

try {
    $usuario_id = $_SESSION['user_id'];
    
    // Obtener todas las notificaciones del usuario
    $notificaciones = obtenerNotificaciones($usuario_id);
    
    // Contar notificaciones no leídas
    $no_leidas = contarNotificacionesNoLeidas($usuario_id);
    
    echo json_encode([
        'success' => true,
        'notificaciones' => $notificaciones,
        'total_no_leidas' => $no_leidas
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 