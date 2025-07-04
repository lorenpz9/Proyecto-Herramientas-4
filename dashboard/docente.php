<?php
require_once '../includes/sesion.php';
require_once '../config.php';

$docente_id = $_SESSION['usuario']['id'];

// Filtros
$where = "WHERE docente_id = ?";
$params = [$docente_id];

if (!empty($_GET['tipo'])) {
    $where .= " AND tipo = ?";
    $params[] = $_GET['tipo'];
}
if (!empty($_GET['curso'])) {
    $where .= " AND curso = ?";
    $params[] = $_GET['curso'];
}

$sql = "SELECT * FROM recursos $where ORDER BY fecha_subida DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$recursos = $stmt->fetchAll();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2>Bienvenido Docente</h2>
  <a href="perfil.php" class="btn btn-outline-primary mb-3">Mi Perfil</a>
  <a href="crear_recurso.php" class="btn btn-success mb-3">+ Nuevo recurso</a>

  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
      <select name="tipo" class="form-select">
        <option value="">Todos los tipos</option>
        <option value="documento">Documento</option>
        <option value="video">Video</option>
        <option value="enlace">Enlace</option>
        <option value="ejercicio">Ejercicio</option>
      </select>
    </div>
    <div class="col-md-4">
      <input type="text" name="curso" class="form-control" placeholder="Filtrar por curso">
    </div>
    <div class="col-md-4">
      <button class="btn btn-secondary">Aplicar filtros</button>
    </div>
  </form>

  <?php if ($recursos): ?>
    <?php foreach ($recursos as $recurso): ?>
      <div class="card mb-3 p-3">
        <h5><?= htmlspecialchars($recurso['titulo']) ?> (<?= $recurso['tipo'] ?>)</h5>
        <p><strong>Curso:</strong> <?= $recurso['curso'] ?> | <strong>Categoría:</strong> <?= $recurso['categoria'] ?></p>
        <p><?= htmlspecialchars($recurso['descripcion']) ?></p>
        <?php if ($recurso['tipo'] === 'enlace'): ?>
          <a href="<?= $recurso['enlace'] ?>" target="_blank" class="btn btn-sm btn-primary">Abrir Enlace</a>
        <?php else: ?>
          <a href="../<?= $recurso['archivo'] ?>" class="btn btn-sm btn-success" download>Descargar</a>
        <?php endif; ?>
        <a href="editar_recurso.php?id=<?= $recurso['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-info">No has subido recursos aún.</div>
  <?php endif; ?>

  <a href="../auth/logout.php" class="btn btn-secondary mt-4">Cerrar sesión</a>
</div>
