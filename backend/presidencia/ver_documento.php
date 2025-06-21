<?php
require_once '../auth.php';
require_once '../config/db_config.php';

checkRole('presidencia');

// Función para registrar errores en un log
function logError($message) {
    $logFile = __DIR__ . '/../../logs/documento_errors.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
}

// Verificar que se recibieron los parámetros necesarios
if (!isset($_GET['solicitud_id']) || !isset($_GET['tipo'])) {
    logError("Parámetros faltantes - solicitud_id: " . ($_GET['solicitud_id'] ?? 'null') . ", tipo: " . ($_GET['tipo'] ?? 'null'));
    http_response_code(400);
    die('Parámetros faltantes');
}

$solicitud_id = intval($_GET['solicitud_id']);
$tipo_documento = $_GET['tipo'];

// Tipos de documentos permitidos
$tipos_permitidos = ['ine', 'curp', 'comprobante_domicilio', 'documento_adicional', 'imagen_adicional'];

if (!in_array($tipo_documento, $tipos_permitidos)) {
    logError("Tipo de documento no válido: $tipo_documento para solicitud: $solicitud_id");
    http_response_code(400);
    die('Tipo de documento no válido');
}

try {
    // Obtener información de la solicitud y el documento
    $query = "SELECT 
                s.{$tipo_documento},
                s.id as solicitud_id,
                u.nombre,
                u.apellido
              FROM solicitudes s
              INNER JOIN usuarios u ON s.usuario_id = u.id
              WHERE s.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$solicitud_id]);
    $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$solicitud) {
        logError("Solicitud no encontrada: $solicitud_id");
        http_response_code(404);
        die('Solicitud no encontrada');
    }
    
    $nombre_archivo = $solicitud[$tipo_documento];
    
    if (!$nombre_archivo || trim($nombre_archivo) === '') {
        logError("Documento no disponible - Solicitud: $solicitud_id, Tipo: $tipo_documento, Campo BD: " . ($nombre_archivo ?? 'null'));
        http_response_code(404);
        die('Documento no disponible para esta solicitud');
    }
    
    // Limpiar el nombre del archivo de caracteres problemáticos
    $nombre_archivo = trim($nombre_archivo);
    
    // Construir la ruta del archivo
    $ruta_archivo = __DIR__ . '/../../uploads/documentos/' . $nombre_archivo;
    
    // Log para debugging
    logError("DEBUG - Solicitud: $solicitud_id, Tipo: $tipo_documento, Archivo: $nombre_archivo, Ruta: $ruta_archivo");
    
    if (!file_exists($ruta_archivo)) {
        logError("Archivo no encontrado en el sistema - Solicitud: $solicitud_id, Archivo: $nombre_archivo, Ruta: $ruta_archivo");
        
        // Intentar buscar archivos similares
        $directorio = __DIR__ . '/../../uploads/documentos/';
        $archivos = scandir($directorio);
        $archivos_similares = [];
        
        foreach ($archivos as $archivo) {
            if (strpos($archivo, (string)$solicitud_id) !== false || 
                strpos(strtolower($archivo), strtolower(basename($nombre_archivo))) !== false) {
                $archivos_similares[] = $archivo;
            }
        }
        
        if (!empty($archivos_similares)) {
            logError("Archivos similares encontrados: " . implode(', ', $archivos_similares));
        }
        
        http_response_code(404);
        die('Archivo no encontrado en el servidor. Por favor, contacte al administrador.');
    }
    
    // Determinar el tipo de contenido
    $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
    $tipos_mime = [
        'pdf' => 'application/pdf',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'webp' => 'image/webp',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'txt' => 'text/plain'
    ];
    
    $content_type = $tipos_mime[$extension] ?? 'application/octet-stream';
    
    // Configurar headers para mostrar el archivo
    header('Content-Type: ' . $content_type);
    header('Content-Length: ' . filesize($ruta_archivo));
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    
    // Si es PDF o imagen, mostrar en línea, si no, descargar
    if (in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
        header('Content-Disposition: inline; filename="' . basename($nombre_archivo) . '"');
    } else {
        header('Content-Disposition: attachment; filename="' . basename($nombre_archivo) . '"');
    }
    
    // Log de éxito
    logError("SUCCESS - Documento servido correctamente - Solicitud: $solicitud_id, Archivo: $nombre_archivo");
    
    // Enviar el archivo
    readfile($ruta_archivo);
    
} catch (PDOException $e) {
    logError("Error de base de datos: " . $e->getMessage() . " - Solicitud: $solicitud_id");
    http_response_code(500);
    die('Error del servidor: No se pudo acceder a la base de datos');
} catch (Exception $e) {
    logError("Error general: " . $e->getMessage() . " - Solicitud: $solicitud_id");
    http_response_code(500);
    die('Error del servidor: ' . $e->getMessage());
}
?> 