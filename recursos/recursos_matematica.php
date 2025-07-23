<?php
require_once '../includes/sesion.php';
require_once '../config.php';

$stmt = $pdo->prepare("SELECT * FROM recursos WHERE categoria = 'Matemática'");
$stmt->execute();
$recursos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Recursos de Matemática</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #fff5f5;
      color: #6b0a0a;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      padding-bottom: 40px;
    }
    .container {
      max-width: 900px;
    }
    h2 {
      font-weight: 700;
      margin-bottom: 30px;
      color: #a32a2a;
      text-align: center;
    }
    .card {
      background-color: #fff0f0;
      border: 1px solid #f1c0c0;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 3px 7px rgba(163, 42, 42, 0.15);
      transition: background-color 0.3s ease;
    }
    .card:hover {
      background-color: #ffe5e5;
    }
    .card h5 {
      color: #7a1c1c;
      margin-bottom: 10px;
      font-weight: 600;
    }
    .card p {
      color: #4a1a1a;
      margin-bottom: 8px;
    }
    .btn-primary {
      background-color: #a32a2a;
      border: none;
    }
    .btn-primary:hover {
      background-color: #7a1c1c;
    }
    .btn-success {
      background-color: #d9534f;
      border: none;
    }
    .btn-success:hover {
      background-color: #b2322e;
    }
    .btn-secondary {
      background-color: #c94f4f;
      border: none;
      margin-top: 20px;
    }
    .btn-secondary:hover {
      background-color: #933636;
      color: white;
    }
    .alert-warning {
      background-color: #ffe6e6;
      border-color: #f5c6cb;
      color: #721c24;
      font-weight: 600;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2>Recursos de Matemática</h2>

    <?php if ($recursos): ?>
      <?php foreach ($recursos as $recurso): ?>
        <div class="card">
          <h5><?= htmlspecialchars($recurso['titulo']) ?> (<?= htmlspecialchars($recurso['tipo']) ?>)</h5>
          <p><?= htmlspecialchars($recurso['descripcion']) ?></p>
          <p><strong>Curso:</strong> <?= htmlspecialchars($recurso['curso']) ?></p>
          <?php if ($recurso['tipo'] === 'enlace'): ?>
            <a href="<?= htmlspecialchars($recurso['enlace']) ?>" target="_blank" class="btn btn-primary btn-sm">Ver Enlace</a>
          <?php else: ?>
            <a href="../<?= htmlspecialchars($recurso['archivo']) ?>" download class="btn btn-success btn-sm">Descargar</a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-warning">No hay recursos en esta categoría.</div>
    <?php endif; ?>

    <a href="../dashboard/estudiante.php" class="btn btn-secondary">Volver</a>
  </div>
</body>
</html>
