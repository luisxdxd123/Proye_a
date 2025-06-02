<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Usuarios</title>
  <link rel="stylesheet" href="d.css">
</head>
<body>

  <div class="contenedor">
    <h1>Gestión de Usuarios</h1>
    <div class="botones">
      <button id="btnAgregar">Agregar Usuario</button>
      <button id="btnEliminar">Eliminar Usuario</button>
      <button id="btnModificar">Modificar Usuario</button>
    </div>
  </div>

  <!-- Modal Agregar -->
  <div id="modalAgregar" class="modal">
    <div class="modal-contenido">
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
  </div>

  <!-- Modal Eliminar -->
  <div id="modalEliminar" class="modal">
    <div class="modal-contenido">
      <h2>Eliminar Usuario</h2>
      <form method="POST" action="procesar_usuario.php">
        <input type="text" name="nombre" placeholder="Nombre de Usuario a Eliminar" required>
        <input type="hidden" name="accion" value="eliminar">
        <p>¿Estás seguro de eliminar el usuario?</p>
        <div class="acciones">
          <button type="button" class="btnCancelar">No</button>
          <button type="submit">Sí</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Modificar -->
  <div id="modalModificar" class="modal">
    <div class="modal-contenido">
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
  </div>

  <script src="gestionar_usuarios.js"></script>
</body>
</html>