<?php
require_once '../../backend/auth.php';
checkRole('departamentos');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Departamento</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-[#6B1024] text-white w-64 flex-shrink-0 fixed h-screen overflow-y-hidden">
            <div class="p-4">
                <h2 class="text-2xl font-semibold">Panel Departamento</h2>
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
                <a href="#" id="recibidas-tab" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <span>Solicitudes Recibidas</span>
                    </div>
                </a>
                <a href="#" id="administrar-tab" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Administrar Solicitudes</span>
                    </div>
                </a>
                <a href="#" id="autorizadas-tab" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Solicitudes Autorizadas</span>
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
                <p class="text-gray-600">Panel de Control Departamental</p>
            </div>
            
            <!-- Content Sections -->
            <div class="mt-8">
                <!-- Solicitudes Recibidas Section -->
                <div id="recibidas-content" class="content-section">
                    <h2 class="text-2xl font-bold text-[#6B1024] mb-6">Solicitudes Recibidas</h2>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudadano</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Recepción</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enviado por</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="recibidas-tbody" class="bg-white divide-y divide-gray-200">
                                    <!-- Las filas se cargarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Administrar Solicitudes Section -->
                <div id="administrar-content" class="content-section hidden">
                    <h2 class="text-2xl font-bold text-[#6B1024] mb-6">Administrar Solicitudes</h2>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudadano</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última Actualización</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="administrar-tbody" class="bg-white divide-y divide-gray-200">
                                    <!-- Las filas se cargarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Solicitudes Autorizadas Section -->
                <div id="autorizadas-content" class="content-section hidden">
                    <h2 class="text-2xl font-bold text-[#6B1024] mb-6">Solicitudes Autorizadas</h2>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <h3 class="font-semibold text-green-900 mb-2">Total Autorizadas</h3>
                                <p id="total-autorizadas" class="text-2xl font-bold text-green-600">0</p>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudadano</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Autorización</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Respuesta</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="autorizadas-tbody" class="bg-white divide-y divide-gray-200">
                                    <!-- Las filas se cargarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Overview (Default View) -->
            <div id="dashboard-overview" class="mt-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Solicitudes Pendientes</dt>
                                    <dd id="stat-pendientes" class="text-lg font-medium text-gray-900">0</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">En Proceso</dt>
                                    <dd id="stat-proceso" class="text-lg font-medium text-gray-900">0</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Autorizadas</dt>
                                    <dd id="stat-autorizadas" class="text-lg font-medium text-gray-900">0</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para actualizar estado -->
    <div id="modal-estado" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold text-[#6B1024] mb-4">Actualizar Estado de Solicitud</h3>
            <form id="form-actualizar-estado">
                <input type="hidden" id="envio-id" name="envio_id">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nuevo Estado:</label>
                    <select id="nuevo-estado" name="nuevo_estado" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#6B1024] focus:border-[#6B1024]" required>
                        <option value="">Seleccione un estado</option>
                        <option value="en_revision">En Revisión</option>
                        <option value="autorizada">Autorizada</option>
                        <option value="rechazada">Rechazada</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Respuesta/Observaciones:</label>
                    <textarea name="respuesta" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#6B1024] focus:border-[#6B1024]" required></textarea>
  </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="cerrarModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-[#6B1024] text-white rounded-md hover:bg-[#8B223A]">Actualizar</button>
          </div>
        </form>
      </div>
          </div>

    <script>
        // Función para mostrar/ocultar secciones
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => section.classList.add('hidden'));
            
            const overview = document.getElementById('dashboard-overview');
            overview.style.display = 'none';
            
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.classList.remove('hidden');
                
                // Cargar datos según la sección
                if (sectionId === 'recibidas-content') {
                    cargarSolicitudesRecibidas();
                } else if (sectionId === 'administrar-content') {
                    cargarSolicitudesEnProceso();
                } else if (sectionId === 'autorizadas-content') {
                    cargarSolicitudesAutorizadas();
                }
            }
            
            // Actualizar estado activo de la sidebar
            const allTabs = document.querySelectorAll('nav a');
            allTabs.forEach(tab => {
                tab.classList.remove('bg-[#8B223A]');
            });
            
            const activeTab = document.getElementById(sectionId.replace('-content', '-tab'));
            if (activeTab) {
                activeTab.classList.add('bg-[#8B223A]');
            }
        }

        // Cargar solicitudes recibidas
        async function cargarSolicitudesRecibidas() {
            try {
                const response = await fetch('../../backend/departamentos/obtener_solicitudes_recibidas.php');
                const data = await response.json();
                
                if (data.success) {
                    const tbody = document.getElementById('recibidas-tbody');
                    tbody.innerHTML = '';
                    
                    data.solicitudes.forEach(solicitud => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.solicitud_id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.ciudadano_nombre} ${solicitud.ciudadano_apellido}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="max-w-xs truncate" title="${solicitud.descripcion}">
                                    ${solicitud.descripcion}
      </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${new Date(solicitud.fecha_envio).toLocaleDateString()}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.enviado_por_nombre} ${solicitud.enviado_por_apellido}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="descargarPDF(${solicitud.solicitud_id})" class="text-blue-600 hover:text-blue-900 mr-3">PDF</button>
                                <button onclick="abrirModalEstado(${solicitud.envio_id})" class="text-[#6B1024] hover:text-[#8B223A]">Procesar</button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                    
                    document.getElementById('stat-pendientes').textContent = data.solicitudes.length;
                }
            } catch (error) {
                console.error('Error al cargar solicitudes:', error);
            }
        }

        // Cargar solicitudes en proceso
        async function cargarSolicitudesEnProceso() {
            try {
                const response = await fetch('../../backend/departamentos/obtener_solicitudes_en_proceso.php');
                const data = await response.json();
                
                if (data.success) {
                    const tbody = document.getElementById('administrar-tbody');
                    tbody.innerHTML = '';
                    
                    data.solicitudes.forEach(solicitud => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.solicitud_id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.ciudadano_nombre} ${solicitud.ciudadano_apellido}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="max-w-xs truncate" title="${solicitud.descripcion}">
                                    ${solicitud.descripcion}
          </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    En Revisión
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ${solicitud.fecha_respuesta ? new Date(solicitud.fecha_respuesta).toLocaleDateString() : '-'}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="descargarPDF(${solicitud.solicitud_id})" class="text-blue-600 hover:text-blue-900 mr-3">PDF</button>
                                <button onclick="abrirModalEstado(${solicitud.envio_id})" class="text-[#6B1024] hover:text-[#8B223A]">Actualizar</button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                    
                    document.getElementById('stat-proceso').textContent = data.solicitudes.length;
                }
            } catch (error) {
                console.error('Error al cargar solicitudes en proceso:', error);
            }
        }

        // Cargar solicitudes autorizadas
        async function cargarSolicitudesAutorizadas() {
            try {
                const response = await fetch('../../backend/departamentos/obtener_solicitudes_autorizadas.php');
                const data = await response.json();
                
                if (data.success) {
                    const tbody = document.getElementById('autorizadas-tbody');
                    tbody.innerHTML = '';
                    
                    data.solicitudes.forEach(solicitud => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.solicitud_id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.ciudadano_nombre} ${solicitud.ciudadano_apellido}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="max-w-xs truncate" title="${solicitud.descripcion}">
                                    ${solicitud.descripcion}
      </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${new Date(solicitud.fecha_respuesta).toLocaleDateString()}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">${solicitud.respuesta_departamento || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="descargarPDF(${solicitud.solicitud_id})" class="text-blue-600 hover:text-blue-900">Ver PDF</button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                    
                    document.getElementById('total-autorizadas').textContent = data.solicitudes.length;
                    document.getElementById('stat-autorizadas').textContent = data.solicitudes.length;
                }
            } catch (error) {
                console.error('Error al cargar solicitudes autorizadas:', error);
            }
        }

        // Funciones auxiliares
        function descargarPDF(solicitudId) {
            window.open(`../shared/generar_pdf_solicitud.php?id=${solicitudId}`, '_blank');
        }

        function abrirModalEstado(envioId) {
            document.getElementById('envio-id').value = envioId;
            document.getElementById('modal-estado').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modal-estado').classList.add('hidden');
            document.getElementById('form-actualizar-estado').reset();
        }

        // Actualizar estado de solicitud
        document.getElementById('form-actualizar-estado').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            
            try {
                const response = await fetch('../../backend/departamentos/actualizar_estado_solicitud.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('Estado actualizado correctamente');
                    cerrarModal();
                    // Recargar la sección actual
                    const seccionActual = document.querySelector('.content-section:not(.hidden)');
                    if (seccionActual) {
                        if (seccionActual.id === 'recibidas-content') {
                            cargarSolicitudesRecibidas();
                        } else if (seccionActual.id === 'administrar-content') {
                            cargarSolicitudesEnProceso();
                        }
                    }
                } else {
                    alert('Error: ' + data.error);
                }
            } catch (error) {
                console.error('Error al actualizar estado:', error);
                alert('Error al actualizar el estado');
            }
        });

        // Event listeners para los tabs de la sidebar
        document.getElementById('recibidas-tab').addEventListener('click', (e) => {
            e.preventDefault();
            showSection('recibidas-content');
        });

        document.getElementById('administrar-tab').addEventListener('click', (e) => {
            e.preventDefault();
            showSection('administrar-content');
        });

        document.getElementById('autorizadas-tab').addEventListener('click', (e) => {
            e.preventDefault();
            showSection('autorizadas-content');
        });

        // Al cargar la página, mostrar el overview y cargar estadísticas
        document.addEventListener('DOMContentLoaded', function() {
            const overview = document.getElementById('dashboard-overview');
            overview.style.display = 'block';
            
            // Cargar estadísticas iniciales
            cargarSolicitudesRecibidas();
            cargarSolicitudesEnProceso();
            cargarSolicitudesAutorizadas();
        });
  </script>
</body>
</html>