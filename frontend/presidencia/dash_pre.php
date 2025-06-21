<?php
require_once '../../backend/auth.php';
checkRole('presidencia');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Presidencia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Estilos para botones de documentos */
        .doc-button {
            transition: all 0.2s ease;
            font-size: 0.75rem;
            margin: 1px;
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
            background: white;
        }
        .doc-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        /* Mejorar visualización de tablas en mobile */
        @media (max-width: 768px) {
            .doc-button {
                font-size: 0.6rem;
                padding: 2px 4px;
                margin: 0.5px;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <?php include 'components/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 ml-64 overflow-y-auto">
            <div class="welcome-message">
                <h1 class="text-3xl font-bold text-[#6B1024] mb-4">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h1>
                <p class="text-gray-600">Panel de Control Presidencia</p>
            </div>
            
            <!-- Content Sections -->
            <div class="mt-8">
                <!-- Solicitudes Section -->
                <div id="solicitudes-content" class="content-section">
                    <h2 class="text-2xl font-bold text-[#6B1024] mb-6">Solicitudes Pendientes</h2>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudadano</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documentos</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="solicitudes-tbody" class="bg-white divide-y divide-gray-200">
                                    <!-- Las filas se cargarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Solicitudes Enviadas Section -->
                <div id="enviadas-content" class="content-section hidden">
                    <h2 class="text-2xl font-bold text-[#6B1024] mb-6">Solicitudes Enviadas</h2>
                    
                    <!-- Filtro por departamento -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por departamento:</label>
                        <select id="filtro-departamento" class="block w-full md:w-1/3 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#6B1024] focus:border-[#6B1024]">
                            <option value="">Todos los departamentos</option>
                        </select>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Solicitud</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudadano</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Envío</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documentos</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Respuesta</th>
                                    </tr>
                                </thead>
                                <tbody id="enviadas-tbody" class="bg-white divide-y divide-gray-200">
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
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudadano</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Autorización</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documentos</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observaciones</th>
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

                <!-- Reportes Section -->
                <div id="reportes-content" class="content-section hidden">
                    <h2 class="text-2xl font-bold text-[#6B1024] mb-6">Dashboard de Reportes</h2>
                    
                    <!-- Estadísticas generales -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-sm font-medium text-gray-500">Total Solicitudes</h3>
                            <p id="stat-total" class="text-3xl font-bold text-[#6B1024]">-</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-sm font-medium text-gray-500">Enviadas a Departamentos</h3>
                            <p id="stat-enviadas" class="text-3xl font-bold text-blue-600">-</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-sm font-medium text-gray-500">Autorizadas</h3>
                            <p id="stat-autorizadas" class="text-3xl font-bold text-green-600">-</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-sm font-medium text-gray-500">Tiempo Promedio Respuesta</h3>
                            <p id="stat-tiempo" class="text-3xl font-bold text-purple-600">- días</p>
                        </div>
                    </div>

                    <!-- Gráficos -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Solicitudes por Estado</h3>
                            <div class="relative h-64">
                                <canvas id="chart-estados"></canvas>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Solicitudes por Mes</h3>
                            <div class="relative h-64">
                                <canvas id="chart-meses"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de rendimiento por departamento -->
                    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Rendimiento por Departamento</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autorizadas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rechazadas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendientes</th>
                                    </tr>
                                </thead>
                                <tbody id="departamentos-tbody" class="bg-white divide-y divide-gray-200">
                                    <!-- Las filas se cargarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Overview (Default View) -->
            <div id="dashboard-overview" class="mt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Solicitudes Pendientes</dt>
                                    <dd class="text-lg font-medium text-gray-900">5</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Solicitudes Enviadas</dt>
                                    <dd class="text-lg font-medium text-gray-900">15</dd>
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Solicitudes Autorizadas</dt>
                                    <dd class="text-lg font-medium text-gray-900">25</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2h8a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 3a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Procesos</dt>
                                    <dd class="text-lg font-medium text-gray-900">45</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver PDF -->
    <div id="modal-pdf" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 h-5/6 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-[#6B1024]">Solicitud PDF</h3>
                <button onclick="cerrarModalPDF()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <iframe id="pdf-iframe" src="" class="w-full h-full border-0 rounded"></iframe>
        </div>
    </div>

    <!-- Modal para enviar solicitud a departamento -->
    <div id="modal-enviar" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold text-[#6B1024] mb-4">Enviar solicitud a departamento</h3>
            <form id="form-enviar-solicitud">
                <input type="hidden" id="solicitud-id" name="solicitud_id">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Departamento:</label>
                    <select id="departamento-select" name="departamento_id" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#6B1024] focus:border-[#6B1024]" required>
                        <option value="">Seleccione un departamento</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones:</label>
                    <textarea name="observaciones" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#6B1024] focus:border-[#6B1024]"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="cerrarModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-[#6B1024] text-white rounded-md hover:bg-[#8B223A]">Enviar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para cambiar contraseña -->
    <div id="modal-cambio-contrasena-presidencia" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-[#6B1024]">Cambiar Contraseña</h3>
                <button onclick="cerrarModalContrasenaPresidencia()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="form-cambio-contrasena-presidencia">
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
                    <button type="button" onclick="cerrarModalContrasenaPresidencia()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-[#6B1024] text-white rounded-md hover:bg-[#8B223A]">Cambiar Contraseña</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let chartEstados = null;
        let chartMeses = null;

        // Función para mostrar/ocultar secciones
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => section.classList.add('hidden'));
            
            const overview = document.getElementById('dashboard-overview');
            
            if (sectionId === 'dashboard-overview') {
                // Mostrar vista principal
                overview.style.display = 'block';
            } else {
                // Ocultar vista principal
                overview.style.display = 'none';
                
                const targetSection = document.getElementById(sectionId);
                if (targetSection) {
                    targetSection.classList.remove('hidden');
                    
                    // Cargar datos según la sección
                    if (sectionId === 'solicitudes-content') {
                        cargarSolicitudes();
                    } else if (sectionId === 'enviadas-content') {
                        cargarDepartamentos();
                        cargarSolicitudesEnviadas();
                    } else if (sectionId === 'autorizadas-content') {
                        cargarSolicitudesAutorizadas();
                    } else if (sectionId === 'reportes-content') {
                        cargarEstadisticas();
                    }
                }
            }
            
            // Actualizar estado visual de las pestañas
            const allTabs = document.querySelectorAll('nav a');
            allTabs.forEach(tab => {
                tab.classList.remove('bg-[#8B223A]', 'border-white');
                tab.classList.add('border-transparent');
            });
            
            // Destacar pestaña activa
            let activeTabId;
            if (sectionId === 'dashboard-overview') {
                activeTabId = 'inicio-tab';
            } else {
                activeTabId = sectionId.replace('-content', '-tab');
            }
            
            const activeTab = document.getElementById(activeTabId);
            if (activeTab) {
                activeTab.classList.add('bg-[#8B223A]', 'border-white');
                activeTab.classList.remove('border-transparent');
            }
        }

        // Cargar solicitudes pendientes
        async function cargarSolicitudes() {
            try {
                const response = await fetch('../../backend/presidencia/obtener_solicitudes.php');
                const data = await response.json();
                
                if (data.success) {
                    const tbody = document.getElementById('solicitudes-tbody');
                    tbody.innerHTML = '';
                    
                    data.solicitudes.forEach(solicitud => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.nombre} ${solicitud.apellido}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="max-w-xs truncate" title="${solicitud.descripcion}">
                                    ${solicitud.descripcion}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${new Date(solicitud.fecha_creacion).toLocaleDateString()}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getEstadoColor(solicitud.estado)}">
                                    ${solicitud.estado}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                ${generarBotonesDocumentos(solicitud)}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="descargarPDF(${solicitud.id})" class="text-blue-600 hover:text-blue-900 mr-2" title="Ver PDF de la solicitud original">PDF</button>
                                <button onclick="verPDFModal(${solicitud.id})" class="text-green-600 hover:text-green-900 mr-2" title="Ver PDF en ventana">Modal</button>
                                <button onclick="abrirModalEnviar(${solicitud.id})" class="text-[#6B1024] hover:text-[#8B223A]">Enviar</button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            } catch (error) {
                console.error('Error al cargar solicitudes:', error);
            }
        }

        // Cargar departamentos
        async function cargarDepartamentos() {
            try {
                const response = await fetch('../../backend/presidencia/obtener_departamentos.php');
                const data = await response.json();
                
                if (data.success) {
                    const select = document.getElementById('departamento-select');
                    const filtro = document.getElementById('filtro-departamento');
                    
                    select.innerHTML = '<option value="">Seleccione un departamento</option>';
                    filtro.innerHTML = '<option value="">Todos los departamentos</option>';
                    
                    data.departamentos.forEach(dept => {
                        const option = `<option value="${dept.id}">${dept.nombre}</option>`;
                        select.innerHTML += option;
                        filtro.innerHTML += option;
                    });
                }
            } catch (error) {
                console.error('Error al cargar departamentos:', error);
            }
        }

        // Cargar solicitudes enviadas
        async function cargarSolicitudesEnviadas(departamentoId = null) {
            try {
                let url = '../../backend/presidencia/obtener_solicitudes_enviadas.php';
                if (departamentoId) {
                    url += `?departamento_id=${departamentoId}`;
                }
                
                const response = await fetch(url);
                const data = await response.json();
                
                if (data.success) {
                    const tbody = document.getElementById('enviadas-tbody');
                    tbody.innerHTML = '';
                    
                    data.solicitudes_enviadas.forEach(solicitud => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.solicitud_id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.ciudadano_nombre} ${solicitud.ciudadano_apellido}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.departamento_nombre} ${solicitud.departamento_apellido || ''}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${new Date(solicitud.fecha_envio).toLocaleDateString()}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getEstadoColor(solicitud.estado_envio)}">
                                    ${solicitud.estado_envio}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                ${generarBotonesDocumentosEnviadas(solicitud)}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">${solicitud.respuesta_departamento || '-'}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            } catch (error) {
                console.error('Error al cargar solicitudes enviadas:', error);
            }
        }

        // Cargar solicitudes autorizadas
        async function cargarSolicitudesAutorizadas() {
            try {
                const response = await fetch('../../backend/presidencia/obtener_solicitudes_autorizadas.php');
                const data = await response.json();
                
                if (data.success) {
                    const tbody = document.getElementById('autorizadas-tbody');
                    tbody.innerHTML = '';
                    
                    data.solicitudes_autorizadas.forEach(solicitud => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.solicitud_id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.ciudadano_nombre} ${solicitud.ciudadano_apellido}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.departamento_nombre} ${solicitud.departamento_apellido || ''}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${new Date(solicitud.fecha_respuesta).toLocaleDateString()}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                ${generarBotonesDocumentosAutorizadas(solicitud)}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">${solicitud.respuesta_departamento || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="descargarPDF(${solicitud.solicitud_id})" class="text-blue-600 hover:text-blue-900 mr-2" title="Ver PDF de la solicitud original">PDF</button>
                                <button onclick="verPDFModal(${solicitud.solicitud_id})" class="text-green-600 hover:text-green-900" title="Ver PDF en ventana">Modal</button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            } catch (error) {
                console.error('Error al cargar solicitudes autorizadas:', error);
            }
        }

        // Cargar estadísticas
        async function cargarEstadisticas() {
            try {
                const response = await fetch('../../backend/presidencia/obtener_estadisticas.php');
                const data = await response.json();
                
                if (data.success) {
                    const stats = data.estadisticas;
                    
                    // Actualizar estadísticas generales
                    document.getElementById('stat-total').textContent = stats.total_solicitudes;
                    document.getElementById('stat-enviadas').textContent = stats.total_enviadas;
                    document.getElementById('stat-autorizadas').textContent = stats.total_autorizadas;
                    document.getElementById('stat-tiempo').textContent = stats.promedio_respuesta_dias + ' días';
                    
                    // Gráfico de estados
                    const ctxEstados = document.getElementById('chart-estados').getContext('2d');
                    if (chartEstados) chartEstados.destroy();
                    chartEstados = new Chart(ctxEstados, {
                        type: 'doughnut',
                        data: {
                            labels: stats.solicitudes_por_estado.map(e => e.estado),
                            datasets: [{
                                data: stats.solicitudes_por_estado.map(e => e.cantidad),
                                backgroundColor: ['#FCD34D', '#60A5FA', '#34D399', '#EF4444', '#A78BFA']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                    
                    // Gráfico de meses
                    const ctxMeses = document.getElementById('chart-meses').getContext('2d');
                    if (chartMeses) chartMeses.destroy();
                    chartMeses = new Chart(ctxMeses, {
                        type: 'line',
                        data: {
                            labels: stats.por_mes.map(m => {
                                const [year, month] = m.mes.split('-');
                                return `${month}/${year}`;
                            }),
                            datasets: [{
                                label: 'Solicitudes',
                                data: stats.por_mes.map(m => m.cantidad),
                                borderColor: '#6B1024',
                                backgroundColor: 'rgba(107, 16, 36, 0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                    
                    // Tabla de departamentos
                    const tbody = document.getElementById('departamentos-tbody');
                    tbody.innerHTML = '';
                    stats.por_departamento.forEach(dept => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${dept.departamento}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${dept.cantidad}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">${dept.autorizadas}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">${dept.rechazadas}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600">${dept.pendientes}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            } catch (error) {
                console.error('Error al cargar estadísticas:', error);
            }
        }

        // Funciones auxiliares
        function getEstadoColor(estado) {
            const colores = {
                'pendiente': 'bg-yellow-100 text-yellow-800',
                'en_proceso': 'bg-blue-100 text-blue-800',
                'en_revision': 'bg-blue-100 text-blue-800',
                'completada': 'bg-green-100 text-green-800',
                'autorizada': 'bg-green-100 text-green-800',
                'rechazada': 'bg-red-100 text-red-800'
            };
            return colores[estado] || 'bg-gray-100 text-gray-800';
        }

        function descargarPDF(solicitudId) {
            // Abrir el PDF de la solicitud original del ciudadano en la misma pestaña
            const url = `../shared/generar_pdf_solicitud.php?id=${solicitudId}`;
            window.location.href = url;
        }

        function verPDFModal(solicitudId) {
            // Mostrar el PDF en un modal dentro de la misma página
            const url = `../shared/generar_pdf_solicitud.php?id=${solicitudId}`;
            document.getElementById('pdf-iframe').src = url;
            document.getElementById('modal-pdf').classList.remove('hidden');
        }

        function cerrarModalPDF() {
            document.getElementById('modal-pdf').classList.add('hidden');
            document.getElementById('pdf-iframe').src = '';
        }

        function abrirModalEnviar(solicitudId) {
            document.getElementById('solicitud-id').value = solicitudId;
            document.getElementById('modal-enviar').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modal-enviar').classList.add('hidden');
            document.getElementById('form-enviar-solicitud').reset();
        }

        // Funciones para manejar documentos
        function generarBotonesDocumentos(solicitud) {
            const documentos = [
                { campo: 'ine', etiqueta: 'INE', color: 'text-blue-600 hover:text-blue-900' },
                { campo: 'curp', etiqueta: 'CURP', color: 'text-green-600 hover:text-green-900' },
                { campo: 'comprobante_domicilio', etiqueta: 'Domicilio', color: 'text-purple-600 hover:text-purple-900' },
                { campo: 'documento_adicional', etiqueta: 'Doc+', color: 'text-orange-600 hover:text-orange-900' },
                { campo: 'imagen_adicional', etiqueta: 'Img+', color: 'text-pink-600 hover:text-pink-900' }
            ];
            
            let botones = [];
            
            documentos.forEach(doc => {
                if (solicitud[doc.campo] && solicitud[doc.campo] !== '') {
                    botones.push(`
                        <button 
                            onclick="verDocumento(${solicitud.id}, '${doc.campo}')" 
                            class="doc-button ${doc.color}"
                            title="Ver ${doc.etiqueta}"
                        >
                            ${doc.etiqueta}
                        </button>
                    `);
                }
            });
            
            return botones.length > 0 ? botones.join('') : '<span class="text-gray-400 text-xs">Sin docs</span>';
        }

        function verDocumento(solicitudId, tipoDocumento) {
            const url = `../../backend/presidencia/ver_documento.php?solicitud_id=${solicitudId}&tipo=${tipoDocumento}`;
            
            // Abrir en nueva ventana con manejo de errores
            const nuevaVentana = window.open(url, '_blank', 'width=800,height=600,scrollbars=yes,resizable=yes');
            
            // Verificar si la ventana se abrió correctamente
            if (!nuevaVentana) {
                alert('⚠️ No se pudo abrir el documento. Por favor, verifica que no tienes bloqueador de ventanas emergentes activado.');
                return;
            }
            
            // Verificar después de un momento si la ventana se cerró (indicaría un error)
            setTimeout(() => {
                if (nuevaVentana.closed) {
                    console.warn(`Documento ${tipoDocumento} para solicitud ${solicitudId} puede haber tenido problemas al cargar`);
                }
            }, 1000);
        }

        function verDocumentoModal(solicitudId, tipoDocumento) {
            const url = `../../backend/presidencia/ver_documento.php?solicitud_id=${solicitudId}&tipo=${tipoDocumento}`;
            
            // Mostrar loading
            const iframe = document.getElementById('pdf-iframe');
            iframe.src = 'data:text/html,<div style="display:flex;justify-content:center;align-items:center;height:100vh;font-family:Arial;">🔄 Cargando documento...</div>';
            document.getElementById('modal-pdf').classList.remove('hidden');
            
            // Cargar el documento real
            iframe.onload = function() {
                // Verificar si hay error en la carga
                try {
                    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                    if (iframeDoc.body.innerText.includes('no encontrado') || 
                        iframeDoc.body.innerText.includes('Error') ||
                        iframeDoc.body.innerText.includes('404')) {
                        iframe.src = 'data:text/html,<div style="display:flex;flex-direction:column;justify-content:center;align-items:center;height:100vh;font-family:Arial;text-align:center;"><h3 style="color:red;">❌ Documento no disponible</h3><p>El archivo solicitado no se encuentra en el servidor.</p><p><small>Solicitud: ' + solicitudId + ' | Tipo: ' + tipoDocumento + '</small></p></div>';
                    }
                } catch (e) {
                    // Error de acceso cross-origin, probablemente el documento se cargó bien
                    console.log('Documento cargado (cross-origin)');
                }
            };
            
            iframe.onerror = function() {
                iframe.src = 'data:text/html,<div style="display:flex;flex-direction:column;justify-content:center;align-items:center;height:100vh;font-family:Arial;text-align:center;"><h3 style="color:red;">❌ Error al cargar</h3><p>No se pudo cargar el documento solicitado.</p><p><small>Solicitud: ' + solicitudId + ' | Tipo: ' + tipoDocumento + '</small></p></div>';
            };
            
            iframe.src = url;
        }

        // Función para documentos en solicitudes enviadas
        function generarBotonesDocumentosEnviadas(solicitud) {
            const documentos = [
                { campo: 'ine', etiqueta: 'INE', color: 'text-blue-600 hover:text-blue-900' },
                { campo: 'curp', etiqueta: 'CURP', color: 'text-green-600 hover:text-green-900' },
                { campo: 'comprobante_domicilio', etiqueta: 'Domicilio', color: 'text-purple-600 hover:text-purple-900' },
                { campo: 'documento_adicional', etiqueta: 'Doc+', color: 'text-orange-600 hover:text-orange-900' },
                { campo: 'imagen_adicional', etiqueta: 'Img+', color: 'text-pink-600 hover:text-pink-900' }
            ];
            
            let botones = [];
            
            documentos.forEach(doc => {
                if (solicitud[doc.campo] && solicitud[doc.campo] !== '') {
                    botones.push(`
                        <button 
                            onclick="verDocumento(${solicitud.solicitud_id}, '${doc.campo}')" 
                            class="doc-button ${doc.color}"
                            title="Ver ${doc.etiqueta}"
                        >
                            ${doc.etiqueta}
                        </button>
                    `);
                }
            });
            
            return botones.length > 0 ? botones.join('') : '<span class="text-gray-400 text-xs">Sin docs</span>';
        }

        // Función para documentos en solicitudes autorizadas
        function generarBotonesDocumentosAutorizadas(solicitud) {
            const documentos = [
                { campo: 'ine', etiqueta: 'INE', color: 'text-blue-600 hover:text-blue-900' },
                { campo: 'curp', etiqueta: 'CURP', color: 'text-green-600 hover:text-green-900' },
                { campo: 'comprobante_domicilio', etiqueta: 'Domicilio', color: 'text-purple-600 hover:text-purple-900' },
                { campo: 'documento_adicional', etiqueta: 'Doc+', color: 'text-orange-600 hover:text-orange-900' },
                { campo: 'imagen_adicional', etiqueta: 'Img+', color: 'text-pink-600 hover:text-pink-900' }
            ];
            
            let botones = [];
            
            documentos.forEach(doc => {
                if (solicitud[doc.campo] && solicitud[doc.campo] !== '') {
                    botones.push(`
                        <button 
                            onclick="verDocumento(${solicitud.solicitud_id}, '${doc.campo}')" 
                            class="doc-button ${doc.color}"
                            title="Ver ${doc.etiqueta}"
                        >
                            ${doc.etiqueta}
                        </button>
                    `);
                }
            });
            
            return botones.length > 0 ? botones.join('') : '<span class="text-gray-400 text-xs">Sin docs</span>';
        }

        // Enviar solicitud a departamento
        document.getElementById('form-enviar-solicitud').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            
            try {
                const response = await fetch('../../backend/presidencia/enviar_solicitud.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('Solicitud enviada correctamente');
                    cerrarModal();
                    cargarSolicitudes();
                } else {
                    alert('Error: ' + data.error);
                }
            } catch (error) {
                console.error('Error al enviar solicitud:', error);
                alert('Error al enviar la solicitud');
            }
        });

        // Filtro de departamento
        document.getElementById('filtro-departamento').addEventListener('change', (e) => {
            cargarSolicitudesEnviadas(e.target.value);
        });

        // Event listeners para los tabs de la sidebar
        document.getElementById('inicio-tab').addEventListener('click', (e) => {
            e.preventDefault();
            showSection('dashboard-overview');
        });

        document.getElementById('solicitudes-tab').addEventListener('click', (e) => {
            e.preventDefault();
            showSection('solicitudes-content');
        });

        document.getElementById('enviadas-tab').addEventListener('click', (e) => {
            e.preventDefault();
            showSection('enviadas-content');
        });

        document.getElementById('autorizadas-tab').addEventListener('click', (e) => {
            e.preventDefault();
            showSection('autorizadas-content');
        });

        // Event listener para reportes
        document.getElementById('reportes-tab').addEventListener('click', (e) => {
            e.preventDefault();
            showSection('reportes-content');
        });

        // Cerrar modal al hacer clic fuera de él
        document.getElementById('modal-pdf').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModalPDF();
            }
        });

        // Cerrar modal con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modalPDF = document.getElementById('modal-pdf');
                if (!modalPDF.classList.contains('hidden')) {
                    cerrarModalPDF();
                }
            }
        });

        // Al cargar la página, mostrar el overview por defecto
        document.addEventListener('DOMContentLoaded', function() {
            showSection('dashboard-overview');
        });

        // Funciones para cambio de contraseña
        function mostrarCambioContrasenaPresidencia() {
            document.getElementById('modal-cambio-contrasena-presidencia').classList.remove('hidden');
        }

        function cerrarModalContrasenaPresidencia() {
            document.getElementById('modal-cambio-contrasena-presidencia').classList.add('hidden');
            document.getElementById('form-cambio-contrasena-presidencia').reset();
        }

        // Manejar el envío del formulario de cambio de contraseña
        document.getElementById('form-cambio-contrasena-presidencia').addEventListener('submit', async (e) => {
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
                    cerrarModalContrasenaPresidencia();
                } else {
                    alert('❌ Error: ' + data.error);
                }
            } catch (error) {
                console.error('Error al cambiar contraseña:', error);
                alert('❌ Error al cambiar la contraseña. Inténtelo de nuevo.');
            }
        });

        // Cerrar modal al hacer clic fuera de él
        document.getElementById('modal-cambio-contrasena-presidencia').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModalContrasenaPresidencia();
            }
        });

        // Cerrar modal con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('modal-cambio-contrasena-presidencia');
                if (!modal.classList.contains('hidden')) {
                    cerrarModalContrasenaPresidencia();
                }
            }
        });
    </script>
</body>
</html>
