<?php
require_once '../includes/sesion.php';
require_once '../config.php';

if (isset($_GET['eliminar_recurso'])) {
    $id = $_GET['eliminar_recurso'];
    $stmt = $pdo->prepare("DELETE FROM recursos WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit;
}
if (isset($_GET['eliminar_usuario'])) {
    $id = $_GET['eliminar_usuario'];
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_rol'])) {
    $id = $_POST['usuario_id'];
    $nuevo_rol = $_POST['rol'];
    $stmt = $pdo->prepare("UPDATE usuarios SET rol_id = ? WHERE id = ?");
    $stmt->execute([$nuevo_rol, $id]);
    header("Location: admin.php");
    exit;
}

$recursos = $pdo->query("SELECT * FROM recursos")->fetchAll();
$usuarios = $pdo->query("SELECT u.*, r.nombre as rol FROM usuarios u JOIN roles r ON u.rol_id = r.id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    function mostrarSeccion(id) {
      document.getElementById('seccion_recursos').style.display = 'none';
      document.getElementById('seccion_usuarios').style.display = 'none';
      document.getElementById(id).style.display = 'block';
    }
  </script>
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4 text-center">Panel del Administrador</h2>

  <div class="d-flex justify-content-center mb-4 gap-3">
    <button class="btn btn-outline-primary" onclick="mostrarSeccion('seccion_recursos')">Recursos Educativos</button>
    <button class="btn btn-outline-secondary" onclick="mostrarSeccion('seccion_usuarios')">Gestión de Usuarios</button>
  </div>

  <div id="seccion_recursos" style="display:none;">
    <h4>Recursos Educativos</h4>
    <?php foreach ($recursos as $recurso): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($recurso['titulo']) ?> (<?= $recurso['tipo'] ?>)</h5>
          <p class="card-text"><strong>Curso:</strong> <?= htmlspecialchars($recurso['curso']) ?> | <strong>Categoría:</strong> <?= htmlspecialchars($recurso['categoria']) ?></p>
          <a href="../dashboard/editar_recurso.php?id=<?= $recurso['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
          <a href="?eliminar_recurso=<?= $recurso['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este recurso?')">Eliminar</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div id="seccion_usuarios" style="display:none;">
    <h4>Gestión de Usuarios</h4>
    <table class="table table-hover">
      <thead class="table-light">
        <tr>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Rol</th>
          <th>Cambiar Rol</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $usuario): ?>
          <tr>
            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
            <td><?= htmlspecialchars($usuario['correo']) ?></td>
            <td><?= htmlspecialchars($usuario['rol']) ?></td>
            <td>
              <form method="POST" class="d-flex gap-2">
                <input type="hidden" name="usuario_id" value="<?= $usuario['id'] ?>">
                <select name="rol" class="form-select form-select-sm">
                  <option value="1" <?= $usuario['rol_id'] == 1 ? 'selected' : '' ?>>Admin</option>
                  <option value="2" <?= $usuario['rol_id'] == 2 ? 'selected' : '' ?>>Docente</option>
                  <option value="3" <?= $usuario['rol_id'] == 3 ? 'selected' : '' ?>>Estudiante</option>
                </select>
                <button type="submit" name="cambiar_rol" class="btn btn-sm btn-primary">Cambiar</button>
              </form>
            </td>
            <td>
              <a href="?eliminar_usuario=<?= $usuario['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="text-center mt-4">
    <a href="../auth/logout.php" class="btn btn-secondary">Cerrar sesión</a>
  </div>
</div>
<script>
// Mostrar sección de recursos por defecto al cargar
window.onload = () => mostrarSeccion('seccion_recursos');
</script>
</body>
</html>
