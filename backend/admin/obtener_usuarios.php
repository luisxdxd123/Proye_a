<?php
require_once '../auth.php';
require_once '../config/db_config.php';

checkRole('admin');

header('Content-Type: application/json');

try {
    $filtro_rol = $_GET['rol'] ?? '';
    
    // Consulta base
    $query = "SELECT id, nombre, apellido, contacto, rol_user, fecha_registro 
              FROM usuarios 
              WHERE 1=1";
    
    $params = [];
    
    // Filtrar por rol si se especifica
    if (!empty($filtro_rol) && $filtro_rol !== 'todos') {
        $query .= " AND rol_user = ?";
        $params[] = $filtro_rol;
    }
    
    $query .= " ORDER BY rol_user, nombre ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'usuarios' => $usuarios
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 