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
    body {
      background-color: #fafafa;
      color: #444;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .recurso-card {
      background-color: #ffffff;
      padding: 15px 20px;
      border-radius: 10px;
      margin-bottom: 15px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: background-color 0.3s ease;
    }
    .recurso-card:hover {
      background-color: #f0f4f8;
    }
    .btn-link-custom {
      background-color: #5a86ad;
      color: #fff;
      border-radius: 5px;
      padding: 5px 12px;
      font-size: 0.85rem;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .btn-link-custom:hover {
      background-color: #497298;
      color: #fff;
    }
    .btn-descargar {
      background-color: #6abf69;
      color: #fff;
      border-radius: 5px;
      padding: 5px 12px;
      font-size: 0.85rem;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .btn-descargar:hover {
      background-color: #5aa657;
      color: #fff;
    }
    .btn-editar {
      background-color: #d0d7de;
      color: #333;
      border-radius: 5px;
      padding: 5px 12px;
      font-size: 0.85rem;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .btn-editar:hover {
      background-color: #b9c2cc;
      color: #222;
    }
    .btn-eliminar {
      background-color: #f29b9b;
      color: #721c1c;
      border-radius: 5px;
      padding: 5px 12px;
      font-size: 0.85rem;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .btn-eliminar:hover {
      background-color: #d97777;
      color: #540c0c;
    }
    h1 {
      font-weight: 700;
      color: #2c3e50;
    }
    .btn-primary {
      background-color: #5a86ad;
      border: none;
    }
    .btn-primary:hover {
      background-color: #497298;
    }
    .btn-success {
      background-color: #6abf69;
      border: none;
    }
    .btn-success:hover {
      background-color: #5aa657;
    }
    .btn-warning {
      background-color: #f0ad4e;
      border: none;
      color: #3e3e3e;
    }
    .btn-warning:hover {
      background-color: #d99a3b;
      color: #2e2e2e;
    }
    .form-select, .form-control {
      border-radius: 6px;
      border: 1.5px solid #ccc;
      transition: border-color 0.3s ease;
    }
    .form-select:focus, .form-control:focus {
      border-color: #5a86ad;
      box-shadow: 0 0 5px rgba(90, 134, 173, 0.5);
      outline: none;
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
    <h1>Bienvenido <strong style="color: #5a86ad;">Docente</strong></h1>
    <div class="d-flex gap-2 flex-wrap mt-2 mt-md-0">
      <a href="perfil.php" class="btn btn-primary">Mi perfil</a>
      <a href="crear_recurso.php" class="btn btn-success">Subir recurso</a>
      <a href="../auth/logout.php" class="btn btn-warning">Cerrar sesión</a>
    </div>
  </div>

  <form method="GET" class="row g-2 mb-4">
    <div class="col-md-6">
      <select name="tipo" class="form-select" aria-label="Filtro por tipo de recurso">
        <option value="">Tipo de Tarea</option>
        <option value="documento" <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'documento') ? 'selected' : '' ?>>Documento</option>
        <option value="video" <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'video') ? 'selected' : '' ?>>Video</option>
        <option value="enlace" <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'enlace') ? 'selected' : '' ?>>Enlace</option>
        <option value="ejercicio" <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'ejercicio') ? 'selected' : '' ?>>Ejercicio</option>
      </select>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3">
      <button type="submit" class="btn btn-dark w-100">Aplicar filtro</button>
    </div>
  </form>

  <?php if ($recursos): ?>
    <?php foreach ($recursos as $recurso): ?>
      <div class="recurso-card">
        <div class="fw-semibold"><?= htmlspecialchars($recurso['titulo']) ?></div>
        <div class="d-flex gap-2">
          <?php if ($recurso['tipo'] === 'enlace'): ?>
            <a href="<?= htmlspecialchars($recurso['enlace']) ?>" target="_blank" class="btn-link-custom btn-sm">Enlace</a>
          <?php else: ?>
            <a href="../<?= htmlspecialchars($recurso['archivo']) ?>" class="btn-descargar btn-sm" download>Descargar</a>
          <?php endif; ?>
          <a href="editar_recurso.php?id=<?= (int)$recurso['id'] ?>" class="btn-editar btn-sm">Editar</a>
          <a href="?eliminar_recurso=<?= (int)$recurso['id'] ?>" class="btn-eliminar btn-sm" onclick="return confirm('¿Eliminar este recurso?')">Eliminar</a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-info">No has subido recursos aún.</div>
  <?php endif; ?>
</div>
</body>
</html>
