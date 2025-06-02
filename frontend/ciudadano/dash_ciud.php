<?php
require_once '../../backend/auth.php';
checkRole('ciudadano');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Ciudadano</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-[#6B1024] text-white w-64 flex-shrink-0 fixed h-screen overflow-y-hidden">
            <div class="p-4">
                <h2 class="text-2xl font-semibold">Panel Ciudadano</h2>
            </div>
            <nav class="mt-6">
                <div class="px-4 py-3">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Inicio</span>
                    </div>
                </div>
                <a href="#" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Mis Trámites</span>
                    </div>
                </a>
                <a href="#" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Calendario</span>
                    </div>
                </a>
                <a href="#" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Mi Perfil</span>
                    </div>
                </a>
            </nav>
            <div class="absolute bottom-0 w-64 p-4">
                <a href="../../backend/logout.php" class="block w-full px-4 py-2 text-center bg-[#8B223A] hover:bg-[#9B324A] rounded-lg transition-colors duration-200">
                    Cerrar Sesión
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8 ml-64 overflow-y-auto">
            <div class="welcome-message">
                <h1 class="text-3xl font-bold text-[#6B1024] mb-4">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h1>
                <p class="text-gray-600">Panel de Control Ciudadano</p>
            </div>
            
            <!-- Main Options -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Registrar Solicitud Card -->
                <a href="registrar_sol.php" class="block group">
                    <div class="bg-white p-6 rounded-lg shadow-md border-2 border-transparent hover:border-[#6B1024] transition-all duration-300">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-24 h-24 mb-4 text-[#6B1024]">
                                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-[#6B1024] mb-2">REGISTRAR SOLICITUD</h3>
                            <p class="text-gray-600">En este apartado deberás adjuntar tu solicitud o describirla.</p>
                        </div>
                    </div>
                </a>

                <!-- Seguimiento de Solicitud Card -->
                <a href="regimiento_sol.php" class="block group">
                    <div class="bg-white p-6 rounded-lg shadow-md border-2 border-transparent hover:border-[#6B1024] transition-all duration-300">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-24 h-24 mb-4 text-[#6B1024]">
                                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-[#6B1024] mb-2">SEGUIMIENTO DE SOLICITUD</h3>
                            <p class="text-gray-600">En este apartado podrás ver el estatus de tu solicitud así como subir algunos documentos que se te soliciten.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Status Cards -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-2">Trámites Activos</h3>
                    <p class="text-gray-600">0 trámites en proceso</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-2">Próximas Citas</h3>
                    <p class="text-gray-600">No hay citas programadas</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-2">Notificaciones</h3>
                    <p class="text-gray-600">No hay notificaciones nuevas</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>