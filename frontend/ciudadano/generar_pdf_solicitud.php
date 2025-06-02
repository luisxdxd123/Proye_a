<?php
require_once '../../backend/auth.php';
checkRole('ciudadano');

// Verificar que se recibió el ID
if (!isset($_GET['id'])) {
    die('ID de solicitud no especificado');
}

require_once(__DIR__ . '/../../backend/config/db_config.php');

// Obtener información de la solicitud
try {
    $solicitudId = $_GET['id'];
    $userId = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("SELECT 
        s.*,
        u.nombre,
        u.apellido,
        u.contacto as contacto_1
    FROM solicitudes s
    INNER JOIN usuarios u ON s.usuario_id = u.id
    WHERE s.id = ? AND s.usuario_id = ?");
    $stmt->execute([$solicitudId, $userId]);
    $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$solicitud) {
        die('Solicitud no encontrada');
    }
} catch(PDOException $e) {
    die('Error al obtener la solicitud: ' . $e->getMessage());
}

// Incluir librería TCPDF (necesitas instalarla primero)
// Por ahora, mostraremos una versión HTML que se puede imprimir como PDF

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud #<?php echo $solicitud['id']; ?></title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
            color: #333;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #6B1024;
            padding-bottom: 20px;
        }
        .title { 
            color: #6B1024; 
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        .section-title {
            font-weight: bold;
            color: #6B1024;
            margin-bottom: 10px;
            font-size: 18px;
        }
        .field {
            margin-bottom: 10px;
        }
        .field-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .field-value {
            display: inline-block;
        }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">SOLICITUD DE SERVICIO</div>
        <div>Folio: #<?php echo str_pad($solicitud['id'], 6, '0', STR_PAD_LEFT); ?></div>
        <div>Fecha: <?php echo date('d/m/Y', strtotime($solicitud['fecha_creacion'])); ?></div>
    </div>

    <div class="section">
        <div class="section-title">DATOS DEL SOLICITANTE</div>
        <div class="field">
            <span class="field-label">Nombre:</span>
            <span class="field-value"><?php echo htmlspecialchars($solicitud['nombre'] . ' ' . $solicitud['apellido']); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Teléfono Principal:</span>
            <span class="field-value"><?php echo htmlspecialchars($solicitud['contacto_1'] ?: 'No especificado'); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Teléfono Secundario:</span>
            <span class="field-value"><?php echo htmlspecialchars($solicitud['contacto_secundario'] ?: 'No especificado'); ?></span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">DESCRIPCIÓN DE LA SOLICITUD</div>
        <div style="white-space: pre-wrap;"><?php echo htmlspecialchars($solicitud['descripcion']); ?></div>
    </div>

    <div class="section">
        <div class="section-title">ESTADO ACTUAL</div>
        <div class="field">
            <span class="field-label">Estado:</span>
            <span class="field-value"><?php echo htmlspecialchars(ucfirst($solicitud['estado'])); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Fecha de creación:</span>
            <span class="field-value"><?php echo date('d/m/Y H:i', strtotime($solicitud['fecha_creacion'])); ?></span>
        </div>
        <?php if ($solicitud['fecha_actualizacion']): ?>
        <div class="field">
            <span class="field-label">Última actualización:</span>
            <span class="field-value"><?php echo date('d/m/Y H:i', strtotime($solicitud['fecha_actualizacion'])); ?></span>
        </div>
        <?php endif; ?>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 30px;">
        <button onclick="window.print();" style="background-color: #6B1024; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
            Imprimir / Guardar como PDF
        </button>
        <button onclick="window.close();" style="background-color: #666; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Cerrar
        </button>
    </div>

    <script>
        // Auto-abrir el diálogo de impresión
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html> 