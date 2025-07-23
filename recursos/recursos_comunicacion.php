<?php
require_once '../includes/sesion.php';
require_once '../config.php';

$stmt = $pdo->prepare("SELECT * FROM recursos WHERE categoria = 'Comunicación'");
$stmt->execute();
$recursos = $stmt->fetchAll();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2>Recursos de Comunicación</h2>

  <?php if ($recursos): ?>
    <?php foreach ($recursos as $recurso): ?>
      <div class="card mb-3 p-3">
        <h5><?= htmlspecialchars($recurso['titulo']) ?> (<?= $recurso['tipo'] ?>)</h5>
        <p><?= htmlspecialchars($recurso['descripcion']) ?></p>
        <p><strong>Curso:</strong> <?= htmlspecialchars($recurso['curso']) ?></p>
        <?php if ($recurso['tipo'] === 'enlace'): ?>
          <a href="<?= $recurso['enlace'] ?>" target="_blank" class="btn btn-primary btn-sm">Ver Enlace</a>
        <?php else: ?>
          <a href="../<?= $recurso['archivo'] ?>" download class="btn btn-success btn-sm">Descargar</a>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-warning">No hay recursos en esta categoría.</div>
  <?php endif; ?>

  <a href="../dashboard/estudiante.php" class="btn btn-secondary mt-3">Volver</a>
</div>
