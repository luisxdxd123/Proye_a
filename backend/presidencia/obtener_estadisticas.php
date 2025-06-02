<?php
require_once '../config/db_config.php';
require_once '../auth.php';

checkRole('presidencia');

header('Content-Type: application/json');

try {
    $estadisticas = [];
    
    // Total de solicitudes
    $stmt = $conn->query("SELECT COUNT(*) as total FROM solicitudes");
    $estadisticas['total_solicitudes'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Solicitudes por estado
    $stmt = $conn->query("SELECT estado, COUNT(*) as cantidad FROM solicitudes GROUP BY estado");
    $estadisticas['solicitudes_por_estado'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Solicitudes enviadas a departamentos
    $stmt = $conn->query("SELECT COUNT(*) as total FROM solicitudes_enviadas");
    $estadisticas['total_enviadas'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Solicitudes autorizadas
    $stmt = $conn->query("SELECT COUNT(*) as total FROM solicitudes_enviadas WHERE estado = 'autorizada'");
    $estadisticas['total_autorizadas'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Solicitudes por departamento
    $query = "SELECT 
                COALESCE(d.nombre, CONCAT('Departamento de ', ud.nombre, ' ', ud.apellido)) as departamento,
                COUNT(se.id) as cantidad,
                SUM(CASE WHEN se.estado = 'autorizada' THEN 1 ELSE 0 END) as autorizadas,
                SUM(CASE WHEN se.estado = 'rechazada' THEN 1 ELSE 0 END) as rechazadas,
                SUM(CASE WHEN se.estado IN ('pendiente', 'en_revision') THEN 1 ELSE 0 END) as pendientes
              FROM solicitudes_enviadas se
              LEFT JOIN departamentos d ON se.departamento_id = d.id
              INNER JOIN usuarios ud ON (d.usuario_id = ud.id OR se.departamento_id = ud.id)
              GROUP BY COALESCE(d.id, se.departamento_id)";
    
    $stmt = $conn->query($query);
    $estadisticas['por_departamento'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Solicitudes por mes (últimos 6 meses)
    $query = "SELECT 
                DATE_FORMAT(fecha_creacion, '%Y-%m') as mes,
                COUNT(*) as cantidad
              FROM solicitudes
              WHERE fecha_creacion >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
              GROUP BY DATE_FORMAT(fecha_creacion, '%Y-%m')
              ORDER BY mes ASC";
    
    $stmt = $conn->query($query);
    $estadisticas['por_mes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Tiempo promedio de respuesta (en días)
    $query = "SELECT 
                AVG(DATEDIFF(fecha_respuesta, fecha_envio)) as promedio_dias
              FROM solicitudes_enviadas
              WHERE fecha_respuesta IS NOT NULL";
    
    $stmt = $conn->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $estadisticas['promedio_respuesta_dias'] = round($result['promedio_dias'] ?? 0, 1);
    
    echo json_encode(['success' => true, 'estadisticas' => $estadisticas]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 