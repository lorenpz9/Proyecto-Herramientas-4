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
            case 'admin': header("Location: ../dashboard/admin.php"); break;
            case 'docente': header("Location: ../dashboard/docente.php"); break;
            case 'estudiante': header("Location: ../dashboard/estudiante.php"); break;
        }
        exit;
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #8B0000;
      color: #F5F5DC;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      background-color: #FFFFFF;
      color: #333;
      border-radius: 10px;
      width: 100%;
      max-width: 400px;
    }
    .btn-primary {
      background-color: #D4AF37;
      border-color: #D4AF37;
      color: #000;
    }
    .btn-primary:hover {
      background-color: #bfa332;
      border-color: #bfa332;
    }
    a {
      color: #8B0000;
    }
  </style>
</head>
<body>
  <div class="card shadow-lg p-4">
    <h3 class="text-center mb-4">Iniciar Sesión</h3>
    <?php if (isset($error)): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" name="correo" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="contraseña" class="form-label">Contraseña</label>
        <input type="password" name="contraseña" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Entrar</button>
      <div class="mt-3 text-center">
        <a href="register.php">¿No tienes cuenta? Regístrate</a><br>
        <a href="../index.php" class="btn btn-outline-secondary btn-sm mt-2">Volver al inicio</a>
      </div>
    </form>
  </div>
  <?php include '../includes/chatbot.php'; ?>
</body>
</html>
