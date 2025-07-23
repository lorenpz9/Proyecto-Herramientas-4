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
      background-color: #F5F5DC;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h2, h5 {
      color: #c62828;
    }
    .card {
      border: none;
      border-left: 5px solid #e53935;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0,0,0,0.07);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 12px;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    .btn-red {
      background-color: #e53935;
      border-color: #e53935;
      color: white;
    }
    .btn-red:hover {
      background-color: #c62828;
      border-color: #b71c1c;
    }
    .btn-outline-dark:hover {
      background-color: #e53935;
      color: white;
      border-color: #e53935;
    }
    .form-control:focus, .form-select:focus {
      border-color: #e53935;
      box-shadow: 0 0 0 0.25rem rgba(229, 57, 53, 0.25);
    }
    .category-btn {
      border-radius: 20px;
    }
    .alert-warning {
      background-color: #ffe5e5;
      border-color: #f5c2c7;
      color: #b71c1c;
    }
    .search-section {
      background-color: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2 class="text-center mb-4">¡Bienvenido Estudiante!</h2>

  <div class="search-section mb-4">
    <form method="GET" class="row g-3">
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
        <button type="submit" class="btn btn-red w-100">Buscar</button>
      </div>
    </form>
  </div>

  <div class="mb-4 text-center">
    <h5>Ver por categoría:</h5>
    <a href="../recursos/recursos_matematica.php" class="btn btn-outline-dark btn-sm me-2 category-btn">Matemática</a>
    <a href="../recursos/recursos_comunicacion.php" class="btn btn-outline-dark btn-sm me-2 category-btn">Comunicación</a>
    <a href="../recursos/recursos_ciencia.php" class="btn btn-outline-dark btn-sm category-btn">Ciencia</a>
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
          echo "<h5 class='mb-2'>{$recurso['titulo']} <span class='badge bg-light text-dark'>{$recurso['tipo']}</span></h5>";
          echo "<p class='text-muted'>{$recurso['descripcion']}</p>";
          echo "<p><strong>Curso:</strong> {$recurso['curso']}<br><strong>Categoría:</strong> {$recurso['categoria']}</p>";
          if ($recurso['tipo'] === 'enlace') {
              echo "<a href='{$recurso['enlace']}' target='_blank' class='btn btn-sm btn-red'>Abrir Enlace</a>";
          } else {
              echo "<a href='../{$recurso['archivo']}' download class='btn btn-sm btn-outline-dark'>Descargar</a>";
          }
          echo "</div></div>";
      }
      echo "</div>";
  } else {
      echo "<div class='alert alert-warning text-center'>No se encontraron recursos.</div>";
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
