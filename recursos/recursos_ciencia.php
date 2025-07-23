<?php
require_once '../includes/sesion.php';
require_once '../config.php';

$stmt = $pdo->prepare("SELECT * FROM recursos WHERE categoria = 'Ciencia'");
$stmt->execute();
$recursos = $stmt->fetchAll();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2 class="text-danger">Recursos de Ciencia</h2>

  <?php if ($recursos): ?>
    <div class="row">
      <?php foreach ($recursos as $recurso): ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100 border-0 shadow-sm" style="background-color: #F5F5DC;">
            <div class="card-body">
              <h5 class="card-title text-dark">
                <?= htmlspecialchars($recurso['titulo']) ?>
                <small class="text-muted">(<?= $recurso['tipo'] ?>)</small>
              </h5>
              <p class="card-text"><?= htmlspecialchars($recurso['descripcion']) ?></p>
              <p><strong>Curso:</strong> <?= htmlspecialchars($recurso['curso']) ?></p>

              <?php if ($recurso['tipo'] === 'enlace'): ?>
                <a href="<?= htmlspecialchars($recurso['enlace']) ?>" target="_blank" class="btn btn-sm btn-primary">Ver Enlace</a>
              <?php else: ?>
                <a href="../<?= htmlspecialchars($recurso['archivo']) ?>" download class="btn btn-sm btn-success">Descargar</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">No hay recursos en esta categoría.</div>
  <?php endif; ?>

  <a href="../dashboard/estudiante.php" class="btn btn-outline-secondary mt-4">Volver</a>
</div>
