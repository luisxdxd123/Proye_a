<?php
if (!isset($_SESSION)) {
    session_start();
}

// Get the current page filename
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = "Panel Ciudadano"; // Default title

// Set title based on current page
if ($current_page === 'regimiento_sol.php') {
    $page_title = "Seguimiento de Solicitudes";
}
?>
<!-- Sidebar -->
<div class="bg-[#6B1024] text-white w-64 flex-shrink-0 fixed h-screen overflow-y-hidden">
    <div class="p-4">
        <h2 class="text-2xl font-semibold"><?php echo htmlspecialchars($page_title); ?></h2>
    </div>
    <nav class="mt-6">
        <div class="px-4 py-3">
            <div class="flex items-center space-x-3">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <a href="dash_ciud.php"><span>Inicio</span></a>
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