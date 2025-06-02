<?php
require_once '../../backend/auth.php';
require_once '../../backend/db.php';
checkRole('ciudadano');

// Obtener datos completos del usuario desde la base de datos
$stmt = $pdo->prepare("SELECT nombre, apellido, contacto FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$usuario = $stmt->fetch();

// Asignar valores a las variables
$usuario_nombre = $usuario['nombre'] ?? '';
$usuario_apellido = $usuario['apellido'] ?? '';
$usuario_contacto = $usuario['contacto'] ?? '';

// Incluir el procesamiento de la solicitud
require_once 'procesar_solicitud.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Solicitud</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Incluir Sidebar -->
        <?php include 'components/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 ml-64 overflow-y-auto">
            <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-[#6B1024] mb-8 text-center">Registrar Nueva Solicitud</h2>
                
                <?php if (isset($mensaje)): ?>
                    <div class="mb-4 p-4 rounded <?php echo $tipo_mensaje === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                        <?php echo htmlspecialchars($mensaje); ?>
                    </div>
                <?php endif; ?>

                <form class="space-y-6" method="POST" enctype="multipart/form-data">
                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" id="nombre" name="nombre" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="<?php echo htmlspecialchars($usuario_nombre); ?>" readonly>
                    </div>

                    <!-- Apellido -->
                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                        <input type="text" id="apellido" name="apellido" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="<?php echo htmlspecialchars($usuario_apellido); ?>" readonly>
                    </div>

                    <!-- Contacto Principal -->
                    <div>
                        <label for="contacto1" class="block text-sm font-medium text-gray-700">Contacto Principal</label>
                        <input type="text" id="contacto1" name="contacto1" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="<?php echo htmlspecialchars($usuario_contacto); ?>" readonly>
                    </div>

                    <!-- Contacto Secundario -->
                    <div>
                        <label for="contacto2" class="block text-sm font-medium text-gray-700">Contacto Secundario</label>
                        <input type="text" id="contacto2" name="contacto2" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Ingrese un contacto secundario">
                    </div>

                    <!-- Descripción de la Solicitud -->
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción de la Solicitud</label>
                        <textarea id="descripcion" name="descripcion" rows="4" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Describa su solicitud aquí" required></textarea>
                    </div>

                    <!-- Documento Adicional -->
                    <div>
                        <label for="documento" class="block text-sm font-medium text-gray-700">Documento Adicional (Opcional)</label>
                        <input type="file" id="documento" name="documento" 
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#6B1024] file:text-white hover:file:bg-[#8B223A]"
                               accept=".pdf,.doc,.docx">
                    </div>

                    <!-- Imagen Adicional -->
                    <div>
                        <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen Adicional (Opcional)</label>
                        <input type="file" id="imagen" name="imagen" 
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#6B1024] file:text-white hover:file:bg-[#8B223A]"
                               accept="image/*">
                    </div>

                    <!-- Botón Enviar -->
                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#6B1024] hover:bg-[#8B223A] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6B1024]">
                            Enviar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
