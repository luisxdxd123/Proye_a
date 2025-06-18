<?php
require_once '../auth.php';
require_once '../notificaciones/crear_notificacion.php';

checkRole('ciudadano');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

$notificacion_id = $_POST['notificacion_id'] ?? null;

if (!$notificacion_id) {
    echo json_encode(['success' => false, 'error' => 'ID de notificación requerido']);
    exit;
}

try {
    $usuario_id = $_SESSION['user_id'];
    
    $result = marcarNotificacionLeida($notificacion_id, $usuario_id);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Notificación marcada como leída']);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se pudo marcar la notificación']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 