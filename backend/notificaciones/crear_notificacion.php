<?php
require_once '../config/db_config.php';

function crearNotificacion($usuario_id, $solicitud_id, $titulo, $mensaje, $tipo = 'info') {
    global $conn;
    
    try {
        $stmt = $conn->prepare("
            INSERT INTO notificaciones (usuario_id, solicitud_id, titulo, mensaje, tipo) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([$usuario_id, $solicitud_id, $titulo, $mensaje, $tipo]);
    } catch (PDOException $e) {
        error_log("Error al crear notificación: " . $e->getMessage());
        return false;
    }
}

function obtenerNotificaciones($usuario_id, $solo_no_leidas = false) {
    global $conn;
    
    try {
        $query = "
            SELECT n.*, s.descripcion as solicitud_descripcion 
            FROM notificaciones n
            LEFT JOIN solicitudes s ON n.solicitud_id = s.id
            WHERE n.usuario_id = ?
        ";
        
        if ($solo_no_leidas) {
            $query .= " AND n.leida = 0";
        }
        
        $query .= " ORDER BY n.fecha_creacion DESC";
        
        $stmt = $conn->prepare($query);
        $stmt->execute([$usuario_id]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener notificaciones: " . $e->getMessage());
        return [];
    }
}

function marcarNotificacionLeida($notificacion_id, $usuario_id) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("
            UPDATE notificaciones 
            SET leida = 1 
            WHERE id = ? AND usuario_id = ?
        ");
        
        return $stmt->execute([$notificacion_id, $usuario_id]);
    } catch (PDOException $e) {
        error_log("Error al marcar notificación como leída: " . $e->getMessage());
        return false;
    }
}

function contarNotificacionesNoLeidas($usuario_id) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("
            SELECT COUNT(*) as total 
            FROM notificaciones 
            WHERE usuario_id = ? AND leida = 0
        ");
        
        $stmt->execute([$usuario_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] ?? 0;
    } catch (PDOException $e) {
        error_log("Error al contar notificaciones: " . $e->getMessage());
        return 0;
    }
}
?> 