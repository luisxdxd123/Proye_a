<?php
require_once '../../backend/auth.php';
require_once '../../backend/db.php';
checkRole('ciudadano');

// Variables para mensajes
$mensaje = null;
$tipo_mensaje = null;

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Crear directorio para archivos si no existe
        $upload_dir = '../../uploads/solicitudes/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Función para mover y guardar archivo
        function guardarArchivo($file, $prefix) {
            global $upload_dir;
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $nombre_archivo = $prefix . '_' . uniqid() . '.' . $extension;
            $ruta_completa = $upload_dir . $nombre_archivo;
            
            if (!move_uploaded_file($file['tmp_name'], $ruta_completa)) {
                throw new Exception("Error al guardar el archivo " . $file['name']);
            }
            return $nombre_archivo;
        }
        
        // Guardar archivos opcionales si existen
        $ruta_documento = isset($_FILES['documento']) && $_FILES['documento']['error'] === UPLOAD_ERR_OK ? 
            guardarArchivo($_FILES['documento'], 'documento') : null;
        $ruta_imagen = isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK ? 
            guardarArchivo($_FILES['imagen'], 'imagen') : null;

        // Insertar en la base de datos
        $sql = "INSERT INTO solicitudes (usuario_id, descripcion, contacto_secundario, documento_adicional, imagen_adicional) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_SESSION['user_id'],
            $_POST['descripcion'],
            $_POST['contacto2'],
            $ruta_documento,
            $ruta_imagen
        ]);

        $mensaje = "Solicitud registrada exitosamente";
        $tipo_mensaje = "success";
    } catch (Exception $e) {
        $mensaje = $e->getMessage();
        $tipo_mensaje = "error";
    }
}
?> 