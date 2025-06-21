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
                <a href="#" onclick="mostrarSeccion('dashboard')" id="btn-inicio" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Inicio</span>
                    </div>
                </a>
                <a href="#" onclick="mostrarSeccion('tramites')" id="btn-tramites" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Mis Trámites</span>
                    </div>
                </a>
                <a href="#" onclick="mostrarSeccion('calendario')" id="btn-calendario" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Calendario</span>
                    </div>
                </a>
                <a href="#" onclick="mostrarSeccion('perfil')" id="btn-perfil" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Mi Perfil</span>
                    </div>
                </a>
                <a href="#" onclick="mostrarCambioContrasena()" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-6.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        <span>Cambiar Contraseña</span>
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
            <!-- Sección Dashboard (por defecto) -->
            <div id="seccion-dashboard">
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
                    <p class="text-gray-600" id="tramites-activos">Cargando...</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-2">Último Estado</h3>
                    <p class="text-gray-600" id="ultimo-estado">Cargando...</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md cursor-pointer hover:bg-gray-50 transition-colors" onclick="toggleNotificaciones()">
                    <h3 class="text-xl font-semibold mb-2 flex items-center justify-between">
                        Notificaciones
                        <span id="badge-notificaciones" class="hidden bg-red-500 text-white text-xs px-2 py-1 rounded-full">0</span>
                    </h3>
                    <p class="text-gray-600" id="resumen-notificaciones">Cargando...</p>
                </div>
            </div>

                <!-- Centro de Notificaciones -->
                <div id="centro-notificaciones" class="mt-8 bg-white rounded-lg shadow-md p-6 hidden">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-2xl font-bold text-[#6B1024]">Centro de Notificaciones</h3>
                        <button onclick="toggleNotificaciones()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="lista-notificaciones">
                        <!-- Las notificaciones se cargarán aquí -->
                    </div>
                </div>
            </div>

            <!-- Sección Mis Trámites -->
            <div id="seccion-tramites" class="hidden">
                <div class="welcome-message">
                    <h1 class="text-3xl font-bold text-[#6B1024] mb-4">Mis Trámites</h1>
                    <p class="text-gray-600">Gestiona y da seguimiento a tus solicitudes</p>
                </div>
                
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
            </div>

            <!-- Sección Calendario -->
            <div id="seccion-calendario" class="hidden">
                <div class="welcome-message">
                    <h1 class="text-3xl font-bold text-[#6B1024] mb-4">Calendario de Citas</h1>
                    <p class="text-gray-600">Programa y gestiona tus citas para trámites municipales</p>
                </div>
                
                <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Calendario -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold text-[#6B1024]">Calendario</h3>
                                <div class="flex space-x-2">
                                    <button onclick="cambiarMes(-1)" class="p-2 hover:bg-gray-100 rounded">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </button>
                                    <button onclick="cambiarMes(1)" class="p-2 hover:bg-gray-100 rounded">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div id="calendario-container">
                                <!-- El calendario se generará aquí -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Panel de Citas -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-[#6B1024]">Mis Citas</h3>
                                <button onclick="mostrarFormularioCita()" class="bg-[#6B1024] text-white px-3 py-1 rounded text-sm hover:bg-[#8B223A]">
                                    Nueva Cita
                                </button>
                            </div>
                            <div id="lista-citas">
                                <!-- Las citas se cargarán aquí -->
                            </div>
                        </div>
                        
                        <!-- Próximas Citas -->
                        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                            <h3 class="text-lg font-bold text-[#6B1024] mb-4">Próximas Citas</h3>
                            <div id="proximas-citas">
                                <!-- Las próximas citas se cargarán aquí -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección Mi Perfil -->
            <div id="seccion-perfil" class="hidden">
                <div class="welcome-message">
                    <h1 class="text-3xl font-bold text-[#6B1024] mb-4">Mi Perfil</h1>
                    <p class="text-gray-600">Gestiona tu información personal y configuración de cuenta</p>
                </div>
                
                <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Información Personal -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold text-[#6B1024]">Información Personal</h3>
                                <button onclick="editarPerfil()" id="btn-editar-perfil" class="bg-[#6B1024] text-white px-4 py-2 rounded hover:bg-[#8B223A]">
                                    Editar
                                </button>
                            </div>
                            
                            <form id="form-perfil">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                                        <input type="text" id="perfil-nombre" disabled class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 disabled:bg-gray-50 disabled:text-gray-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Apellido</label>
                                        <input type="text" id="perfil-apellido" disabled class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 disabled:bg-gray-50 disabled:text-gray-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento</label>
                                        <input type="date" id="perfil-fecha-nacimiento" disabled class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 disabled:bg-gray-50 disabled:text-gray-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Género</label>
                                        <select id="perfil-genero" disabled class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 disabled:bg-gray-50 disabled:text-gray-500">
                                            <option value="masculino">Masculino</option>
                                            <option value="femenino">Femenino</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Contacto (Email/Teléfono)</label>
                                        <input type="text" id="perfil-contacto" disabled class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 disabled:bg-gray-50 disabled:text-gray-500">
                                    </div>
                                    <div id="perfil-genero-personalizado-container" class="md:col-span-2 hidden">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Especificar Género</label>
                                        <input type="text" id="perfil-genero-personalizado" disabled class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 disabled:bg-gray-50 disabled:text-gray-500">
                                    </div>
                                </div>
                                
                                <div id="perfil-botones" class="mt-6 flex space-x-4 hidden">
                                    <button type="submit" class="bg-[#6B1024] text-white px-6 py-2 rounded hover:bg-[#8B223A]">
                                        Guardar Cambios
                                    </button>
                                    <button type="button" onclick="cancelarEdicion()" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Panel de Estadísticas -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-bold text-[#6B1024] mb-4">Estadísticas de Cuenta</h3>
                            <div class="space-y-4">
                                <div class="border-b pb-4">
                                    <p class="text-sm text-gray-600">Solicitudes Enviadas</p>
                                    <p class="text-2xl font-bold text-[#6B1024]" id="stats-solicitudes">0</p>
                                </div>
                                <div class="border-b pb-4">
                                    <p class="text-sm text-gray-600">Trámites Completados</p>
                                    <p class="text-2xl font-bold text-green-600" id="stats-completados">0</p>
                                </div>
                                <div class="border-b pb-4">
                                    <p class="text-sm text-gray-600">Citas Programadas</p>
                                    <p class="text-2xl font-bold text-blue-600" id="stats-citas">0</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Fecha de Registro</p>
                                    <p class="text-sm font-medium text-gray-800" id="stats-registro">-</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Acciones Rápidas -->
                        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                            <h3 class="text-lg font-bold text-[#6B1024] mb-4">Acciones Rápidas</h3>
                            <div class="space-y-2">
                                <button onclick="mostrarCambioContrasena()" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded">
                                    🔒 Cambiar Contraseña
                                </button>
                                <button onclick="descargarDatos()" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded">
                                    📋 Descargar Mis Datos
                                </button>
                                <button onclick="mostrarPoliticasPrivacidad()" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded">
                                    📄 Políticas de Privacidad
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para nueva cita -->
    <div id="modal-nueva-cita" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-[#6B1024]">Nueva Cita</h3>
                <button onclick="cerrarModalCita()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="form-nueva-cita">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Trámite:</label>
                    <select name="tipo_tramite" required class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#6B1024] focus:border-[#6B1024]">
                        <option value="">Selecciona un trámite</option>
                        <option value="acta_nacimiento">Acta de Nacimiento</option>
                        <option value="licencia_construccion">Licencia de Construcción</option>
                        <option value="permiso_comercio">Permiso de Comercio</option>
                        <option value="certificado_residencia">Certificado de Residencia</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha:</label>
                    <input type="date" name="fecha" required min="" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#6B1024] focus:border-[#6B1024]">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hora:</label>
                    <select name="hora" required class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#6B1024] focus:border-[#6B1024]">
                        <option value="">Selecciona una hora</option>
                        <option value="09:00">09:00 AM</option>
                        <option value="10:00">10:00 AM</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="12:00">12:00 PM</option>
                        <option value="14:00">02:00 PM</option>
                        <option value="15:00">03:00 PM</option>
                        <option value="16:00">04:00 PM</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción (opcional):</label>
                    <textarea name="descripcion" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#6B1024] focus:border-[#6B1024]"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="cerrarModalCita()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-[#6B1024] text-white rounded-md hover:bg-[#8B223A]">Programar Cita</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para cambiar contraseña -->
    <div id="modal-cambio-contrasena" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-[#6B1024]">Cambiar Contraseña</h3>
                <button onclick="cerrarModalContrasena()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="form-cambio-contrasena">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña Actual:</label>
                    <input type="password" name="contrasena_actual" required class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#6B1024] focus:border-[#6B1024]">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña:</label>
                    <input type="password" name="contrasena_nueva" required minlength="6" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#6B1024] focus:border-[#6B1024]">
                    <p class="text-xs text-gray-500 mt-1">Mínimo 6 caracteres</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nueva Contraseña:</label>
                    <input type="password" name="confirmar_contrasena" required minlength="6" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#6B1024] focus:border-[#6B1024]">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="cerrarModalContrasena()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-[#6B1024] text-white rounded-md hover:bg-[#8B223A]">Cambiar Contraseña</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let notificacionesAbiertas = false;
        let fechaActual = new Date();
        let perfilEditando = false;

        // Cargar datos al iniciar la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarEstadisticas();
            cargarNotificaciones();
            configurarFechaMinima();
            
            // Actualizar cada 30 segundos
            setInterval(() => {
                cargarNotificaciones();
                cargarEstadisticas();
            }, 30000);
        });

        // === FUNCIONES DE NAVEGACIÓN ===
        function mostrarSeccion(seccion) {
            // Ocultar todas las secciones
            document.getElementById('seccion-dashboard').classList.add('hidden');
            document.getElementById('seccion-tramites').classList.add('hidden');
            document.getElementById('seccion-calendario').classList.add('hidden');
            document.getElementById('seccion-perfil').classList.add('hidden');
            
            // Quitar clase activa de todos los botones
            document.querySelectorAll('nav a').forEach(btn => {
                btn.classList.remove('bg-[#8B223A]');
            });
            
            // Mostrar la sección seleccionada
            if (seccion === 'tramites') {
                document.getElementById('seccion-tramites').classList.remove('hidden');
                document.getElementById('btn-tramites').classList.add('bg-[#8B223A]');
            } else if (seccion === 'calendario') {
                document.getElementById('seccion-calendario').classList.remove('hidden');
                document.getElementById('btn-calendario').classList.add('bg-[#8B223A]');
                generarCalendario();
                cargarCitas();
            } else if (seccion === 'perfil') {
                document.getElementById('seccion-perfil').classList.remove('hidden');
                document.getElementById('btn-perfil').classList.add('bg-[#8B223A]');
                cargarDatosPerfil();
                cargarEstadisticasPerfil();
            } else {
                // Dashboard (inicio)
                document.getElementById('seccion-dashboard').classList.remove('hidden');
                document.getElementById('btn-inicio').classList.add('bg-[#8B223A]');
            }
        }

        // === FUNCIONES DE CALENDARIO ===
        function generarCalendario() {
            const container = document.getElementById('calendario-container');
            const año = fechaActual.getFullYear();
            const mes = fechaActual.getMonth();
            
            // Encabezado del mes
            const nombreMes = new Intl.DateTimeFormat('es-ES', { month: 'long', year: 'numeric' }).format(fechaActual);
            
            let html = `
                <div class="text-center mb-4">
                    <h4 class="text-lg font-bold capitalize">${nombreMes}</h4>
                </div>
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Dom</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Lun</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Mar</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Mié</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Jue</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Vie</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Sáb</div>
                </div>
                <div class="grid grid-cols-7 gap-1">
            `;
            
            // Primer día del mes
            const primerDia = new Date(año, mes, 1);
            const ultimoDia = new Date(año, mes + 1, 0);
            const diasEnMes = ultimoDia.getDate();
            const diaSemanaInicio = primerDia.getDay();
            
            // Espacios vacíos para días anteriores
            for (let i = 0; i < diaSemanaInicio; i++) {
                html += '<div class="h-8"></div>';
            }
            
            // Días del mes
            for (let dia = 1; dia <= diasEnMes; dia++) {
                const fecha = new Date(año, mes, dia);
                const hoy = new Date();
                const esHoy = fecha.toDateString() === hoy.toDateString();
                const esPasado = fecha < hoy;
                
                html += `
                    <div class="h-8 flex items-center justify-center text-sm cursor-pointer rounded
                        ${esHoy ? 'bg-[#6B1024] text-white font-bold' : 
                          esPasado ? 'text-gray-400' : 'hover:bg-gray-100'}"
                        ${!esPasado ? `onclick="seleccionarFecha('${fecha.toISOString().split('T')[0]}')"` : ''}>
                        ${dia}
                    </div>
                `;
            }
            
            html += '</div>';
            container.innerHTML = html;
        }

        function cambiarMes(direccion) {
            fechaActual.setMonth(fechaActual.getMonth() + direccion);
            generarCalendario();
        }

        function seleccionarFecha(fecha) {
            // Pre-llenar la fecha en el formulario de nueva cita
            mostrarFormularioCita();
            document.querySelector('#form-nueva-cita input[name="fecha"]').value = fecha;
        }

        function configurarFechaMinima() {
            const hoy = new Date().toISOString().split('T')[0];
            const inputFecha = document.querySelector('#form-nueva-cita input[name="fecha"]');
            if (inputFecha) {
                inputFecha.min = hoy;
            }
        }

        function mostrarFormularioCita() {
            document.getElementById('modal-nueva-cita').classList.remove('hidden');
        }

        function cerrarModalCita() {
            document.getElementById('modal-nueva-cita').classList.add('hidden');
            document.getElementById('form-nueva-cita').reset();
        }

        async function cargarCitas() {
            try {
                // Simulación de citas (en un futuro conectar con backend)
                const citasEjemplo = [
                    {
                        id: 1,
                        tipo: 'Acta de Nacimiento',
                        fecha: '2024-12-20',
                        hora: '10:00',
                        estado: 'confirmada'
                    },
                    {
                        id: 2,
                        tipo: 'Licencia de Construcción',
                        fecha: '2024-12-22',
                        hora: '14:00',
                        estado: 'pendiente'
                    }
                ];
                
                mostrarCitas(citasEjemplo);
                mostrarProximasCitas(citasEjemplo);
            } catch (error) {
                console.error('Error al cargar citas:', error);
            }
        }

        function mostrarCitas(citas) {
            const container = document.getElementById('lista-citas');
            
            if (citas.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-4">No tienes citas programadas</p>';
                return;
            }
            
            container.innerHTML = citas.map(cita => `
                <div class="border-b pb-3 mb-3 last:border-b-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium text-sm">${cita.tipo}</h4>
                            <p class="text-xs text-gray-600">${new Date(cita.fecha).toLocaleDateString()} - ${cita.hora}</p>
                            <span class="text-xs px-2 py-1 rounded ${cita.estado === 'confirmada' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                                ${cita.estado === 'confirmada' ? 'Confirmada' : 'Pendiente'}
                            </span>
                        </div>
                        <button onclick="cancelarCita(${cita.id})" class="text-red-500 hover:text-red-700 text-xs">
                            Cancelar
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function mostrarProximasCitas(citas) {
            const container = document.getElementById('proximas-citas');
            const hoy = new Date();
            
            const proximasCitas = citas
                .filter(cita => new Date(cita.fecha) >= hoy)
                .sort((a, b) => new Date(a.fecha) - new Date(b.fecha))
                .slice(0, 3);
            
            if (proximasCitas.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-4">No hay citas próximas</p>';
                return;
            }
            
            container.innerHTML = proximasCitas.map(cita => `
                <div class="bg-blue-50 p-3 rounded mb-3">
                    <h4 class="font-medium text-sm text-blue-900">${cita.tipo}</h4>
                    <p class="text-xs text-blue-700">${new Date(cita.fecha).toLocaleDateString()} - ${cita.hora}</p>
                </div>
            `).join('');
        }

        // === FUNCIONES DE PERFIL ===
        async function cargarDatosPerfil() {
            try {
                // Aquí conectarías con el backend para obtener los datos del usuario
                // Por ahora uso datos de ejemplo
                const datosUsuario = {
                    nombre: '<?php echo htmlspecialchars($_SESSION['nombre'] ?? ''); ?>',
                    apellido: 'Ejemplo', // Este dato vendría del backend
                    fecha_nacimiento: '1990-01-01',
                    genero: 'masculino',
                    genero_personalizado: '',
                    contacto: 'usuario@ejemplo.com'
                };
                
                document.getElementById('perfil-nombre').value = datosUsuario.nombre;
                document.getElementById('perfil-apellido').value = datosUsuario.apellido;
                document.getElementById('perfil-fecha-nacimiento').value = datosUsuario.fecha_nacimiento;
                document.getElementById('perfil-genero').value = datosUsuario.genero;
                document.getElementById('perfil-contacto').value = datosUsuario.contacto;
                
                if (datosUsuario.genero === 'otro' && datosUsuario.genero_personalizado) {
                    document.getElementById('perfil-genero-personalizado-container').classList.remove('hidden');
                    document.getElementById('perfil-genero-personalizado').value = datosUsuario.genero_personalizado;
                }
            } catch (error) {
                console.error('Error al cargar datos del perfil:', error);
            }
        }

        async function cargarEstadisticasPerfil() {
            try {
                // Estadísticas de ejemplo (conectar con backend)
                document.getElementById('stats-solicitudes').textContent = '5';
                document.getElementById('stats-completados').textContent = '3';
                document.getElementById('stats-citas').textContent = '2';
                document.getElementById('stats-registro').textContent = '15 de Enero, 2024';
            } catch (error) {
                console.error('Error al cargar estadísticas:', error);
            }
        }

        function editarPerfil() {
            perfilEditando = true;
            
            // Habilitar campos
            document.getElementById('perfil-nombre').disabled = false;
            document.getElementById('perfil-apellido').disabled = false;
            document.getElementById('perfil-fecha-nacimiento').disabled = false;
            document.getElementById('perfil-genero').disabled = false;
            document.getElementById('perfil-contacto').disabled = false;
            
            // Cambiar estilos
            const campos = document.querySelectorAll('#form-perfil input, #form-perfil select');
            campos.forEach(campo => {
                campo.classList.remove('bg-gray-50', 'disabled:bg-gray-50', 'disabled:text-gray-500');
                campo.classList.add('bg-white');
            });
            
            // Mostrar botones y cambiar texto del botón editar
            document.getElementById('perfil-botones').classList.remove('hidden');
            document.getElementById('btn-editar-perfil').textContent = 'Editando...';
            document.getElementById('btn-editar-perfil').disabled = true;
            document.getElementById('btn-editar-perfil').classList.add('opacity-50');
        }

        function cancelarEdicion() {
            perfilEditando = false;
            cargarDatosPerfil(); // Recargar datos originales
            
            // Deshabilitar campos
            const campos = document.querySelectorAll('#form-perfil input, #form-perfil select');
            campos.forEach(campo => {
                campo.disabled = true;
                campo.classList.add('bg-gray-50', 'disabled:bg-gray-50', 'disabled:text-gray-500');
                campo.classList.remove('bg-white');
            });
            
            // Ocultar botones y restaurar botón editar
            document.getElementById('perfil-botones').classList.add('hidden');
            document.getElementById('btn-editar-perfil').textContent = 'Editar';
            document.getElementById('btn-editar-perfil').disabled = false;
            document.getElementById('btn-editar-perfil').classList.remove('opacity-50');
        }

        function descargarDatos() {
            alert('🔄 Preparando descarga de tus datos personales...');
            // Aquí implementarías la descarga real
        }

        function mostrarPoliticasPrivacidad() {
            alert('📄 Abriendo políticas de privacidad...');
            // Aquí podrías abrir un modal o redirigir a la página de políticas
        }

        // === EVENT LISTENERS ===
        
        // Formulario de nueva cita
        document.getElementById('form-nueva-cita').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const datosFormulario = Object.fromEntries(formData);
            
            try {
                // Aquí enviarías los datos al backend
                console.log('Datos de la cita:', datosFormulario);
                alert('✅ Cita programada exitosamente!');
                cerrarModalCita();
                cargarCitas(); // Recargar lista de citas
            } catch (error) {
                console.error('Error al programar cita:', error);
                alert('❌ Error al programar la cita. Inténtalo de nuevo.');
            }
        });

        // Formulario de perfil
        document.getElementById('form-perfil').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (!perfilEditando) return;
            
            const formData = new FormData(e.target);
            const datosFormulario = Object.fromEntries(formData);
            
            try {
                // Aquí enviarías los datos al backend
                console.log('Datos del perfil:', datosFormulario);
                alert('✅ Perfil actualizado exitosamente!');
                cancelarEdicion();
            } catch (error) {
                console.error('Error al actualizar perfil:', error);
                alert('❌ Error al actualizar el perfil. Inténtalo de nuevo.');
            }
        });

        // Cambio de género
        document.getElementById('perfil-genero').addEventListener('change', function() {
            const generoPersonalizadoContainer = document.getElementById('perfil-genero-personalizado-container');
            if (this.value === 'otro') {
                generoPersonalizadoContainer.classList.remove('hidden');
                document.getElementById('perfil-genero-personalizado').disabled = !perfilEditando;
            } else {
                generoPersonalizadoContainer.classList.add('hidden');
            }
        });

        function cancelarCita(citaId) {
            if (confirm('¿Estás seguro de que quieres cancelar esta cita?')) {
                alert('✅ Cita cancelada exitosamente!');
                cargarCitas(); // Recargar lista
            }
        }

        async function cargarEstadisticas() {
            try {
                // Crear endpoint para estadísticas del ciudadano
                const response = await fetch('../../backend/ciudadano/obtener_estadisticas.php');
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('tramites-activos').textContent = 
                        data.tramites_activos + ' trámites en proceso';
                    
                    const ultimoEstado = data.ultimo_estado;
                    if (ultimoEstado) {
                        const estadoTexto = getEstadoTexto(ultimoEstado.estado);
                        const fechaTexto = new Date(ultimoEstado.fecha).toLocaleDateString();
                        document.getElementById('ultimo-estado').innerHTML = 
                            `<span class="${getEstadoColor(ultimoEstado.estado)}">${estadoTexto}</span><br><small class="text-xs">${fechaTexto}</small>`;
                    } else {
                        document.getElementById('ultimo-estado').textContent = 'Sin solicitudes';
                    }
                }
            } catch (error) {
                console.error('Error al cargar estadísticas:', error);
            }
        }

        async function cargarNotificaciones() {
            try {
                const response = await fetch('../../backend/ciudadano/obtener_notificaciones.php');
                const data = await response.json();
                
                if (data.success) {
                    const totalNoLeidas = data.total_no_leidas;
                    const badge = document.getElementById('badge-notificaciones');
                    const resumen = document.getElementById('resumen-notificaciones');
                    
                    if (totalNoLeidas > 0) {
                        badge.textContent = totalNoLeidas;
                        badge.classList.remove('hidden');
                        resumen.innerHTML = `<span class="font-semibold text-red-600">${totalNoLeidas} notificaciones nuevas</span>`;
                    } else {
                        badge.classList.add('hidden');
                        resumen.textContent = 'No hay notificaciones nuevas';
                    }
                    
                    // Mostrar notificaciones en el centro
                    mostrarNotificaciones(data.notificaciones);
                }
            } catch (error) {
                console.error('Error al cargar notificaciones:', error);
            }
        }

        function mostrarNotificaciones(notificaciones) {
            const container = document.getElementById('lista-notificaciones');
            
            if (notificaciones.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-4">No hay notificaciones</p>';
                return;
            }
            
            container.innerHTML = notificaciones.map(notif => `
                <div class="border-b pb-4 mb-4 ${!notif.leida ? 'bg-blue-50 p-3 rounded' : ''}" data-id="${notif.id}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h4 class="font-semibold ${getTipoColor(notif.tipo)}">${notif.titulo}</h4>
                            <p class="text-gray-700 mt-1">${notif.mensaje}</p>
                            <p class="text-xs text-gray-500 mt-2">${new Date(notif.fecha_creacion).toLocaleString()}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            ${!notif.leida ? `
                                <button onclick="marcarLeida(${notif.id})" 
                                        class="text-xs bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                    Marcar leída
                                </button>
                            ` : ''}
                            ${notif.solicitud_id ? `
                                <button onclick="verSolicitud(${notif.solicitud_id})" 
                                        class="text-xs bg-[#6B1024] text-white px-2 py-1 rounded hover:bg-[#8B223A]">
                                    Ver solicitud
                                </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        async function marcarLeida(notificacionId) {
            try {
                const formData = new FormData();
                formData.append('notificacion_id', notificacionId);
                
                const response = await fetch('../../backend/ciudadano/marcar_notificacion_leida.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    cargarNotificaciones(); // Recargar notificaciones
                }
            } catch (error) {
                console.error('Error al marcar notificación:', error);
            }
        }

        function verSolicitud(solicitudId) {
            window.location.href = `regimiento_sol.php#solicitud-${solicitudId}`;
        }

        function toggleNotificaciones() {
            const centro = document.getElementById('centro-notificaciones');
            notificacionesAbiertas = !notificacionesAbiertas;
            
            if (notificacionesAbiertas) {
                centro.classList.remove('hidden');
                cargarNotificaciones(); // Recargar al abrir
            } else {
                centro.classList.add('hidden');
            }
        }

        function getEstadoTexto(estado) {
            const estados = {
                'pendiente': 'Pendiente',
                'en_proceso': 'En Proceso',
                'completada': 'Completada',
                'rechazada': 'Rechazada'
            };
            return estados[estado] || estado;
        }

        function getEstadoColor(estado) {
            const colores = {
                'pendiente': 'text-yellow-600',
                'en_proceso': 'text-blue-600',
                'completada': 'text-green-600',
                'rechazada': 'text-red-600'
            };
            return colores[estado] || 'text-gray-600';
        }

        function getTipoColor(tipo) {
            const colores = {
                'success': 'text-green-600',
                'error': 'text-red-600',
                'warning': 'text-yellow-600',
                'info': 'text-blue-600'
            };
            return colores[tipo] || 'text-gray-600';
        }

        // Funciones para cambio de contraseña
        function mostrarCambioContrasena() {
            document.getElementById('modal-cambio-contrasena').classList.remove('hidden');
        }

        function cerrarModalContrasena() {
            document.getElementById('modal-cambio-contrasena').classList.add('hidden');
            document.getElementById('form-cambio-contrasena').reset();
        }

        // Manejar el envío del formulario de cambio de contraseña
        document.getElementById('form-cambio-contrasena').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            
            try {
                const response = await fetch('../../backend/cambiar_contrasena.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('✅ ' + data.message);
                    cerrarModalContrasena();
                } else {
                    alert('❌ Error: ' + data.error);
                }
            } catch (error) {
                console.error('Error al cambiar contraseña:', error);
                alert('❌ Error al cambiar la contraseña. Inténtelo de nuevo.');
            }
        });

        // Cerrar modal al hacer clic fuera de él
        document.getElementById('modal-cambio-contrasena').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModalContrasena();
            }
        });

        // Cerrar modal con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('modal-cambio-contrasena');
                if (!modal.classList.contains('hidden')) {
                    cerrarModalContrasena();
                }
            }
        });
    </script>
</body>
</html>