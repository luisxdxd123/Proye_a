<?php
require_once '../config/db_config.php';
require_once '../auth.php';

checkRole('presidencia');

header('Content-Type: application/json');

try {
    // Obtener usuarios con rol departamentos (consistente con solicitudes_enviadas)
    $query = "SELECT 
                id,
                nombre,
                apellido,
                contacto
              FROM usuarios
              WHERE rol_user = 'departamentos'
              ORDER BY nombre ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $usuarios_departamento = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Formatear como departamentos
    $departamentos = array_map(function($user) {
        return [
            'id' => $user['id'],
            'nombre' => $user['nombre'] . ' ' . $user['apellido'],
            'descripcion' => 'Departamento',
            'usuario_nombre' => $user['nombre'],
            'usuario_apellido' => $user['apellido'],
            'contacto' => $user['contacto']
        ];
    }, $usuarios_departamento);
    
    echo json_encode(['success' => true, 'departamentos' => $departamentos]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 