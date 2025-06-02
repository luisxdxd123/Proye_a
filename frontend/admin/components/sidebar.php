<?php
if (!isset($_SESSION)) {
    session_start();
}

// Get the current page filename
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = "Panel Admin"; // Default title

// Set title based on current page
if ($current_page === 'ciudadanos.php') {
    $page_title = "Gestión de Ciudadanos";
} elseif ($current_page === 'departamentos.php') {
    $page_title = "Gestión de Departamentos";
} elseif ($current_page === 'presidencia.php') {
    $page_title = "Gestión de Presidencia";
} elseif ($current_page === 'administradores.php') {
    $page_title = "Gestión de Administradores";
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
                <a href="dash_ad.php" id="btnInicio"><span>Inicio</span></a>
            </div>
        </div>
        <a href="ciudadanos.php" id="btnCiudadanos" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
            <div class="flex items-center space-x-3">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span>Ciudadanos</span>
            </div>
        </a>
        <a href="departamentos.php" id="btnDepartamentos" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
            <div class="flex items-center space-x-3">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>Departamentos</span>
            </div>
        </a>
        <a href="presidencia.php" id="btnPresidencia" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
            <div class="flex items-center space-x-3">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                <span>Presidencia</span>
            </div>
        </a>
        <a href="administradores.php" id="btnAdministradores" class="block px-4 py-3 hover:bg-[#8B223A] transition-colors duration-200">
            <div class="flex items-center space-x-3">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>Administradores</span>
            </div>
        </a>
    </nav>
    <div class="absolute bottom-0 w-64 p-4">
        <a href="../log_reg.php" id="btnCerrarSesion" class="block w-full px-4 py-2 text-center bg-[#8B223A] hover:bg-[#9B324A] rounded-lg transition-colors duration-200">
            Cerrar Sesión
        </a>
    </div>
</div> 