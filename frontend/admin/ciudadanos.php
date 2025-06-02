<?php
require_once '../../backend/auth.php';
require_once '../../backend/db.php';
checkRole('admin');

// Procesar acciones CRUD
$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        switch ($_POST['action']) {
            case 'create':
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, fecha_nacimiento, genero, genero_personalizado, contacto, contrasena, rol_user) VALUES (?, ?, ?, ?, ?, ?, ?, 'ciudadano')");
                $contrasena_hash = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
                $stmt->execute([
                    $_POST['nombre'],
                    $_POST['apellido'], 
                    $_POST['fecha_nacimiento'],
                    $_POST['genero'],
                    $_POST['genero_personalizado'] ?: null,
                    $_POST['contacto'],
                    $contrasena_hash
                ]);
                $mensaje = 'Ciudadano creado exitosamente';
                $tipo_mensaje = 'success';
                break;
                
            case 'update':
                $updateFields = [];
                $params = [];
                
                if (!empty($_POST['nombre'])) {
                    $updateFields[] = "nombre = ?";
                    $params[] = $_POST['nombre'];
                }
                if (!empty($_POST['apellido'])) {
                    $updateFields[] = "apellido = ?";
                    $params[] = $_POST['apellido'];
                }
                if (!empty($_POST['contacto'])) {
                    $updateFields[] = "contacto = ?";
                    $params[] = $_POST['contacto'];
                }
                if (!empty($_POST['contrasena'])) {
                    $updateFields[] = "contrasena = ?";
                    $params[] = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
                }
                
                if (!empty($updateFields)) {
                    $params[] = $_POST['user_id'];
                    $sql = "UPDATE usuarios SET " . implode(', ', $updateFields) . " WHERE id = ? AND rol_user = 'ciudadano'";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($params);
                    $mensaje = 'Ciudadano actualizado exitosamente';
                    $tipo_mensaje = 'success';
                }
                break;
                
            case 'delete':
                $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ? AND rol_user = 'ciudadano'");
                $stmt->execute([$_POST['user_id']]);
                $mensaje = 'Ciudadano eliminado exitosamente';
                $tipo_mensaje = 'success';
                break;
        }
    } catch (Exception $e) {
        $mensaje = 'Error: ' . $e->getMessage();
        $tipo_mensaje = 'error';
    }
}

