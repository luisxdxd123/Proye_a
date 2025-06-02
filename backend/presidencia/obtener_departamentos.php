<?php
require_once '../config/db_config.php';
require_once '../auth.php';

checkRole('presidencia');

header('Content-Type: application/json');

try {
    // Obtener todos los departamentos
    $query = "SELECT 
                d.id,
                d.nombre,
                d.descripcion,
                u.nombre as usuario_nombre,
                u.apellido as usuario_apellido,
                u.contacto
              FROM departamentos d
              INNER JOIN usuarios u ON d.usuario_id = u.id
              WHERE d.activo = true
              ORDER BY d.nombre ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Si no hay departamentos, obtener usuarios con rol departamentos
    if (empty($departamentos)) {
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
                'nombre' => 'Departamento de ' . $user['nombre'] . ' ' . $user['apellido'],
                'descripcion' => '',
                'usuario_nombre' => $user['nombre'],
                'usuario_apellido' => $user['apellido'],
                'contacto' => $user['contacto']
            ];
        }, $usuarios_departamento);
    }
    
    echo json_encode(['success' => true, 'departamentos' => $departamentos]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 