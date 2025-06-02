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
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, fecha_nacimiento, genero, genero_personalizado, contacto, contrasena, rol_user) VALUES (?, ?, ?, ?, ?, ?, ?, 'presidencia')");
                // Para presidencia usar contraseña hasheada por seguridad (nivel intermedio)
                $hashedPassword = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
                $stmt->execute([
                    $_POST['nombre'],
                    $_POST['apellido'], 
                    $_POST['fecha_nacimiento'],
                    $_POST['genero'],
                    $_POST['genero_personalizado'] ?: null,
                    $_POST['contacto'],
                    $hashedPassword
                ]);
                $mensaje = 'Usuario de presidencia creado exitosamente';
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
                    $sql = "UPDATE usuarios SET " . implode(', ', $updateFields) . " WHERE id = ? AND rol_user = 'presidencia'";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($params);
                    $mensaje = 'Usuario de presidencia actualizado exitosamente';
                    $tipo_mensaje = 'success';
                }
                break;
                
            case 'delete':
                $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ? AND rol_user = 'presidencia'");
                $stmt->execute([$_POST['user_id']]);
                $mensaje = 'Usuario de presidencia eliminado exitosamente';
                $tipo_mensaje = 'success';
                break;
        }
    } catch (Exception $e) {
        $mensaje = 'Error: ' . $e->getMessage();
        $tipo_mensaje = 'error';
    }
}

