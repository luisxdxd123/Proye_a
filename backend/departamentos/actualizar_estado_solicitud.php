<?php
require_once '../config/db_config.php';
require_once '../auth.php';
require_once '../notificaciones/crear_notificacion.php';

checkRole('departamentos');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

$envio_id = $_POST['envio_id'] ?? null;
$nuevo_estado = $_POST['nuevo_estado'] ?? null;
$respuesta = $_POST['respuesta'] ?? '';

if (!$envio_id || !$nuevo_estado) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit;
}

// Validar estados permitidos
$estados_permitidos = ['en_revision', 'autorizada', 'rechazada'];
if (!in_array($nuevo_estado, $estados_permitidos)) {
    echo json_encode(['success' => false, 'error' => 'Estado no válido']);
    exit;
}

try {
    $conn->beginTransaction();
    
    // Verificar que la solicitud pertenece al departamento del usuario
    $stmt = $conn->prepare("SELECT solicitud_id FROM solicitudes_enviadas WHERE id = ? AND departamento_id = ?");
    $stmt->execute([$envio_id, $_SESSION['user_id']]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$resultado) {
        echo json_encode(['success' => false, 'error' => 'Solicitud no encontrada o no autorizada']);
        exit;
    }
    
    $solicitud_id = $resultado['solicitud_id'];
    
    // Actualizar estado en solicitudes_enviadas
    $query = "UPDATE solicitudes_enviadas 
              SET estado = ?, 
                  respuesta_departamento = ?,
                  fecha_respuesta = " . ($nuevo_estado !== 'en_revision' ? "NOW()" : "NULL") . "
              WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$nuevo_estado, $respuesta, $envio_id]);
    
    // Obtener información del ciudadano y departamento para la notificación
    $stmt = $conn->prepare("
        SELECT s.usuario_id, s.descripcion, u.nombre as dept_nombre, u.apellido as dept_apellido
        FROM solicitudes s
        INNER JOIN solicitudes_enviadas se ON s.id = se.solicitud_id
        INNER JOIN usuarios u ON se.departamento_id = u.id
        WHERE s.id = ? AND se.id = ?
    ");
    $stmt->execute([$solicitud_id, $envio_id]);
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si se autoriza o rechaza, actualizar el estado de la solicitud original
    if ($nuevo_estado === 'autorizada') {
        $stmt = $conn->prepare("UPDATE solicitudes SET estado = 'completada' WHERE id = ?");
        $stmt->execute([$solicitud_id]);
        
        // Crear notificación de autorización
        crearNotificacion(
            $info['usuario_id'],
            $solicitud_id,
            '✅ Solicitud Autorizada',
            "Su solicitud '{$info['descripcion']}' ha sido AUTORIZADA por el departamento {$info['dept_nombre']} {$info['dept_apellido']}. " . 
            ($respuesta ? "Comentarios: $respuesta" : ""),
            'success'
        );
        
    } else if ($nuevo_estado === 'rechazada') {
        $stmt = $conn->prepare("UPDATE solicitudes SET estado = 'rechazada' WHERE id = ?");
        $stmt->execute([$solicitud_id]);
        
        // Crear notificación de rechazo
        crearNotificacion(
            $info['usuario_id'],
            $solicitud_id,
            '❌ Solicitud Rechazada',
            "Su solicitud '{$info['descripcion']}' ha sido RECHAZADA por el departamento {$info['dept_nombre']} {$info['dept_apellido']}. " . 
            ($respuesta ? "Motivo: $respuesta" : ""),
            'error'
        );
        
    } else if ($nuevo_estado === 'en_revision') {
        // Crear notificación de revisión
        crearNotificacion(
            $info['usuario_id'],
            $solicitud_id,
            '🔍 Solicitud en Revisión',
            "Su solicitud '{$info['descripcion']}' está siendo revisada por el departamento {$info['dept_nombre']} {$info['dept_apellido']}. " . 
            ($respuesta ? "Comentarios: $respuesta" : ""),
            'info'
        );
    }
    
    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);
    
} catch (PDOException $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 