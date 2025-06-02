<?php
require_once '../config/db_config.php';
require_once '../auth.php';

checkRole('departamentos');

header('Content-Type: application/json');

try {
    $usuario_id = $_SESSION['user_id'];
    
    // Obtener solicitudes en proceso de revisión
    $query = "SELECT 
                se.id as envio_id,
                se.solicitud_id,
                se.observaciones as observaciones_presidencia,
                se.fecha_envio,
                se.estado as estado_envio,
                se.fecha_respuesta,
                se.respuesta_departamento,
                s.descripcion,
                s.fecha_creacion as fecha_solicitud,
                u.nombre as ciudadano_nombre,
                u.apellido as ciudadano_apellido,
                u.contacto as ciudadano_contacto
              FROM solicitudes_enviadas se
              INNER JOIN solicitudes s ON se.solicitud_id = s.id
              INNER JOIN usuarios u ON s.usuario_id = u.id
              WHERE se.departamento_id = ? AND se.estado = 'en_revision'
              ORDER BY se.fecha_envio DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$usuario_id]);
    $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'solicitudes' => $solicitudes]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 