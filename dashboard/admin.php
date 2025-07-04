<?php
require_once '../includes/sesion.php';
require_once '../config.php';

// Eliminar recurso
if (isset($_GET['eliminar_recurso'])) {
    $id = $_GET['eliminar_recurso'];
    $stmt = $pdo->prepare("DELETE FROM recursos WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit;
}

// Eliminar usuario
if (isset($_GET['eliminar_usuario'])) {
    $id = $_GET['eliminar_usuario'];
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit;
}

// Actualizar rol
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_rol'])) {
    $id = $_POST['usuario_id'];
    $nuevo_rol = $_POST['rol'];
    $stmt = $pdo->prepare("UPDATE usuarios SET rol_id = ? WHERE id = ?");
    $stmt->execute([$nuevo_rol, $id]);
    header("Location: admin.php");
    exit;
}

// Obtener datos
$recursos = $pdo->query("SELECT * FROM recursos")->fetchAll();
$usuarios = $pdo->query("SELECT u.*, r.nombre as rol FROM usuarios u JOIN roles r ON u.rol_id = r.id")->fetchAll();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2 class="mb-4">Panel del Administrador</h2>

  <h4>Recursos Educativos</h4>
  <?php foreach ($recursos as $recurso): ?>
    <div class="card mb-2 p-3">
      <h5><?= htmlspecialchars($recurso['titulo']) ?> (<?= $recurso['tipo'] ?>)</h5>
      <p><strong>Curso:</strong> <?= htmlspecialchars($recurso['curso']) ?> | <strong>Categoría:</strong> <?= htmlspecialchars($recurso['categoria']) ?></p>
      <a href="?eliminar_recurso=<?= $recurso['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este recurso?')">Eliminar</a>
    </div>
  <?php endforeach; ?>

  <hr class="my-4">

  <h4>Gestión de Usuarios</h4>
  <table class="table table-bordered">
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
              <select name="rol" class="form-select form-select-sm w-auto">
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

  <a href="../auth/logout.php" class="btn btn-secondary mt-4">Cerrar sesión</a>
</div>
