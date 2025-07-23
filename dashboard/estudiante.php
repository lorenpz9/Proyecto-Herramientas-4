<?php
require_once '../includes/sesion.php';
require_once '../config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Estudiante</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      border: 1px solid #ddd;
      border-left: 5px solid #dc3545;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      transition: transform 0.2s ease;
    }
    .card:hover {
      transform: scale(1.02);
    }
    h2, h5 {
      color: #dc3545;
    }
    .btn-primary, .btn-success {
      background-color: #dc3545;
      border-color: #dc3545;
    }
    .btn-primary:hover, .btn-success:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }
    .form-control:focus, .form-select:focus {
      border-color: #dc3545;
      box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }
    .btn-outline-dark:hover {
      background-color: #dc3545;
      color: white;
      border-color: #dc3545;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2 class="text-center mb-4">¡Bienvenido Estudiante!</h2>

  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
      <input type="text" name="buscar" class="form-control" placeholder="Buscar por título" value="<?= $_GET['buscar'] ?? '' ?>">
    </div>
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
      <button type="submit" class="btn btn-success w-100">Buscar</button>
    </div>
  </form>

  <div class="mb-4">
    <h5>Ver por categoría:</h5>
    <a href="../recursos/recursos_matematica.php" class="btn btn-outline-dark btn-sm me-2">Matemática</a>
    <a href="../recursos/recursos_comunicacion.php" class="btn btn-outline-dark btn-sm me-2">Comunicación</a>
    <a href="../recursos/recursos_ciencia.php" class="btn btn-outline-dark btn-sm">Ciencia</a>
  </div>

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
      echo "<div class='row'>";
      foreach ($recursos as $recurso) {
          echo "<div class='col-md-4 mb-4'>";
          echo "<div class='card h-100 p-3'>";
          echo "<h5>{$recurso['titulo']} ({$recurso['tipo']})</h5>";
          echo "<p>{$recurso['descripcion']}</p>";
          echo "<p><strong>Curso:</strong> {$recurso['curso']}<br><strong>Categoría:</strong> {$recurso['categoria']}</p>";
          if ($recurso['tipo'] === 'enlace') {
              echo "<a href='{$recurso['enlace']}' target='_blank' class='btn btn-sm btn-primary'>Abrir Enlace</a>";
          } else {
              echo "<a href='../{$recurso['archivo']}' download class='btn btn-sm btn-success'>Descargar</a>";
          }
          echo "</div></div>";
      }
      echo "</div>"; // Fin row
  } else {
      echo "<div class='alert alert-warning'>No se encontraron recursos.</div>";
  }
  ?>

  <div class="text-center mt-4">
    <a href="perfil.php" class="btn btn-outline-primary me-2">Mi Perfil</a>
    <a href="../auth/logout.php" class="btn btn-secondary">Cerrar sesión</a>
  </div>
  <br>
</div>
<?php include '../includes/chatbot.php'; ?>
</body>
</html>