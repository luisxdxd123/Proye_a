<?php
require_once '../auth.php';
require_once '../config/db_config.php';

checkRole('ciudadano');

header('Content-Type: application/json');

try {
    $usuario_id = $_SESSION['user_id'];
    
    // Contar trámites activos (pendientes y en proceso)
    $stmt = $conn->prepare("
        SELECT COUNT(*) as total 
        FROM solicitudes 
        WHERE usuario_id = ? AND estado IN ('pendiente', 'en_proceso')
    ");
    $stmt->execute([$usuario_id]);
    $tramites_activos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Obtener el último estado de solicitud
    $stmt = $conn->prepare("
        SELECT estado, fecha_actualizacion as fecha
        FROM solicitudes 
        WHERE usuario_id = ? 
        ORDER BY fecha_actualizacion DESC 
        LIMIT 1
    ");
    $stmt->execute([$usuario_id]);
    $ultimo_estado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Obtener totales por estado
    $stmt = $conn->prepare("
        SELECT 
            estado,
            COUNT(*) as cantidad
        FROM solicitudes 
        WHERE usuario_id = ? 
        GROUP BY estado
    ");
    $stmt->execute([$usuario_id]);
    $por_estado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'tramites_activos' => (int)$tramites_activos,
        'ultimo_estado' => $ultimo_estado,
        'por_estado' => $por_estado
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 