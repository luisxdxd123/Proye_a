<?php
require_once '../config/db_config.php';
require_once '../auth.php';

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
    
    // Si se autoriza o rechaza, actualizar el estado de la solicitud original
    if ($nuevo_estado === 'autorizada') {
        $stmt = $conn->prepare("UPDATE solicitudes SET estado = 'completada' WHERE id = ?");
        $stmt->execute([$solicitud_id]);
    } else if ($nuevo_estado === 'rechazada') {
        $stmt = $conn->prepare("UPDATE solicitudes SET estado = 'rechazada' WHERE id = ?");
        $stmt->execute([$solicitud_id]);
    }
    
    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);
    
} catch (PDOException $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 