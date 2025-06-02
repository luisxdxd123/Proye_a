<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administrador</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <?php
  require_once '../../backend/auth.php';
  require_once '../../backend/db.php';
  checkRole('admin');
  
  // Obtener estadísticas
  $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM usuarios WHERE rol_user = 'ciudadano'");
  $stmt->execute();
  $total_ciudadanos = $stmt->fetchColumn();
  
  $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM usuarios WHERE rol_user = 'departamentos'");
  $stmt->execute();
  $total_departamentos = $stmt->fetchColumn();
  
  $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM usuarios WHERE rol_user = 'presidencia'");
  $stmt->execute();
  $total_presidencia = $stmt->fetchColumn();
  
  $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM usuarios WHERE rol_user = 'admin'");
  $stmt->execute();
  $total_admins = $stmt->fetchColumn();
  ?>
  <div class="min-h-screen flex">
    <!-- Sidebar -->
    <?php include 'components/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 p-8 ml-64 overflow-y-auto">
      <div class="welcome-message">
        <h1 id="mainTitle" class="text-3xl font-bold text-[#6B1024] mb-4">Panel de Administrador</h1>
        <p id="mainSubtitle" class="text-gray-600">Sistema de Gestión Municipal</p>
      </div>
      
      <!-- Dynamic Content Container -->
      <div id="mainContent" class="mt-8">
        <!-- Dashboard Principal (Default) -->
        <div id="dashboardContent">
          <!-- Main Options -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Gestión de Ciudadanos Card -->
            <a href="ciudadanos.php" class="bg-white p-6 rounded-lg shadow-md border-2 border-transparent hover:border-[#6B1024] transition-all duration-300 cursor-pointer">
              <div class="flex flex-col items-center text-center">
                <div class="w-24 h-24 mb-4 text-[#6B1024]">
                  <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                  </svg>
                </div>
                <h3 class="text-xl font-bold text-[#6B1024] mb-2">GESTIÓN DE CIUDADANOS</h3>
                <p class="text-gray-600">Administrar cuentas y perfiles de ciudadanos registrados en el sistema.</p>
              </div>
            </a>

            <!-- Gestión de Departamentos Card -->
            <a href="departamentos.php" class="bg-white p-6 rounded-lg shadow-md border-2 border-transparent hover:border-[#6B1024] transition-all duration-300 cursor-pointer">
              <div class="flex flex-col items-center text-center">
                <div class="w-24 h-24 mb-4 text-[#6B1024]">
                  <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                  </svg>
                </div>
                <h3 class="text-xl font-bold text-[#6B1024] mb-2">GESTIÓN DE DEPARTAMENTOS</h3>
                <p class="text-gray-600">Supervisar y administrar los diferentes departamentos municipales.</p>
              </div>
            </a>

            <!-- Gestión de Presidencia Card -->
            <a href="presidencia.php" class="bg-white p-6 rounded-lg shadow-md border-2 border-transparent hover:border-[#6B1024] transition-all duration-300 cursor-pointer">
              <div class="flex flex-col items-center text-center">
                <div class="w-24 h-24 mb-4 text-[#6B1024]">
                  <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                  </svg>
                </div>
                <h3 class="text-xl font-bold text-[#6B1024] mb-2">GESTIÓN DE PRESIDENCIA</h3>
                <p class="text-gray-600">Administrar usuarios y permisos del área de presidencia municipal.</p>
              </div>
            </a>

            <!-- Gestión de Administradores Card -->
            <a href="administradores.php" class="bg-white p-6 rounded-lg shadow-md border-2 border-transparent hover:border-[#6B1024] transition-all duration-300 cursor-pointer">
              <div class="flex flex-col items-center text-center">
                <div class="w-24 h-24 mb-4 text-[#6B1024]">
                  <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                  </svg>
                </div>
                <h3 class="text-xl font-bold text-[#6B1024] mb-2">GESTIÓN DE ADMINISTRADORES</h3>
                <p class="text-gray-600">Controlar accesos y permisos de los administradores del sistema.</p>
              </div>
            </a>
          </div>
          
          <!-- Dashboard Cards -->
          <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
              <h3 class="text-xl font-semibold mb-2 text-[#6B1024]">Ciudadanos</h3>
              <p class="text-gray-600">Total registrados</p>
              <p class="text-3xl font-bold text-[#6B1024] mt-2"><?php echo $total_ciudadanos; ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
              <h3 class="text-xl font-semibold mb-2 text-[#6B1024]">Departamentos</h3>
              <p class="text-gray-600">Usuarios activos</p>
              <p class="text-3xl font-bold text-[#6B1024] mt-2"><?php echo $total_departamentos; ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
              <h3 class="text-xl font-semibold mb-2 text-[#6B1024]">Presidencia</h3>
              <p class="text-gray-600">Usuarios</p>
              <p class="text-3xl font-bold text-[#6B1024] mt-2"><?php echo $total_presidencia; ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
              <h3 class="text-xl font-semibold mb-2 text-[#6B1024]">Administradores</h3>
              <p class="text-gray-600">Total</p>
              <p class="text-3xl font-bold text-[#6B1024] mt-2"><?php echo $total_admins; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Contenidos dinámicos para cada sección
    const sectionContents = {
      dashboard: {
        title: "Panel de Administrador",
        subtitle: "Sistema de Gestión Municipal",
        content: document.getElementById('dashboardContent').innerHTML
      },
      ciudadanos: {
        title: "Gestión de Ciudadanos",
        subtitle: "Administrar cuentas y perfiles de ciudadanos",
        content: `
          <div class="space-y-6">
            <!-- Header con botones de acción -->
            <div class="flex justify-between items-center">
              <div>
                <h2 class="text-2xl font-bold text-[#6B1024]">Lista de Ciudadanos</h2>
                <p class="text-gray-600">Gestiona las cuentas de ciudadanos registrados</p>
              </div>
              <button onclick="showAddUserForm('ciudadano')" class="px-4 py-2 bg-[#6B1024] text-white rounded-lg hover:bg-[#8B223A] transition-colors">
                Agregar Ciudadano
              </button>
            </div>

            <!-- Búsqueda y filtros -->
            <div class="bg-white p-4 rounded-lg shadow-md">
              <div class="flex gap-4">
                <input type="text" placeholder="Buscar ciudadano..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
                  <option>Todos los estados</option>
                  <option>Activos</option>
                  <option>Inactivos</option>
          </select>
                <button class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">Buscar</button>
              </div>
            </div>

            <!-- Tabla de ciudadanos -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
              <table class="w-full">
                <thead class="bg-[#6B1024] text-white">
                  <tr>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Fecha Registro</th>
                    <th class="px-6 py-3 text-left">Estado</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                      <a href="ciudadanos.php" class="text-[#6B1024] hover:underline">Ver gestión completa de ciudadanos</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        `
      },
      departamentos: {
        title: "Gestión de Departamentos",
        subtitle: "Administrar departamentos municipales",
        content: `
          <div class="space-y-6">
            <!-- Header con botones de acción -->
            <div class="flex justify-between items-center">
              <div>
                <h2 class="text-2xl font-bold text-[#6B1024]">Departamentos Municipales</h2>
                <p class="text-gray-600">Gestiona los usuarios del área departamental</p>
              </div>
              <button onclick="showAddUserForm('departamento')" class="px-4 py-2 bg-[#6B1024] text-white rounded-lg hover:bg-[#8B223A] transition-colors">
                Agregar Usuario Departamental
              </button>
            </div>

            <!-- Cards de departamentos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-[#6B1024] mb-2">Departamento 1</h3>
                <p class="text-gray-600 mb-4">Usuarios: 0</p>
                <button class="w-full px-4 py-2 border border-[#6B1024] text-[#6B1024] rounded-lg hover:bg-[#6B1024] hover:text-white transition-colors">
                  Ver Usuarios
                </button>
              </div>
              <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-[#6B1024] mb-2">Departamento 2</h3>
                <p class="text-gray-600 mb-4">Usuarios: 0</p>
                <button class="w-full px-4 py-2 border border-[#6B1024] text-[#6B1024] rounded-lg hover:bg-[#6B1024] hover:text-white transition-colors">
                  Ver Usuarios
                </button>
              </div>
              <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-[#6B1024] mb-2">Departamento 3</h3>
                <p class="text-gray-600 mb-4">Usuarios: 0</p>
                <button class="w-full px-4 py-2 border border-[#6B1024] text-[#6B1024] rounded-lg hover:bg-[#6B1024] hover:text-white transition-colors">
                  Ver Usuarios
                </button>
              </div>
            </div>
          </div>
        `
      },
      presidencia: {
        title: "Gestión de Presidencia",
        subtitle: "Administrar usuarios del área de presidencia",
        content: `
          <div class="space-y-6">
            <!-- Header con botones de acción -->
            <div class="flex justify-between items-center">
              <div>
                <h2 class="text-2xl font-bold text-[#6B1024]">Área de Presidencia</h2>
                <p class="text-gray-600">Gestiona los usuarios del área de presidencia municipal</p>
              </div>
              <button onclick="showAddUserForm('presidencia')" class="px-4 py-2 bg-[#6B1024] text-white rounded-lg hover:bg-[#8B223A] transition-colors">
                Agregar Usuario Presidencia
              </button>
            </div>

            <!-- Cards de presidencia -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-[#6B1024] mb-2">Presidencia 1</h3>
                <p class="text-gray-600 mb-4">Usuarios: 0</p>
                <button class="w-full px-4 py-2 border border-[#6B1024] text-[#6B1024] rounded-lg hover:bg-[#6B1024] hover:text-white transition-colors">
                  Ver Usuarios
                </button>
              </div>
              <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-[#6B1024] mb-2">Presidencia 2</h3>
                <p class="text-gray-600 mb-4">Usuarios: 0</p>
                <button class="w-full px-4 py-2 border border-[#6B1024] text-[#6B1024] rounded-lg hover:bg-[#6B1024] hover:text-white transition-colors">
                  Ver Usuarios
                </button>
              </div>
              <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-[#6B1024] mb-2">Presidencia 3</h3>
                <p class="text-gray-600 mb-4">Usuarios: 0</p>
                <button class="w-full px-4 py-2 border border-[#6B1024] text-[#6B1024] rounded-lg hover:bg-[#6B1024] hover:text-white transition-colors">
                  Ver Usuarios
                </button>
              </div>
      </div>
          </div>
        `
      },
      administradores: {
        title: "Gestión de Administradores",
        subtitle: "Controlar accesos y permisos de administradores",
        content: `
          <div class="space-y-6">
            <!-- Header con botones de acción -->
            <div class="flex justify-between items-center">
              <div>
                <h2 class="text-2xl font-bold text-[#6B1024]">Lista de Administradores</h2>
                <p class="text-gray-600">Gestiona las cuentas de administradores del sistema</p>
              </div>
              <button onclick="showAddUserForm('admin')" class="px-4 py-2 bg-[#6B1024] text-white rounded-lg hover:bg-[#8B223A] transition-colors">
                Agregar Administrador
              </button>
            </div>

            <!-- Tabla de administradores -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
              <table class="w-full">
                <thead class="bg-[#6B1024] text-white">
                  <tr>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Permisos</th>
                    <th class="px-6 py-3 text-left">Último Acceso</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                      No hay administradores registrados
                    </td>
                  </tr>
                </tbody>
              </table>
      </div>
          </div>
        `
      }
    };

    // Función para mostrar una sección específica
    function showSection(section) {
      const content = sectionContents[section];
      if (content) {
        document.getElementById('mainTitle').textContent = content.title;
        document.getElementById('mainSubtitle').textContent = content.subtitle;
        document.getElementById('mainContent').innerHTML = content.content;
      }
    }

    // Función para volver al dashboard principal
    function showDashboard() {
      showSection('dashboard');
    }

    // Función para mostrar formulario de agregar usuario
    function showAddUserForm(type) {
      const formContent = `
        <div class="bg-white p-8 rounded-lg shadow-md max-w-md mx-auto">
          <h2 class="text-2xl font-bold text-[#6B1024] mb-6">Agregar ${type === 'ciudadano' ? 'Ciudadano' : type === 'admin' ? 'Administrador' : 'Usuario'}</h2>
          <form class="space-y-4">
            <input type="text" placeholder="Nombre completo" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
            <input type="email" placeholder="Email" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
            <input type="password" placeholder="Contraseña" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
            ${type !== 'ciudadano' ? `
            <select required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6B1024] focus:border-transparent">
              <option value="">Seleccionar ${type === 'admin' ? 'Nivel de Admin' : type.charAt(0).toUpperCase() + type.slice(1)}</option>
              ${type === 'departamento' ? `
                <option>Departamento 1</option>
                <option>Departamento 2</option>
                <option>Departamento 3</option>
              ` : type === 'presidencia' ? `
                <option>Presidencia 1</option>
                <option>Presidencia 2</option>
                <option>Presidencia 3</option>
              ` : `
                <option>Super Admin</option>
                <option>Admin Regular</option>
              `}
            </select>
            ` : ''}
            <div class="flex space-x-4 pt-4">
              <button type="button" onclick="showSection('${type === 'ciudadano' ? 'ciudadanos' : type === 'admin' ? 'administradores' : type + 's'}')" 
                      class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Cancelar
              </button>
              <button type="submit" class="flex-1 px-4 py-2 bg-[#6B1024] text-white rounded-lg hover:bg-[#8B223A] transition-colors">
                Guardar
              </button>
          </div>
        </form>
      </div>
    `;
      document.getElementById('mainContent').innerHTML = formContent;
    }

    // Event listeners para la sidebar (se ejecutan cuando se carga la página)
    document.addEventListener('DOMContentLoaded', function() {
      // Event listeners específicos para cada botón de la sidebar
      document.getElementById('btnInicio').addEventListener('click', (e) => {
        e.preventDefault();
        showDashboard();
      });
      
      document.getElementById('btnCiudadanos').addEventListener('click', (e) => {
        e.preventDefault();
        showSection('ciudadanos');
      });
      
      document.getElementById('btnDepartamentos').addEventListener('click', (e) => {
        e.preventDefault();
        showSection('departamentos');
      });
      
      document.getElementById('btnPresidencia').addEventListener('click', (e) => {
        e.preventDefault();
        showSection('presidencia');
      });
      
      document.getElementById('btnAdministradores').addEventListener('click', (e) => {
        e.preventDefault();
        showSection('administradores');
      });
    });
  </script>
</body>
</html>