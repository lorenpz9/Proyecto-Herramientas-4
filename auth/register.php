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
      background-color: #8B0000;
      color: #333;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: Arial, sans-serif;
    }
    .card {
      background-color: #FFFFFF;
      color: #333;
      border-radius: 10px;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
    .btn-primary {
      background-color: #D4AF37;
      border-color: #D4AF37;
      color: #000;
      font-weight: 600;
    }
    .btn-primary:hover, .btn-primary:focus {
      background-color: #bfa332;
      border-color: #bfa332;
      color: #000;
    }
    a {
      color: #8B0000;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
    .text-center a.btn-outline-secondary {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="card shadow-lg p-4">
    <h3 class="text-center mb-4">Registro de Usuario</h3>

    <?php if ($error): ?>
      <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" novalidate>
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="form-control" required value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" id="correo" name="correo" class="form-control" required value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label for="contraseña" class="form-label">Contraseña</label>
        <input type="password" id="contraseña" name="contraseña" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="rol" class="form-label">Rol</label>
        <select id="rol" name="rol" class="form-select" required>
          <option value="1" <?= (isset($_POST['rol']) && $_POST['rol'] == 1) ? 'selected' : '' ?>>Administrador</option>
          <option value="2" <?= (isset($_POST['rol']) && $_POST['rol'] == 2) ? 'selected' : '' ?>>Docente</option>
          <option value="3" <?= (isset($_POST['rol']) && $_POST['rol'] == 3) ? 'selected' : '' ?>>Estudiante</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary w-100">Registrarse</button>

      <div class="mt-3 text-center">
        <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a><br>
        <a href="../index.php" class="btn btn-outline-secondary btn-sm mt-2">Volver al inicio</a>
      </div>
    </form>
  </div>

  <?php include '../includes/chatbot.php'; ?>
</body>
</html>
