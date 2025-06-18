<?php
require_once '../auth.php';
require_once '../config/db_config.php';

checkRole('admin');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

$usuario_id = $_POST['usuario_id'] ?? '';
$contrasena_nueva = $_POST['contrasena_nueva'] ?? '';
$confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

// Validaciones básicas
if (empty($usuario_id) || empty($contrasena_nueva) || empty($confirmar_contrasena)) {
    echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios']);
    exit;
}

if ($contrasena_nueva !== $confirmar_contrasena) {
    echo json_encode(['success' => false, 'error' => 'Las contraseñas no coinciden']);
    exit;
}

if (strlen($contrasena_nueva) < 6) {
    echo json_encode(['success' => false, 'error' => 'La contraseña debe tener al menos 6 caracteres']);
    exit;
}

try {
    // Verificar que el usuario existe
    $stmt = $conn->prepare("SELECT id, nombre, apellido, rol_user FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
        exit;
    }
    
    // Hashear la nueva contraseña
    $contrasena_hasheada = password_hash($contrasena_nueva, PASSWORD_DEFAULT);
    
    // Actualizar la contraseña en la base de datos
    $stmt = $conn->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
    $success = $stmt->execute([$contrasena_hasheada, $usuario_id]);
    
    if ($success) {
        // Log de seguridad
        $admin_id = $_SESSION['user_id'];
        $log_message = "Admin ID: $admin_id cambió contraseña del usuario ID: $usuario_id ({$usuario['nombre']} {$usuario['apellido']} - {$usuario['rol_user']}) - " . date('Y-m-d H:i:s');
        error_log($log_message);
        
        echo json_encode([
            'success' => true, 
            'message' => "Contraseña actualizada para {$usuario['nombre']} {$usuario['apellido']}"
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al actualizar la contraseña']);
    }
    
} catch (PDOException $e) {
    error_log("Error al cambiar contraseña de usuario: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Error del servidor']);
}
?> 