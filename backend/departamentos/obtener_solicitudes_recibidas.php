<?php
require_once '../config/db_config.php';
require_once '../auth.php';

checkRole('departamentos');

header('Content-Type: application/json');

try {
    // Obtener el ID del departamento del usuario actual
    $usuario_id = $_SESSION['user_id'];
    
    // Obtener solicitudes enviadas a este departamento
    $query = "SELECT 
                se.id as envio_id,
                se.solicitud_id,
                se.observaciones as observaciones_presidencia,
                se.fecha_envio,
                se.estado as estado_envio,
                s.descripcion,
                s.fecha_creacion as fecha_solicitud,
                s.ine,
                s.curp,
                s.comprobante_domicilio,
                s.documento_adicional,
                s.imagen_adicional,
                u.nombre as ciudadano_nombre,
                u.apellido as ciudadano_apellido,
                u.contacto as ciudadano_contacto,
                up.nombre as enviado_por_nombre,
                up.apellido as enviado_por_apellido
              FROM solicitudes_enviadas se
              INNER JOIN solicitudes s ON se.solicitud_id = s.id
              INNER JOIN usuarios u ON s.usuario_id = u.id
              INNER JOIN usuarios up ON se.enviado_por = up.id
              WHERE se.departamento_id = ? AND se.estado = 'pendiente'
              ORDER BY se.fecha_envio DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$usuario_id]);
    $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'solicitudes' => $solicitudes]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 