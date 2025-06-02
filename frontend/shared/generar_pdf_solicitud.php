<?php
require_once '../../backend/auth.php';

// Verificar que el usuario tiene un rol válido (ciudadano, presidencia o departamentos)
$roles_permitidos = ['ciudadano', 'presidencia', 'departamentos'];
if (!isset($_SESSION['rol_user']) || !in_array($_SESSION['rol_user'], $roles_permitidos)) {
    header('Location: ../log_reg.php');
    exit();
}

// Verificar que se recibió el ID
if (!isset($_GET['id'])) {
    die('ID de solicitud no especificado');
}

require_once(__DIR__ . '/../../backend/config/db_config.php');

// Obtener información de la solicitud
try {
    $solicitudId = $_GET['id'];
    $userRole = $_SESSION['rol_user'];
    
    // Consulta base para obtener la solicitud
    $query = "SELECT 
        s.*,
        u.nombre,
        u.apellido,
        u.contacto as contacto_1
    FROM solicitudes s
    INNER JOIN usuarios u ON s.usuario_id = u.id
    WHERE s.id = ?";
    
    // Si es ciudadano, verificar que la solicitud le pertenece
    if ($userRole === 'ciudadano') {
        $query .= " AND s.usuario_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$solicitudId, $_SESSION['user_id']]);
    } else {
        // Para presidencia y departamentos, pueden ver cualquier solicitud
        $stmt = $conn->prepare($query);
        $stmt->execute([$solicitudId]);
    }
    
    $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$solicitud) {
        die('Solicitud no encontrada o no tiene permisos para verla');
    }
    
    // Si es departamento, verificar que la solicitud le fue enviada
    if ($userRole === 'departamentos') {
        $stmt = $conn->prepare("SELECT id FROM solicitudes_enviadas WHERE solicitud_id = ? AND departamento_id = ?");
        $stmt->execute([$solicitudId, $_SESSION['user_id']]);
        if (!$stmt->fetch()) {
            die('No tiene permisos para ver esta solicitud');
        }
    }
    
    // Obtener información adicional si existe en solicitudes_enviadas
    $infoEnvio = null;
    if ($userRole !== 'ciudadano') {
        $stmt = $conn->prepare("
            SELECT se.*, 
                   ud.nombre as departamento_nombre,
                   up.nombre as enviado_por_nombre
            FROM solicitudes_enviadas se
            LEFT JOIN usuarios ud ON se.departamento_id = ud.id
            LEFT JOIN usuarios up ON se.enviado_por = up.id
            WHERE se.solicitud_id = ?
            ORDER BY se.fecha_envio DESC
            LIMIT 1
        ");
        $stmt->execute([$solicitudId]);
        $infoEnvio = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
} catch(PDOException $e) {
    die('Error al obtener la solicitud: ' . $e->getMessage());
}

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
            width: 180px;
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

    <?php if ($infoEnvio && $userRole !== 'ciudadano'): ?>
    <div class="section">
        <div class="section-title">INFORMACIÓN DE PROCESO</div>
        <div class="field">
            <span class="field-label">Enviada por:</span>
            <span class="field-value"><?php echo htmlspecialchars($infoEnvio['enviado_por_nombre']); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Departamento asignado:</span>
            <span class="field-value"><?php echo htmlspecialchars($infoEnvio['departamento_nombre']); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Fecha de envío:</span>
            <span class="field-value"><?php echo date('d/m/Y H:i', strtotime($infoEnvio['fecha_envio'])); ?></span>
        </div>
        <div class="field">
            <span class="field-label">Estado del proceso:</span>
            <span class="field-value"><?php echo htmlspecialchars(ucfirst($infoEnvio['estado'])); ?></span>
        </div>
        <?php if ($infoEnvio['observaciones']): ?>
        <div class="field">
            <span class="field-label">Observaciones presidencia:</span>
            <span class="field-value"><?php echo htmlspecialchars($infoEnvio['observaciones']); ?></span>
        </div>
        <?php endif; ?>
        <?php if ($infoEnvio['respuesta_departamento']): ?>
        <div class="field">
            <span class="field-label">Respuesta departamento:</span>
            <span class="field-value"><?php echo htmlspecialchars($infoEnvio['respuesta_departamento']); ?></span>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

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