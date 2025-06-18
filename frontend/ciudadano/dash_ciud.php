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

        // Cargar datos al iniciar la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarEstadisticas();
            cargarNotificaciones();
            
            // Actualizar cada 30 segundos
            setInterval(() => {
                cargarNotificaciones();
                cargarEstadisticas();
            }, 30000);
        });

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