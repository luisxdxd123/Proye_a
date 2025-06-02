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
                            <canvas id="chart-estados" width="400" height="200"></canvas>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Solicitudes por Mes</h3>
                            <canvas id="chart-meses" width="400" height="200"></canvas>
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

    <script>
        let chartEstados = null;
        let chartMeses = null;

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
            
            const allTabs = document.querySelectorAll('nav a');
            allTabs.forEach(tab => {
                tab.classList.remove('bg-[#8B223A]', 'border-white');
                tab.classList.add('border-transparent');
            });
            
            const activeTab = document.getElementById(sectionId.replace('-content', '-tab'));
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
                                <button onclick="descargarPDF(${solicitud.id})" class="text-blue-600 hover:text-blue-900 mr-3">PDF</button>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.departamento_nombre || 'Departamento'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${new Date(solicitud.fecha_envio).toLocaleDateString()}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getEstadoColor(solicitud.estado_envio)}">
                                    ${solicitud.estado_envio}
                                </span>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${solicitud.departamento_nombre || 'Departamento'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${new Date(solicitud.fecha_respuesta).toLocaleDateString()}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">${solicitud.respuesta_departamento || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="descargarPDF(${solicitud.solicitud_id})" class="text-blue-600 hover:text-blue-900">Ver PDF</button>
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
                                backgroundColor: ['#FCD34D', '#60A5FA', '#34D399', '#EF4444']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
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
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
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
            window.open(`../shared/generar_pdf_solicitud.php?id=${solicitudId}`, '_blank');
        }

        function abrirModalEnviar(solicitudId) {
            document.getElementById('solicitud-id').value = solicitudId;
            document.getElementById('modal-enviar').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modal-enviar').classList.add('hidden');
            document.getElementById('form-enviar-solicitud').reset();
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

        // Agregar listener para reportes
        document.querySelectorAll('nav a').forEach(link => {
            if (link.textContent.trim() === 'Reportes') {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    showSection('reportes-content');
                });
            }
        });

        // Al cargar la página, mostrar el overview por defecto
        document.addEventListener('DOMContentLoaded', function() {
            const overview = document.getElementById('dashboard-overview');
            overview.style.display = 'block';
        });
    </script>
</body>
</html>
