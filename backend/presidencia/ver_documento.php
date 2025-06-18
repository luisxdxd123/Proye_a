<?php
require_once '../auth.php';
require_once '../config/db_config.php';

checkRole('presidencia');

// Verificar que se recibieron los parámetros necesarios
if (!isset($_GET['solicitud_id']) || !isset($_GET['tipo'])) {
    http_response_code(400);
    die('Parámetros faltantes');
}

$solicitud_id = $_GET['solicitud_id'];
$tipo_documento = $_GET['tipo'];

// Tipos de documentos permitidos
$tipos_permitidos = ['ine', 'curp', 'comprobante_domicilio', 'documento_adicional', 'imagen_adicional'];

if (!in_array($tipo_documento, $tipos_permitidos)) {
    http_response_code(400);
    die('Tipo de documento no válido');
}

try {
    // Obtener información de la solicitud y el documento
    $query = "SELECT 
                s.{$tipo_documento},
                u.nombre,
                u.apellido
              FROM solicitudes s
              INNER JOIN usuarios u ON s.usuario_id = u.id
              WHERE s.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$solicitud_id]);
    $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$solicitud) {
        http_response_code(404);
        die('Solicitud no encontrada');
    }
    
    $nombre_archivo = $solicitud[$tipo_documento];
    
    if (!$nombre_archivo) {
        http_response_code(404);
        die('Documento no disponible');
    }
    
    // Construir la ruta del archivo
    $ruta_archivo = __DIR__ . '/../../uploads/documentos/' . $nombre_archivo;
    
    if (!file_exists($ruta_archivo)) {
        http_response_code(404);
        die('Archivo no encontrado');
    }
    
    // Determinar el tipo de contenido
    $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
    $tipos_mime = [
        'pdf' => 'application/pdf',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    
    $content_type = $tipos_mime[$extension] ?? 'application/octet-stream';
    
    // Configurar headers para mostrar el archivo
    header('Content-Type: ' . $content_type);
    header('Content-Length: ' . filesize($ruta_archivo));
    
    // Si es PDF o imagen, mostrar en línea, si no, descargar
    if (in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif'])) {
        header('Content-Disposition: inline; filename="' . basename($nombre_archivo) . '"');
    } else {
        header('Content-Disposition: attachment; filename="' . basename($nombre_archivo) . '"');
    }
    
    // Enviar el archivo
    readfile($ruta_archivo);
    
} catch (PDOException $e) {
    http_response_code(500);
    die('Error del servidor: ' . $e->getMessage());
}
?> 