<?php
require_once '../includes/sesion.php';
require_once '../config.php';

$usuario_id = $_SESSION['usuario']['id'];

// Si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $intereses = $_POST['intereses'];

    $stmt = $pdo->prepare("UPDATE usuarios SET intereses = ? WHERE id = ?");
    $stmt->execute([$intereses, $usuario_id]);

    $_SESSION['usuario']['intereses'] = $intereses; // actualizar en sesión
    $msg = "Perfil actualizado correctamente.";
}

// Obtener usuario actualizado
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Perfil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Mi Perfil</h2>

  <?php if (isset($msg)): ?>
    <div class="alert alert-success"><?= $msg ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label>Nombre:</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" readonly>
    </div>
    <div class="mb-3">
      <label>Correo:</label>
      <input type="email" class="form-control" value="<?= htmlspecialchars($usuario['correo']) ?>" readonly>
    </div>
    <div class="mb-3">
      <label>Áreas de Interés:</label>
      <textarea name="intereses" class="form-control" rows="3"><?= htmlspecialchars($usuario['intereses']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    <a href="<?= $_SESSION['usuario']['rol_id'] == 2 ? 'docente.php' : 'estudiante.php' ?>" class="btn btn-secondary">Volver</a>
  </form>

  <div class="mt-4">
    <h4>Historial de actividad (simulado):</h4>
    <ul class="list-group">
      <li class="list-group-item">Ingresaste por última vez el <?= date('d/m/Y') ?></li>
      <li class="list-group-item">Última acción: Visualizaste un recurso</li>
      <li class="list-group-item">Subiste 2 materiales este mes (docente)</li>
    </ul>
  </div>
</div>
</body>
</html>
