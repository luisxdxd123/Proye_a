<?php
require_once '../config/db_config.php';
require_once '../auth.php';

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
    // Verificar si la solicitud existe
    $stmt = $conn->prepare("SELECT id FROM solicitudes WHERE id = ?");
    $stmt->execute([$solicitud_id]);
    if (!$stmt->fetch()) {
        echo json_encode(['success' => false, 'error' => 'Solicitud no encontrada']);
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
    
    echo json_encode(['success' => true, 'message' => 'Solicitud enviada correctamente']);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 