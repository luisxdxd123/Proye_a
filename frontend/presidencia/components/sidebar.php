<!-- Sidebar -->
<div class="bg-[#6B1024] text-white w-64 flex-shrink-0 fixed h-screen overflow-y-hidden">
    <div class="p-4">
        <h2 class="text-2xl font-semibold">Panel Presidencia</h2>
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
        <a href="#" id="solicitudes-tab" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200 border-l-4 border-transparent hover:border-white">
            <div class="flex items-center space-x-3">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Solicitudes</span>
            </div>
        </a>
        <a href="#" id="enviadas-tab" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200 border-l-4 border-transparent hover:border-white">
            <div class="flex items-center space-x-3">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                <span>Solicitudes Enviadas</span>
            </div>
        </a>
        <a href="#" id="autorizadas-tab" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200 border-l-4 border-transparent hover:border-white">
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span>Reportes</span>
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
        <a href="#" onclick="mostrarCambioContrasenaPresidencia()" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
            <div class="flex items-center space-x-3">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
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