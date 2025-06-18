<?php
require_once '../config/db_config.php';
require_once '../auth.php';

checkRole('presidencia');

header('Content-Type: application/json');

try {
    $query = "SELECT 
                se.id,
                se.solicitud_id,
                se.observaciones,
                se.fecha_envio,
                se.fecha_respuesta,
                se.respuesta_departamento,
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
                ud.nombre as departamento_nombre,
                ud.apellido as departamento_apellido
              FROM solicitudes_enviadas se
              INNER JOIN solicitudes s ON se.solicitud_id = s.id
              INNER JOIN usuarios u ON s.usuario_id = u.id
              INNER JOIN usuarios ud ON se.departamento_id = ud.id
              WHERE se.estado = 'autorizada'
              ORDER BY se.fecha_respuesta DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $solicitudes_autorizadas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'solicitudes_autorizadas' => $solicitudes_autorizadas]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 