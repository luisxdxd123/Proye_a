<?php
require_once '../../backend/auth.php';
checkRole('ciudadano');

// Conexión a la base de datos
require_once(__DIR__ . '/../../backend/config/db_config.php');

try {
    $userId = $_SESSION['user_id'];
    // Consulta para obtener todos los datos necesarios con información de envío
    $stmt = $conn->prepare("SELECT 
        s.id as id_solicitud,
        s.descripcion,
        s.estado,
        s.fecha_creacion as fecha_solicitud,
        s.fecha_actualizacion,
        s.ine,
        s.curp,
        s.comprobante_domicilio,
        s.documento_adicional,
        u.nombre,
        u.apellido,
        u.contacto as contacto_1,
        s.contacto_secundario as contacto_2,
        se.estado as estado_envio,
        se.respuesta_departamento,
        se.fecha_respuesta,
        ud.nombre as departamento_nombre,
        ud.apellido as departamento_apellido
    FROM solicitudes s
    INNER JOIN usuarios u ON s.usuario_id = u.id
    LEFT JOIN solicitudes_enviadas se ON s.id = se.solicitud_id
    LEFT JOIN usuarios ud ON se.departamento_id = ud.id
    WHERE s.usuario_id = ?
    ORDER BY s.fecha_creacion DESC");
    $stmt->execute([$userId]);
    $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Procesar actualización de documentos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_documentos'])) {
    $solicitudId = $_POST['solicitud_id'];
    $uploadDir = '../../uploads/documentos/';
    
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $updates = [];
    $params = [];
    
    // Procesar archivos subidos
    $documentos = ['ine', 'curp', 'comprobante_domicilio'];
    foreach ($documentos as $doc) {
        if (isset($_FILES[$doc]) && $_FILES[$doc]['error'] === UPLOAD_ERR_OK) {
            $fileName = time() . '_' . $doc . '_' . $_FILES[$doc]['name'];
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES[$doc]['tmp_name'], $uploadFile)) {
                $updates[] = "$doc = ?";
                $params[] = $fileName;
            }
        }
    }
    
    if (!empty($updates)) {
        $params[] = $solicitudId;
        $params[] = $userId;
        $updateQuery = "UPDATE solicitudes SET " . implode(', ', $updates) . " WHERE id = ? AND usuario_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->execute($params);
        
        // Recargar la página para mostrar los cambios
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de Solicitudes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dropdown-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .dropdown-content.show {
            max-height: 500px;
        }
        .estado-no-revisado { background-color: #dc2626; color: white; }
        .estado-en-proceso { background-color: #fb923c; color: white; }
        .estado-revisado { background-color: #22c55e; color: white; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <?php include("components/sidebar.php"); ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 ml-64">
            <h1 class="text-3xl font-bold text-[#6B1024] mb-6">Seguimiento de Solicitudes</h1>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <!-- Menú desplegable -->
                <div class="relative mb-6">
                    <button id="dropdownButton" class="w-full bg-[#6B1024] text-white px-4 py-2 rounded-lg flex items-center justify-between">
                        <span>Mis Solicitudes</span>
                        <svg class="w-4 h-4 ml-2 transform transition-transform duration-200" id="dropdownArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div id="dropdownContent" class="dropdown-content mt-2 bg-white border rounded-lg shadow-lg z-10">
                        <?php if (!empty($solicitudes)): ?>
                            <?php foreach ($solicitudes as $solicitud): ?>
                                <div class="p-4 hover:bg-gray-50 border-b cursor-pointer" 
                                     onclick="mostrarDetalles(<?php echo htmlspecialchars(json_encode($solicitud)); ?>)">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-[#6B1024] text-white rounded-full w-10 h-10 flex items-center justify-center">
                                                #<?php echo htmlspecialchars($solicitud['id_solicitud']); ?>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800"><?php echo htmlspecialchars($solicitud['descripcion']); ?></p>
                                                <p class="text-sm text-gray-500"><?php echo date('d/m/Y', strtotime($solicitud['fecha_solicitud'])); ?></p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="px-3 py-1 text-sm rounded-full <?php 
                                                switch($solicitud['estado']) {
                                                    case 'pendiente':
                                                        echo 'bg-yellow-100 text-yellow-800';
                                                        break;
                                                    case 'en_proceso':
                                                        echo 'bg-blue-100 text-blue-800';
                                                        break;
                                                    case 'completada':
                                                        echo 'bg-green-100 text-green-800';
                                                        break;
                                                    case 'rechazada':
                                                        echo 'bg-red-100 text-red-800';
                                                        break;
                                                    default:
                                                        echo 'bg-gray-100 text-gray-800';
                                                }
                                                ?>">
                                                <?php echo htmlspecialchars(ucfirst($solicitud['estado'])); ?>
                                            </span>
                                            <?php if (!empty($solicitud['departamento_nombre'])): ?>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    Enviada a: <?php echo htmlspecialchars($solicitud['departamento_nombre'] . ' ' . $solicitud['departamento_apellido']); ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($solicitud['estado_envio'])): ?>
                                                <div class="text-xs mt-1">
                                                    <span class="px-2 py-1 rounded <?php
                                                        switch($solicitud['estado_envio']) {
                                                            case 'pendiente':
                                                                echo 'bg-yellow-200 text-yellow-800';
                                                                break;
                                                            case 'en_revision':
                                                                echo 'bg-blue-200 text-blue-800';
                                                                break;
                                                            case 'autorizada':
                                                                echo 'bg-green-200 text-green-800';
                                                                break;
                                                            case 'rechazada':
                                                                echo 'bg-red-200 text-red-800';
                                                                break;
                                                        }
                                                    ?>">
                                                        <?php echo htmlspecialchars(ucfirst($solicitud['estado_envio'])); ?>
                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-4 text-center text-gray-600">
                                No tienes solicitudes registradas
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Contenedor para mostrar detalles de la solicitud -->
                <div id="detallesSolicitud" class="hidden">
                    <!-- Los detalles se llenarán con JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownContent = document.getElementById('dropdownContent');
        const dropdownArrow = document.getElementById('dropdownArrow');
        let isOpen = false;
        let solicitudActual = null;
        
        dropdownButton.addEventListener('click', () => {
            isOpen = !isOpen;
            dropdownContent.classList.toggle('show');
            dropdownArrow.style.transform = isOpen ? 'rotate(180deg)' : '';
        });

        // Cerrar dropdown cuando se hace clic fuera
        document.addEventListener('click', (e) => {
            if (!dropdownButton.contains(e.target) && !dropdownContent.contains(e.target)) {
                dropdownContent.classList.remove('show');
                dropdownArrow.style.transform = '';
                isOpen = false;
            }
        });

        function mostrarDetalles(solicitud) {
            solicitudActual = solicitud;
            const detallesContainer = document.getElementById('detallesSolicitud');
            detallesContainer.classList.remove('hidden');
            
            // Cerrar el dropdown
            dropdownContent.classList.remove('show');
            dropdownArrow.style.transform = '';
            isOpen = false;
            
            detallesContainer.innerHTML = `
                <!-- Información del ciudadano -->
                <div class="border rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-bold text-center mb-4">INFORMACIÓN DEL CIUDADANO</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <input type="text" value="${solicitud.nombre || ''}" class="border rounded px-3 py-2" readonly placeholder="Nombre">
                        <input type="text" value="${solicitud.apellido || ''}" class="border rounded px-3 py-2" readonly placeholder="Apellido">
                        <input type="text" value="${solicitud.contacto_1 || ''}" class="border rounded px-3 py-2" readonly placeholder="Teléfono">
                        <input type="text" value="${solicitud.contacto_2 || ''}" class="border rounded px-3 py-2" readonly placeholder="Teléfono 2">
                    </div>
                </div>

                <!-- Tabla de seguimiento -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-center mb-4">SEGUIMIENTO DEL ESTATUS DE LA DOCUMENTACIÓN</h3>
                    <button onclick="abrirPDF(${solicitud.id_solicitud})" class="bg-[#6B1024] text-white px-4 py-2 rounded mb-4 float-right">
                        REGRESAR
                    </button>
                    <div class="clear-both"></div>
                    <table class="w-full border-collapse border">
                        <thead>
                            <tr class="bg-[#6B1024] text-white">
                                <th class="border p-2">DOCUMENTO</th>
                                <th class="border p-2">FORMATO</th>
                                <th class="border p-2">VISUALIZAR</th>
                                <th class="border p-2">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td class="border p-2">SOLICITUD</td>
                                <td class="border p-2">PDF</td>
                                <td class="border p-2">
                                    <button onclick="generarPDFSolicitud(${solicitud.id_solicitud})" class="bg-[#6B1024] text-white px-3 py-1 rounded text-sm">
                                        ABRIR DOCUMENTO
                                    </button>
                                </td>
                                <td class="border p-2">
                                    <span class="inline-block px-3 py-1 rounded estado-revisado">REVISADO</span>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td class="border p-2">INE</td>
                                <td class="border p-2">PDF</td>
                                <td class="border p-2">
                                    ${solicitud.ine ? 
                                        `<button onclick="abrirDocumento('${solicitud.ine}')" class="bg-[#6B1024] text-white px-3 py-1 rounded text-sm">ABRIR DOCUMENTO</button>` : 
                                        '<span class="text-gray-500">Sin documento</span>'}
                                </td>
                                <td class="border p-2">
                                    <span class="inline-block px-3 py-1 rounded ${solicitud.ine ? 'estado-en-proceso' : 'estado-no-revisado'}">
                                        ${solicitud.ine ? 'EN PROCESO' : 'NO REVISADO'}
                                    </span>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td class="border p-2">CURP</td>
                                <td class="border p-2">PDF</td>
                                <td class="border p-2">
                                    ${solicitud.curp ? 
                                        `<button onclick="abrirDocumento('${solicitud.curp}')" class="bg-[#6B1024] text-white px-3 py-1 rounded text-sm">ABRIR DOCUMENTO</button>` : 
                                        '<span class="text-gray-500">Sin documento</span>'}
                                </td>
                                <td class="border p-2">
                                    <span class="inline-block px-3 py-1 rounded ${solicitud.curp ? 'estado-en-proceso' : 'estado-no-revisado'}">
                                        ${solicitud.curp ? 'EN PROCESO' : 'NO REVISADO'}
                                    </span>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td class="border p-2">COMPROBANTE DE DOMICILIO</td>
                                <td class="border p-2">PDF</td>
                                <td class="border p-2">
                                    ${solicitud.comprobante_domicilio ? 
                                        `<button onclick="abrirDocumento('${solicitud.comprobante_domicilio}')" class="bg-[#6B1024] text-white px-3 py-1 rounded text-sm">ABRIR DOCUMENTO</button>` : 
                                        '<span class="text-gray-500">Sin documento</span>'}
                                </td>
                                <td class="border p-2">
                                    <span class="inline-block px-3 py-1 rounded ${solicitud.comprobante_domicilio ? 'estado-revisado' : 'estado-no-revisado'}">
                                        ${solicitud.comprobante_domicilio ? 'REVISADO' : 'NO REVISADO'}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Información adicional si fue enviada a departamento -->
                ${solicitud.departamento_nombre ? `
                    <div class="mt-6 border rounded-lg p-4 bg-gray-50">
                        <h3 class="text-lg font-bold mb-3">INFORMACIÓN DEL PROCESO</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Departamento asignado:</p>
                                <p class="text-sm">${solicitud.departamento_nombre} ${solicitud.departamento_apellido || ''}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Estado del proceso:</p>
                                <p class="text-sm">${solicitud.estado_envio ? getEstadoEnvioTexto(solicitud.estado_envio) : 'No enviada'}</p>
                            </div>
                        </div>
                        ${solicitud.respuesta_departamento ? `
                            <div class="mt-3">
                                <p class="text-sm font-medium text-gray-600">Respuesta del departamento:</p>
                                <p class="text-sm bg-white p-2 rounded border">${solicitud.respuesta_departamento}</p>
                            </div>
                        ` : ''}
                        ${solicitud.fecha_respuesta ? `
                            <div class="mt-2">
                                <p class="text-xs text-gray-500">Fecha de respuesta: ${new Date(solicitud.fecha_respuesta).toLocaleString()}</p>
                            </div>
                        ` : ''}
                    </div>
                ` : ''}
                
                <!-- Información de actualización -->
                <div class="mt-4 text-xs text-gray-500 text-center">
                    Última actualización: ${new Date(solicitud.fecha_actualizacion || solicitud.fecha_solicitud).toLocaleString()}
                </div>

                <!-- Formulario para subir documentos -->
                <form method="POST" enctype="multipart/form-data" class="mt-6 border rounded-lg p-4">
                    <h3 class="text-lg font-bold mb-4">Adjuntar Documentos</h3>
                    <input type="hidden" name="solicitud_id" value="${solicitud.id_solicitud}">
                    <input type="hidden" name="actualizar_documentos" value="1">
                    
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">INE:</label>
                            <input type="file" name="ine" accept=".pdf,.jpg,.jpeg,.png" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">CURP:</label>
                            <input type="file" name="curp" accept=".pdf,.jpg,.jpeg,.png" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Comprobante de Domicilio:</label>
                            <input type="file" name="comprobante_domicilio" accept=".pdf,.jpg,.jpeg,.png" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>
                    
                    <button type="submit" class="bg-[#6B1024] text-white px-6 py-2 rounded hover:bg-[#8B1034] transition">
                        Enviar
                    </button>
                </form>
            `;
        }

        function abrirDocumento(nombreArchivo) {
            window.open(`../../uploads/documentos/${nombreArchivo}`, '_blank');
        }

        function generarPDFSolicitud(solicitudId) {
            // Aquí puedes implementar la generación del PDF o abrir un PDF existente
            window.open(`generar_pdf_solicitud.php?id=${solicitudId}`, '_blank');
        }

        function abrirPDF(solicitudId) {
            // Función para el botón regresar - puedes implementar lo que necesites aquí
            location.reload();
        }

        function getEstadoEnvioTexto(estado) {
            const estados = {
                'pendiente': 'Pendiente de revisión',
                'en_revision': 'En revisión',
                'autorizada': '✅ Autorizada',
                'rechazada': '❌ Rechazada'
            };
            return estados[estado] || estado;
        }
    </script>
</body>
</html>
