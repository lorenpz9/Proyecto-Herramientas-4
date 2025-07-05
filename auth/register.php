<?php
require_once '../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $rol_id = $_POST['rol'];

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, contraseña, rol_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $correo, $contraseña, $rol_id]);
    echo "<div class='alert alert-success text-center mt-3'>Registro exitoso. <a href='login.php'>Iniciar sesión</a></div>";
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/estilo.css">

<div class="container mt-5 text-center">
  <h2>Registro de Usuario</h2>
  <form method="POST" class="mt-4 mx-auto" style="max-width: 450px;">
    <div class="mb-3 text-start">
      <label>Nombre</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3 text-start">
      <label>Correo</label>
      <input type="email" name="correo" class="form-control" required>
    </div>
    <div class="mb-3 text-start">
      <label>Contraseña</label>
      <input type="password" name="contraseña" class="form-control" required minlength="8">
    </div>
    <div class="mb-3 text-start">
      <label>Rol</label>
      <select name="rol" class="form-select" required>
        <option value="" disabled selected>Seleccione un rol</option>
        <option value="1">Administrador</option>
        <option value="2">Docente</option>
        <option value="3">Estudiante</option>
      </select>
    </div>
    <button type="submit" class="btn btn-custom me-2">Registrarse</button>
    <a href="../index.php" class="btn btn-link">Volver al inicio</a>
  </form>
</div>

<!-- Chatbot Landbot -->
<script>
window.addEventListener('mouseover', initLandbot, { once: true });
window.addEventListener('touchstart', initLandbot, { once: true });
var myLandbot;
function initLandbot() {
  if (!myLandbot) {
    var s = document.createElement('script');
    s.type = "module";
    s.async = true;
    s.addEventListener('load', function () {
      myLandbot = new Landbot.Livechat({
        configUrl: 'https://storage.googleapis.com/landbot.online/v3/H-2957355-52VTQJ5O5XG386QE/index.json',
      });
    });
    s.src = 'https://cdn.landbot.io/landbot-3/landbot-3.0.0.mjs';
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);
  }
}
</script>
