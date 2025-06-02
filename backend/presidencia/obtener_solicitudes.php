<?php
require_once '../config/db_config.php';
require_once '../auth.php';

checkRole('presidencia');

header('Content-Type: application/json');

try {
    // Obtener todas las solicitudes de ciudadanos
    $query = "SELECT 
                s.id,
                s.descripcion,
                s.estado,
                s.fecha_creacion,
                s.ine,
                s.curp,
                s.comprobante_domicilio,
                s.documento_adicional,
                s.imagen_adicional,
                u.nombre,
                u.apellido,
                u.contacto,
                (SELECT COUNT(*) FROM solicitudes_enviadas WHERE solicitud_id = s.id) as veces_enviada
              FROM solicitudes s
              INNER JOIN usuarios u ON s.usuario_id = u.id
              WHERE u.rol_user = 'ciudadano'
              ORDER BY s.fecha_creacion DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'solicitudes' => $solicitudes]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 