// Obtener lista de usuarios de presidencia
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM usuarios WHERE rol_user = 'presidencia'";
if ($search) {
    $sql .= " AND (nombre LIKE ? OR apellido LIKE ? OR contacto LIKE ?)";
    $stmt = $pdo->prepare($sql);
    $searchTerm = "%$search%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
} else {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}
$presidencia = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Presidencia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <?php include 'components/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 ml-64 overflow-y-auto">
            <div class="welcome-message">
                <h1 class="text-3xl font-bold text-[#6B1024] mb-4">Gestión de Presidencia</h1>
                <p class="text-gray-600">Administrar usuarios y permisos del área de presidencia municipal</p>
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
                        <h2 class="text-2xl font-bold text-[#6B1024]">Lista de Usuarios de Presidencia</h2>
                        <p class="text-gray-600">Total: <?php echo count($presidencia); ?> usuarios de presidencia registrados</p>
                    </div>
                    <button onclick="showCreateForm()" class="px-4 py-2 bg-[#6B1024] text-white rounded-lg hover:bg-[#8B223A] transition-colors">
                        Agregar Usuario de Presidencia
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

                <!-- Tabla de usuarios de presidencia -->
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
                            <?php if (empty($presidencia)): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        <?php echo $search ? 'No se encontraron usuarios con ese criterio de búsqueda' : 'No hay usuarios de presidencia registrados'; ?>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($presidencia as $presidente): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium"><?php echo $presidente['id']; ?></td>
                                        <td class="px-6 py-4">
                                            <?php echo htmlspecialchars($presidente['nombre'] . ' ' . $presidente['apellido']); ?>
                                        </td>
                                        <td class="px-6 py-4"><?php echo htmlspecialchars($presidente['contacto']); ?></td>
                                        <td class="px-6 py-4"><?php echo $presidente['fecha_nacimiento']; ?></td>
                                        <td class="px-6 py-4">
                                            <?php 
                                            echo htmlspecialchars(
                                                $presidente['genero'] === 'otro' && $presidente['genero_personalizado'] 
                                                ? $presidente['genero_personalizado'] 
                                                : ucfirst($presidente['genero'])
                                            ); 
                                            ?>
                                        </td>
                                        <td class="px-6 py-4"><?php echo date('d/m/Y', strtotime($presidente['fecha_registro'])); ?></td>
                                        <td class="px-6 py-4 text-center">
                                            <button onclick="showEditForm(<?php echo htmlspecialchars(json_encode($presidente)); ?>)" 
                                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors mr-2">
                                                Editar
                                            </button>
                                            <button onclick="showDeleteForm(<?php echo $presidente['id']; ?>, '<?php echo htmlspecialchars($presidente['nombre'] . ' ' . $presidente['apellido']); ?>')" 
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

                <!-- Información adicional -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Información sobre Presidencia</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>• Los usuarios de presidencia tienen acceso a funciones ejecutivas del municipio.</p>
                                <p>• Las contraseñas se almacenan de forma segura (hasheadas).</p>
                                <p>• Estos usuarios pueden tomar decisiones de alto nivel en el sistema.</p>
                                <p>• Recomendado para alcaldes, vicealcaldes y secretarios municipales.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas rápidas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-[#6B1024] mb-2">Total Usuarios</h3>
                        <p class="text-3xl font-bold text-[#6B1024]"><?php echo count($presidencia); ?></p>
                        <p class="text-gray-600 text-sm">Usuarios de presidencia</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-[#6B1024] mb-2">Registros Recientes</h3>
                        <p class="text-3xl font-bold text-[#6B1024]">
                            <?php 
                            $recent = array_filter($presidencia, function($user) {
                                return strtotime($user['fecha_registro']) > strtotime('-30 days');
                            });
                            echo count($recent);
                            ?>
                        </p>
                        <p class="text-gray-600 text-sm">Últimos 30 días</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-[#6B1024] mb-2">Estado del Sistema</h3>
                        <p class="text-3xl font-bold text-green-600">✓</p>
                        <p class="text-gray-600 text-sm">Funcionando correctamente</p>
                    </div>
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
                <h2 class="text-2xl font-bold text-[#6B1024] mb-6">Agregar Usuario de Presidencia</h2>
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
                    
                    <input type="email" name="contacto" placeholder="Email oficial de presidencia" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    
                    <input type="password" name="contrasena" placeholder="Contraseña segura" required minlength="8"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-blue-800 text-sm">🏛️ Este usuario tendrá acceso a funciones ejecutivas municipales</p>
                    </div>
                    
                    <div class="flex space-x-4 pt-4">
                        <button type="button" onclick="closeModal()" 
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-[#6B1024] text-white rounded-lg hover:bg-[#8B223A] transition-colors">
                            Crear Usuario
                        </button>
                    </div>
                </form>
            `;
            
            modal.classList.remove('hidden');
        }

        function showEditForm(presidente) {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.innerHTML = `
                <h2 class="text-2xl font-bold text-[#6B1024] mb-6">Editar Usuario de Presidencia</h2>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="user_id" value="${presidente.id}">
                    
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="nombre" value="${presidente.nombre}" placeholder="Nombre"
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                        <input type="text" name="apellido" value="${presidente.apellido}" placeholder="Apellido"
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    </div>
                    
                    <input type="email" name="contacto" value="${presidente.contacto}" placeholder="Email oficial de presidencia"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    
                    <input type="password" name="contrasena" placeholder="Nueva contraseña (dejar vacío para mantener la actual)" minlength="8"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                    
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <p class="text-yellow-800 text-sm">💡 Deja la contraseña vacía si no quieres cambiarla</p>
                    </div>
                    
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
                <h2 class="text-2xl font-bold text-red-600 mb-6">Eliminar Usuario de Presidencia</h2>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="user_id" value="${id}">
                    
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-red-800">¿Estás seguro de que deseas eliminar a <strong>${nombre}</strong> del área de presidencia?</p>
                        <p class="text-red-600 text-sm mt-2">⚠️ Esta acción eliminará permanentemente:</p>
                        <ul class="text-red-600 text-sm mt-1 ml-4 list-disc">
                            <li>La cuenta del usuario de presidencia</li>
                            <li>Todos sus permisos ejecutivos</li>
                            <li>Su acceso a funciones de alto nivel</li>
                        </ul>
                        <p class="text-red-700 font-semibold text-sm mt-2">Esta acción NO se puede deshacer.</p>
                    </div>
                    
                    <div class="flex space-x-4 pt-4">
                        <button type="button" onclick="closeModal()" 
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Eliminar Definitivamente
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