<?php
require_once '../includes/sesion.php';
require_once '../config.php';

$docente_id = $_SESSION['usuario']['id'];

if (isset($_GET['eliminar_recurso']) && is_numeric($_GET['eliminar_recurso'])) {
    $id = (int) $_GET['eliminar_recurso'];

    // Validar que el recurso pertenece al docente actual
    $stmt = $pdo->prepare("SELECT * FROM recursos WHERE id = ? AND docente_id = ?");
    $stmt->execute([$id, $docente_id]);
    $recurso = $stmt->fetch();

    if ($recurso) {
        // Eliminar solo ese recurso
        $stmt = $pdo->prepare("DELETE FROM recursos WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);

        header("Location: docente.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>⚠️ El recurso no existe o no te pertenece.</div>";
    }
}

// Obtener recursos
$where = "WHERE docente_id = ?";
$params = [$docente_id];
if (!empty($_GET['tipo'])) {
  $where .= " AND tipo = ?";
  $params[] = $_GET['tipo'];
}
$sql = "SELECT * FROM recursos $where ORDER BY fecha_subida DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$recursos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Docente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .recurso-card {
      background-color: #f0eef5;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    .btn-link-custom {
      background-color: #007bff;
      color: white;
    }
    .btn-link-custom:hover {
      background-color: #0056b3;
    }
    .btn-descargar {
      background-color: #2ecc71;
      color: white;
    }
    .btn-descargar:hover {
      background-color: #27ae60;
    }
    .btn-editar {
      background-color: #ced4da;
      color: black;
    }
    .btn-eliminar {
      background-color: #e74c3c;
      color: white;
    }
    .btn-eliminar:hover {
      background-color: #c0392b;
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="fw-bold">Bienvenido <span class="text-decoration-underline">Docente</span></h1>
    <div class="d-flex gap-2">
      <a href="perfil.php" class="btn btn-primary">Mi perfil</a>
      <a href="crear_recurso.php" class="btn btn-success">Subir recurso</a>
      <a href="../auth/logout.php" class="btn btn-warning text-white">Cerrar sesión</a>
    </div>
  </div>

  <form method="GET" class="row g-2 mb-4">
    <div class="col-md-6">
      <select name="tipo" class="form-select">
        <option value="">Tipo de Tarea</option>
        <option value="documento">Documento</option>
        <option value="video">Video</option>
        <option value="enlace">Enlace</option>
        <option value="ejercicio">Ejercicio</option>
      </select>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3">
      <button class="btn btn-dark w-100">Aplicar filtro</button>
    </div>
  </form>

  <?php if ($recursos): ?>
    <?php foreach ($recursos as $recurso): ?>
      <div class="recurso-card d-flex justify-content-between align-items-center">
        <div class="fw-semibold"><?= htmlspecialchars($recurso['titulo']) ?></div>
        <div class="d-flex gap-2">
          <?php if ($recurso['tipo'] === 'enlace'): ?>
            <a href="<?= $recurso['enlace'] ?>" target="_blank" class="btn btn-link-custom btn-sm">Enlace</a>
          <?php else: ?>
            <a href="../<?= $recurso['archivo'] ?>" class="btn btn-descargar btn-sm" download>Descargar</a>
          <?php endif; ?>
          <a href="editar_recurso.php?id=<?= $recurso['id'] ?>" class="btn btn-editar btn-sm">Editar</a>
          <a href="?eliminar_recurso=<?= $recurso['id'] ?>" class="btn btn-eliminar btn-sm" onclick="return confirm('¿Eliminar este recurso?')">Eliminar</a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-info">No has subido recursos aún.</div>
  <?php endif; ?>
</div>
</body>
</html>