// Obtener lista de ciudadanos
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM usuarios WHERE rol_user = 'ciudadano'";
if ($search) {
    $sql .= " AND (nombre LIKE ? OR apellido LIKE ? OR contacto LIKE ?)";
    $stmt = $pdo->prepare($sql);
    $searchTerm = "%$search%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
} else {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}
$ciudadanos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ciudadanos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <?php include 'components/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 ml-64 overflow-y-auto">
            <div class="welcome-message">
                <h1 class="text-3xl font-bold text-[#6B1024] mb-4">Gestión de Ciudadanos</h1>
                <p class="text-gray-600">Administrar cuentas y perfiles de ciudadanos registrados</p>
            </div>

            <!-- Mensajes -->
            <?php if ($mensaje): ?>
                <div class="mt-4 p-4 rounded-lg <?php echo $tipo_mensaje === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <div class="mt-8 space-y-6">
                <!-- Header con botones de acción -->
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-[#6B1024]">Lista de Ciudadanos</h2>
                        <p class="text-gray-600">Total: <?php echo count($ciudadanos); ?> ciudadanos registrados</p>
                    </div>
                    <button onclick="showCreateForm()" class="px-4 py-2 bg-[#6B1024] text-white rounded-lg hover:bg-[#8B223A] transition-colors">
                        Agregar Ciudadano
                    </button>
                </div>

                <!-- Búsqueda -->
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <form method="GET" class="flex gap-4">
                        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                               placeholder="Buscar por nombre, apellido o contacto..." 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                        <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            Buscar
                        </button>
                        <?php if ($search): ?>
                            <a href="?" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                                Limpiar
                            </a>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Tabla de ciudadanos -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-[#6B1024] text-white">
                            <tr>
                                <th class="px-6 py-3 text-left">ID</th>
                                <th class="px-6 py-3 text-left">Nombre Completo</th>
                                <th class="px-6 py-3 text-left">Contacto</th>
                                <th class="px-6 py-3 text-left">Fecha Nacimiento</th>
                                <th class="px-6 py-3 text-left">Género</th>
                                <th class="px-6 py-3 text-left">Fecha Registro</th>
                                <th class="px-6 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if (empty($ciudadanos)): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        <?php echo $search ? 'No se encontraron ciudadanos con ese criterio de búsqueda' : 'No hay ciudadanos registrados'; ?>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($ciudadanos as $ciudadano): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium"><?php echo $ciudadano['id']; ?></td>
                                        <td class="px-6 py-4">
                                            <?php echo htmlspecialchars($ciudadano['nombre'] . ' ' . $ciudadano['apellido']); ?>
                                        </td>
                                        <td class="px-6 py-4"><?php echo htmlspecialchars($ciudadano['contacto']); ?></td>
                                        <td class="px-6 py-4"><?php echo $ciudadano['fecha_nacimiento']; ?></td>
                                        <td class="px-6 py-4">
                                            <?php 
                                            echo htmlspecialchars(
                                                $ciudadano['genero'] === 'otro' && $ciudadano['genero_personalizado'] 
                                                ? $ciudadano['genero_personalizado'] 
                                                : ucfirst($ciudadano['genero'])
                                            ); 
                                            ?>
                                        </td>
                                        <td class="px-6 py-4"><?php echo date('d/m/Y', strtotime($ciudadano['fecha_registro'])); ?></td>
                                        <td class="px-6 py-4 text-center">
                                            <button onclick="showEditForm(<?php echo htmlspecialchars(json_encode($ciudadano)); ?>)" 
                                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors mr-2">
                                                Editar
                                            </button>
                                            <button onclick="showDeleteForm(<?php echo $ciudadano['id']; ?>, '<?php echo htmlspecialchars($ciudadano['nombre'] . ' ' . $ciudadano['apellido']); ?>')" 
                                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para formularios -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full mx-4">
            <div id="modalContent">
                <!-- El contenido se carga dinámicamente -->
            </div>
        </div>
    </div>

    <script>
        function showCreateForm() {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.innerHTML = `
                <h2 class="text-2xl font-bold text-[#6B1024] mb-6">Agregar Ciudadano</h2>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="nombre" placeholder="Nombre" required
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                        <input type="text" name="apellido" placeholder="Apellido" required
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    </div>
                    
                    <input type="date" name="fecha_nacimiento" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    
                    <select name="genero" required onchange="toggleGeneroPersonalizado(this)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                        <option value="">Seleccionar género</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">Otro</option>
                    </select>
                    
                    <input type="text" name="genero_personalizado" id="generoPersonalizado" placeholder="Especificar género" style="display: none;"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    
                    <input type="text" name="contacto" placeholder="Email o teléfono" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    
                    <input type="password" name="contrasena" placeholder="Contraseña" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    
                    <div class="flex space-x-4 pt-4">
                        <button type="button" onclick="closeModal()" 
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-[#6B1024] text-white rounded-lg hover:bg-[#8B223A] transition-colors">
                            Guardar
                        </button>
                    </div>
                </form>
            `;
            
            modal.classList.remove('hidden');
        }

        function showEditForm(ciudadano) {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.innerHTML = `
                <h2 class="text-2xl font-bold text-[#6B1024] mb-6">Editar Ciudadano</h2>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="user_id" value="${ciudadano.id}">
                    
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="nombre" value="${ciudadano.nombre}" placeholder="Nombre"
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                        <input type="text" name="apellido" value="${ciudadano.apellido}" placeholder="Apellido"
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    </div>
                    
                    <input type="text" name="contacto" value="${ciudadano.contacto}" placeholder="Email o teléfono"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    
                    <input type="password" name="contrasena" placeholder="Nueva contraseña (dejar vacío para mantener la actual)"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    
                    <div class="flex space-x-4 pt-4">
                        <button type="button" onclick="closeModal()" 
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Actualizar
                        </button>
                    </div>
                </form>
            `;
            
            modal.classList.remove('hidden');
        }

        function showDeleteForm(id, nombre) {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.innerHTML = `
                <h2 class="text-2xl font-bold text-red-600 mb-6">Eliminar Ciudadano</h2>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="user_id" value="${id}">
                    
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-red-800">¿Estás seguro de que deseas eliminar a <strong>${nombre}</strong>?</p>
                        <p class="text-red-600 text-sm mt-2">Esta acción no se puede deshacer.</p>
                    </div>
                    
                    <div class="flex space-x-4 pt-4">
                        <button type="button" onclick="closeModal()" 
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Eliminar
                        </button>
                    </div>
                </form>
            `;
            
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        function toggleGeneroPersonalizado(select) {
            const generoPersonalizado = document.getElementById('generoPersonalizado');
            if (select.value === 'otro') {
                generoPersonalizado.style.display = 'block';
                generoPersonalizado.required = true;
            } else {
                generoPersonalizado.style.display = 'none';
                generoPersonalizado.required = false;
                generoPersonalizado.value = '';
            }
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('modal').onclick = function(e) {
            if (e.target === this) {
                closeModal();
            }
        }
    </script>
</body>
</html> 