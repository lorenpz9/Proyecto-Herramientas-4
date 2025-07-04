<?php
require_once '../includes/sesion.php';
require_once '../config.php';
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2>Bienvenido Estudiante</h2>

  <form method="GET" class="mt-4 mb-4">
    <div class="row">
      <div class="col">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por título" value="<?= $_GET['buscar'] ?? '' ?>">
      </div>
      <div class="col">
        <select name="tipo" class="form-select">
          <option value="">Todos los tipos</option>
          <option value="documento">Documento</option>
          <option value="video">Video</option>
          <option value="enlace">Enlace</option>
          <option value="ejercicio">Ejercicio</option>
        </select>
      </div>
      <div class="mt-4">
  <h5>Ver por categoría:</h5>
  <a href="../recursos/recursos_matematica.php" class="btn btn-outline-dark btn-sm me-2">Matemática</a>
  <a href="../recursos/recursos_comunicacion.php" class="btn btn-outline-dark btn-sm me-2">Comunicación</a>
  <a href="../recursos/recursos_ciencia.php" class="btn btn-outline-dark btn-sm">Ciencia</a>
  </div>
      <div class="col">
        <button type="submit" class="btn btn-success">Buscar</button>
      </div>
    </div>
  </form>

  <?php
  $where = [];
  $params = [];

  if (!empty($_GET['buscar'])) {
      $where[] = "titulo LIKE ?";
      $params[] = "%" . $_GET['buscar'] . "%";
  }
  if (!empty($_GET['tipo'])) {
      $where[] = "tipo = ?";
      $params[] = $_GET['tipo'];
  }
  if (!empty($_GET['categoria'])) {
      $where[] = "categoria = ?";
      $params[] = $_GET['categoria'];
  }

  $sql = "SELECT * FROM recursos";
  if ($where) {
      $sql .= " WHERE " . implode(" AND ", $where);
  }

  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $recursos = $stmt->fetchAll();

  if ($recursos) {
      foreach ($recursos as $recurso) {
          echo "<div class='card mb-3 p-3'>";
          echo "<h5>{$recurso['titulo']} ({$recurso['tipo']})</h5>";
          echo "<p>{$recurso['descripcion']}</p>";
          echo "<p><strong>Curso:</strong> {$recurso['curso']} | <strong>Categoría:</strong> {$recurso['categoria']}</p>";
          if ($recurso['tipo'] === 'enlace') {
              echo "<a href='{$recurso['enlace']}' target='_blank' class='btn btn-sm btn-primary'>Abrir enlace</a>";
          } else {
              echo "<a href='../{$recurso['archivo']}' download class='btn btn-sm btn-success'>Descargar</a>";
          }
          echo "</div>";
      }
  } else {
      echo "<div class='alert alert-warning'>No se encontraron recursos.</div>";
  }
  ?>

  <a href="perfil.php" class="btn btn-outline-primary mt-3">Mi Perfil</a>
  <a href="../auth/logout.php" class="btn btn-secondary mt-3">Cerrar sesión</a>
</div>
