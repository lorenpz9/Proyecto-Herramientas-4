<?php
require_once '../config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $rol_id = $_POST['rol'];

    // Verificar si el correo ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuarioExistente = $stmt->fetch();

    if ($usuarioExistente) {
        $error = "Usuario existente, por favor usa otro correo.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, contraseña, rol_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $correo, $contraseña, $rol_id]);
        header("Location: login.php?registro=exitoso");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #004080, #0077cc);
      color: white;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      width: 100%;
      max-width: 500px;
    }
  </style>
</head>
<body>
  <div class="card shadow-lg">
    <div class="card-body">
      <div class="mb-3 text-start">
        <a href="../index.php" class="btn btn-secondary">&larr; Volver al inicio</a>
      </div>
      <h3 class="text-center mb-4">Registro de Usuario</h3>
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <form method="POST" novalidate>
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="nombre" class="form-control" required value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Correo electrónico</label>
          <input type="email" name="correo" class="form-control" required value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" name="contraseña" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Rol</label>
          <select name="rol" class="form-select" required>
            <option value="1" <?= (isset($_POST['rol']) && $_POST['rol'] == 1) ? 'selected' : '' ?>>Administrador</option>
            <option value="2" <?= (isset($_POST['rol']) && $_POST['rol'] == 2) ? 'selected' : '' ?>>Docente</option>
            <option value="3" <?= (isset($_POST['rol']) && $_POST['rol'] == 3) ? 'selected' : '' ?>>Estudiante</option>
          </select>
        </div>
        <button type="submit" class="btn btn-success w-100">Registrarse</button>
        <div class="mt-3 text-center">
          <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
      </form>
    </div>
  </div>
  <?php include '../includes/chatbot.php'; ?>
</body>
</html>
