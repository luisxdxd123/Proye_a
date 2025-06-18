<?php
require_once 'auth.php';
require_once 'config/db_config.php';

// Verificar que el usuario esté autenticado (cualquier rol)
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

$contrasena_actual = $_POST['contrasena_actual'] ?? '';
$contrasena_nueva = $_POST['contrasena_nueva'] ?? '';
$confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

// Validaciones básicas
if (empty($contrasena_actual) || empty($contrasena_nueva) || empty($confirmar_contrasena)) {
    echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios']);
    exit;
}

if ($contrasena_nueva !== $confirmar_contrasena) {
    echo json_encode(['success' => false, 'error' => 'Las contraseñas nuevas no coinciden']);
    exit;
}

if (strlen($contrasena_nueva) < 6) {
    echo json_encode(['success' => false, 'error' => 'La contraseña debe tener al menos 6 caracteres']);
    exit;
}

try {
    $user_id = $_SESSION['user_id'];
    
    // Obtener la contraseña actual del usuario
    $stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE id = ?");
    $stmt->execute([$user_id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
        exit;
    }
    
    // Verificar la contraseña actual
    if (!password_verify($contrasena_actual, $usuario['contrasena'])) {
        echo json_encode(['success' => false, 'error' => 'La contraseña actual es incorrecta']);
        exit;
    }
    
    // Hashear la nueva contraseña
    $contrasena_hasheada = password_hash($contrasena_nueva, PASSWORD_DEFAULT);
    
    // Actualizar la contraseña en la base de datos
    $stmt = $conn->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
    $success = $stmt->execute([$contrasena_hasheada, $user_id]);
    
    if ($success) {
        // Log de seguridad
        error_log("Contraseña cambiada para usuario ID: $user_id - " . date('Y-m-d H:i:s'));
        
        echo json_encode([
            'success' => true, 
            'message' => 'Contraseña cambiada exitosamente'
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al actualizar la contraseña']);
    }
    
} catch (PDOException $e) {
    error_log("Error al cambiar contraseña: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Error del servidor']);
}
?> 