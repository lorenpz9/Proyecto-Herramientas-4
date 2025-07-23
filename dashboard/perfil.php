<?php
require_once '../includes/sesion.php';
require_once '../config.php';

$usuario_id = $_SESSION['usuario']['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $intereses = $_POST['intereses'];
    $stmt = $pdo->prepare("UPDATE usuarios SET intereses = ? WHERE id = ?");
    $stmt->execute([$intereses, $usuario_id]);
    $_SESSION['usuario']['intereses'] = $intereses;
    $msg = "Perfil actualizado correctamente.";
}
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Perfil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    h2, h4 {
      color: #dc3545;
    }
    .card {
      border: 1px solid #ddd;
      border-left: 5px solid #dc3545;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease;
    }
    .card:hover {
      transform: scale(1.01);
    }
    .btn-primary {
      background-color: #dc3545;
      border-color: #dc3545;
    }
    .btn-primary:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }
    .form-control:focus, textarea:focus {
      border-color: #dc3545;
      box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }
    .list-group-item {
      border-left: 4px solid #dc3545;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2 class="text-center mb-4">Mi Perfil</h2>

  <?php if (isset($msg)): ?>
    <div class="alert alert-success text-center"><?= $msg ?></div>
  <?php endif; ?>

  <form method="POST" class="card p-4 shadow mb-4">
    <div class="mb-3">
      <label class="form-label">Nombre:</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" readonly>
    </div>
    <div class="mb-3">
      <label class="form-label">Correo:</label>
      <input type="email" class="form-control" value="<?= htmlspecialchars($usuario['correo']) ?>" readonly>
    </div>
    <div class="mb-3">
      <label class="form-label">Áreas de Interés:</label>
      <textarea name="intereses" class="form-control" rows="3"><?= htmlspecialchars($usuario['intereses']) ?></textarea>
    </div>
    <div class="d-flex justify-content-between">
      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      <a href="<?= $_SESSION['usuario']['rol_id'] == 2 ? 'docente.php' : 'estudiante.php' ?>" class="btn btn-secondary">Volver</a>
    </div>
  </form>

  <div class="mt-4">
    <h4>Historial de Actividad (simulado):</h4>
    <ul class="list-group">
      <li class="list-group-item">Ingresaste por última vez el <?= date('d/m/Y') ?></li>
      <li class="list-group-item">Última acción: Visualizaste un recurso</li>
      <li class="list-group-item">Subiste 2 materiales este mes (docente)</li>
    </ul>
  </div>
</div>
<?php include '../includes/chatbot.php'; ?>
</body>
</html>