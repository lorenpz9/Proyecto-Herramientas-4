<?php
require_once '../config.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $contraseña = $_POST['contraseña'] ?? '';

    // Validación básica
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "Por favor, ingresa un correo válido.";
    } elseif (strlen($contraseña) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres.";
    } else {
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
            $error = "Credenciales incorrectas.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/estilo.css">
</head>
<body>

  <div class="d-flex justify-content-center align-items-center min-vh-100 bg-pastel">
    <div class="login-box shadow p-5 rounded-4">
      <h2 class="text-center mb-4 text-rojizo">Iniciar Sesión</h2>
      
      <?php if ($error): ?>
        <div class='alert alert-danger text-center'><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" novalidate>
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" name="correo" class="form-control" required value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" name="contraseña" class="form-control" required minlength="8" title="La contraseña debe tener al menos 8 caracteres">
        </div>
        <div class="d-grid gap-2 mt-4">
          <button type="submit" class="btn btn-rojizo">Entrar</button>
          <a href="register.php" class="btn btn-outline-rojizo">Registrarse</a>
          <a href="../index.php" class="btn btn-outline-rojizo">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>