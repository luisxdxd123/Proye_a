<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <link rel="stylesheet" href="../backend/in_log.css" />
    <title>Página de inicio</title>
    <style>
      .error-message {
        color: #6B1024;
        font-size: 13px;
        margin-top: 10px;
        text-align: center;
      }
    </style>
  </head>

  <body>
    <div class="container" id="container">
      <div class="form-container sign-up">
        <form action="../backend/register.php" method="POST">
          <h1>Crea una cuenta</h1>
          <span>Es rápido y facil.</span>
          <input type="text" name="nombre" placeholder="Nombre" required />
          <input type="text" name="apellido" placeholder="Apellido" required />
          <div class="fecha-nacimiento-group">
            <label>Fecha de nacimiento</label>
            <div class="fecha-inputs">
              <input
                type="number"
                name="dia"
                placeholder="Día"
                min="1"
                max="31"
                required
              />
              <input
                type="number"
                name="mes"
                placeholder="Mes"
                min="1"
                max="12"
                required
              />
              <input
                type="number"
                name="anio"
                placeholder="Año"
                min="1900"
                max="2100"
                required
              />
            </div>
          </div>
          <select name="genero" style="margin:8px 0;" required>
            <option value="" disabled selected>Género</option>
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
            <option value="otro">Otro</option>
          </select>
          <input
            type="text"
            name="contacto"
            placeholder="Número de celular o correo electrónico"
            required
          />
          <input
            type="password"
            name="contrasena"
            placeholder="Contraseña"
            required
          />
          <button type="submit">Sign Up</button>
        </form>
      </div>
      <div class="form-container sign-in">
        <form action="../backend/login.php" method="POST">
          <h1>Inicio de Sesión</h1>
          <span>Usa tu contacto y contraseña</span>
          <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
              <?php 
                switch($_GET['error']) {
                  case 'credenciales':
                    echo 'Credenciales incorrectas';
                    break;
                  case 'rol':
                    echo 'Error con el rol de usuario';
                    break;
                  default:
                    echo 'Error al iniciar sesión';
                }
              ?>
            </div>
          <?php endif; ?>
          <input type="text" name="contacto" placeholder="Correo o teléfono" required />
          <input type="password" name="contrasena" placeholder="Contraseña" required />
          <a href="#">¿Olvidaste tu contraseña?</a>
          <button type="submit">Iniciar Sesión</button>
        </form>
      </div>
      <div class="toggle-container">
        <div class="toggle">
          <div class="toggle-panel toggle-left">
            <h1>Bienvenido de vuelta!</h1>
            <p>Ya tienes cuenta¿? Inicia Sesion!</p>
            <button class="hidden" id="login">Sign In</button>
          </div>
          <div class="toggle-panel toggle-right">
            <h1>Hola Ciudadano!</h1>
            <p>
              No tienes una cuenta? Crea una ahora para acceder a todas las
              funcionalidades del sitio.
            </p>
            <button class="hidden" id="register">Sign Up</button>
          </div>
        </div>
      </div>
    </div>

    <script src="../js/app.js"></script>
  </body>
</html>