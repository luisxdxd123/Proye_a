<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Solicitudes</title>
  <link rel="stylesheet" href="dep.css">
</head>
<body>
  <nav class="sidebar">
    <h2>Panel Departamento</h2>
    <ul class="sidebar-links">
      <li>
        <button id="btnSolicitudes" type="button">Solicitudes</button>
      </li>
      <li>
        <button id="btnSolicitudesEnviadas" type="button">Solicitudes Enviadas</button>
      </li>
      <li>
        <button id="btnSolictudesAutorizadas" type="button">Solicitudes Autorizadas</button>
      </li>
    </ul>
    <div style="margin-top:40px;"></div>
    <button id="btnCerrarSesion" class="cerrar-sesion-btn" type="button">Cerrar sesión</button>
  </nav>
  <div class="main-content">
    <div class="contenedor">
      <h1>Gestión de Solicitudes</h1>
      <div id="formContainer"></div>
    </div>
  </div>
  <script>
    // Formularios HTML como plantillas
    const formAgregar = `
      <div class="form-panel">
        <h2>Agregar Usuario</h2>
        <form method="POST" action="procesar_usuario.php">
          <input type="text" name="nombre" placeholder="Nombre de Usuario" required>
          <input type="password" name="contrasena" placeholder="Contraseña" required>
          <select name="rol" required>
            <option value="">Seleccionar Rol</option>
            <option>Presidencia 1</option>
            <option>Presidencia 2</option>
            <option>Presidencia 3</option>
            <option>Departamento 1</option>
            <option>Departamento 2</option>
            <option>Departamento 3</option>
          </select>
          <input type="hidden" name="accion" value="agregar">
          <div class="acciones">
            <button type="button" class="btnCancelar">Cancelar</button>
            <button type="submit">Guardar</button>
          </div>
        </form>
      </div>
    `;
    const formEliminar = `
      <div class="form-panel">
        <h2>Eliminar Usuario</h2>
        <form method="POST" action="procesar_usuario.php">
          <input type="text" name="nombre" placeholder="Nombre de Usuario a Eliminar" required>
          <input type="hidden" name="accion" value="eliminar">
          <p>¿Estás seguro de eliminar el usuario?</p>
          <div class="acciones">
            <button type="button" class="btnCancelar">Cancelar</button>
            <button type="submit">Sí</button>
          </div>
        </form>
      </div>
    `;
    const formModificar = `
      <div class="form-panel">
        <h2>Modificar Usuario</h2>
        <form method="POST" action="procesar_usuario.php">
          <input type="text" name="nombre_actual" placeholder="Nombre Actual de Usuario" required>
          <input type="text" name="nuevo_nombre" placeholder="Nuevo Nombre de Usuario">
          <input type="password" name="contrasena_actual" placeholder="Contraseña Actual" required>
          <input type="password" name="nueva_contrasena" placeholder="Nueva Contraseña">
          <input type="hidden" name="accion" value="modificar">
          <div class="acciones">
            <button type="button" class="btnCancelar">Cancelar</button>
            <button type="submit">Guardar</button>
          </div>
        </form>
      </div>
    `;

    const formContainer = document.getElementById('formContainer');
    document.getElementById('btnSolicitudes').onclick = () => {
      formContainer.innerHTML = formAgregar;
      addCancelHandler();
    };
    document.getElementById('btnSolicitudesEnviadas').onclick = () => {
      formContainer.innerHTML = formEliminar;
      addCancelHandler();
    };
    document.getElementById('btnSolictudesAutorizadas').onclick = () => {
      formContainer.innerHTML = formModificar;
      addCancelHandler();
    };
    function addCancelHandler() {
      const btn = formContainer.querySelector('.btnCancelar');
      if (btn) btn.onclick = () => formContainer.innerHTML = '';
    }
    document.getElementById('btnCerrarSesion').onclick = function() {
      window.location.href = '../log_reg.php';
    };
  </script>
</body>
</html>