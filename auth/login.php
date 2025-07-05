<?php
require_once '../config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $stmt = $pdo->prepare("SELECT u.*, r.nombre as rol FROM usuarios u JOIN roles r ON u.rol_id = r.id WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
        $_SESSION['usuario'] = $usuario;
        switch ($usuario['rol']) {
            case 'admin':
                header("Location: ../dashboard/admin.php"); break;
            case 'docente':
                header("Location: ../dashboard/docente.php"); break;
            case 'estudiante':
                header("Location: ../dashboard/estudiante.php"); break;
        }
        exit;
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>Credenciales incorrectas.</div>";
    }
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/estilo.css">

<div class="container mt-5 text-center">
  <h2>Iniciar Sesión</h2>
  <form method="POST" class="mt-4 mx-auto" style="max-width: 400px;">
    <div class="mb-3 text-start">
      <label>Correo</label>
      <input type="email" name="correo" class="form-control" required>
    </div>
    <div class="mb-3 text-start">
      <label>Contraseña</label>
      <input type="password" name="contraseña" class="form-control" required minlength="8">
    </div>
    <button type="submit" class="btn btn-custom me-2">Entrar</button>
    <a href="register.php" class="btn btn-link">Registrarse</a><br>
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
