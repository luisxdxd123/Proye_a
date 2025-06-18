<?php
require_once '../config/db_config.php';
require_once '../auth.php';
require_once '../notificaciones/crear_notificacion.php';

checkRole('presidencia');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

$solicitud_id = $_POST['solicitud_id'] ?? null;
$departamento_id = $_POST['departamento_id'] ?? null;
$observaciones = $_POST['observaciones'] ?? '';

if (!$solicitud_id || !$departamento_id) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit;
}

try {
    // Obtener información completa de la solicitud y departamento
    $stmt = $conn->prepare("
        SELECT s.id, s.descripcion, s.usuario_id, u.nombre as ciudadano_nombre,
               ud.nombre as dept_nombre, ud.apellido as dept_apellido
        FROM solicitudes s
        INNER JOIN usuarios u ON s.usuario_id = u.id
        CROSS JOIN usuarios ud
        WHERE s.id = ? AND ud.id = ?
    ");
    $stmt->execute([$solicitud_id, $departamento_id]);
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$info) {
        echo json_encode(['success' => false, 'error' => 'Solicitud o departamento no encontrado']);
        exit;
    }
    
    // Insertar en solicitudes_enviadas
    $query = "INSERT INTO solicitudes_enviadas (solicitud_id, departamento_id, enviado_por, observaciones) 
              VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$solicitud_id, $departamento_id, $_SESSION['user_id'], $observaciones]);
    
    // Actualizar estado de la solicitud original a 'en_proceso'
    $stmt = $conn->prepare("UPDATE solicitudes SET estado = 'en_proceso' WHERE id = ?");
    $stmt->execute([$solicitud_id]);
    
    // Crear notificación para el ciudadano
    crearNotificacion(
        $info['usuario_id'],
        $solicitud_id,
        '📤 Solicitud Enviada a Departamento',
        "Su solicitud '{$info['descripcion']}' ha sido enviada al departamento {$info['dept_nombre']} {$info['dept_apellido']} para su revisión. " . 
        ($observaciones ? "Observaciones: $observaciones" : ""),
        'info'
    );
    
    echo json_encode(['success' => true, 'message' => 'Solicitud enviada correctamente']);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 