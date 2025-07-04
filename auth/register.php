<?php
require_once '../config.php';

$error = '';
$success = '';

// Obtener roles de la base de datos para mostrar en el select
$stmtRoles = $pdo->query("SELECT id, nombre FROM roles");
$roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $contraseña = $_POST['contraseña'] ?? '';
    $rol_id = $_POST['rol'] ?? '';

    // Validaciones
    if ($nombre === '') {
        $error = "El nombre es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "Por favor, ingresa un correo válido.";
    } elseif (strlen($contraseña) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres.";
    } elseif (!in_array($rol_id, array_column($roles, 'id'))) {
        $error = "Selecciona un rol válido.";
    } else {
        // Insertar usuario
        $hashed = password_hash($contraseña, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, contraseña, rol_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $correo, $hashed, $rol_id]);
        $success = "Registro exitoso. <a href='login.php'>Iniciar sesión</a>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/estilo.css">
</head>
<body>

<div class="d-flex justify-content-center align-items-center min-vh-100 bg-pastel">
  <div class="login-box shadow p-5 rounded-4">
    <h2 class="text-center mb-4 text-rojizo">Registro de Usuario</h2>

    <?php if ($error): ?>
      <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
      <div class="alert alert-success text-center"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" novalidate>
      <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Correo</label>
        <input type="email" name="correo" class="form-control" required value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password" name="contraseña" class="form-control" required minlength="8" title="La contraseña debe tener al menos 8 caracteres">
      </div>
      <div class="mb-3">
        <label class="form-label">Rol</label>
        <select name="rol" class="form-select" required>
          <option disabled selected>Selecciona un rol</option>
          <?php foreach ($roles as $rol): ?>
            <option value="<?= $rol['id'] ?>" <?= (isset($_POST['rol']) && $_POST['rol'] == $rol['id']) ? 'selected' : '' ?>>
              <?= ucfirst($rol['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="d-grid gap-2 mt-4">
        <button type="submit" class="btn btn-rojizo">Registrarse</button>
        <a href="../index.php" class="btn btn-outline-rojizo">Regresar al inicio</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>