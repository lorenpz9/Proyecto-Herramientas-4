<?php
require_once '../includes/sesion.php';
require_once '../config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM recursos WHERE id = ? AND docente_id = ?");
$stmt->execute([$id, $_SESSION['usuario']['id']]);
$recurso = $stmt->fetch();

if (!$recurso) {
    echo "Recurso no encontrado o sin permiso.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $curso = $_POST['curso'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $archivo_nombre = $recurso['archivo'];
    $enlace = $recurso['enlace'];

    if ($tipo === 'enlace') {
        $enlace = $_POST['enlace'];
        $archivo_nombre = null;
    } else {
        if ($_FILES['archivo']['error'] === 0) {
            $archivo_nombre = 'uploads/' . basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], "../" . $archivo_nombre);
            $enlace = null;
        }
    }

    $stmt = $pdo->prepare("UPDATE recursos SET titulo=?, tipo=?, archivo=?, enlace=?, descripcion=?, curso=?, categoria=? WHERE id=?");
    $stmt->execute([$titulo, $tipo, $archivo_nombre, $enlace, $descripcion, $curso, $categoria, $id]);
    header("Location: docente.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Recurso</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="text-center mb-4">Editar Recurso</h2>
  <form method="POST" enctype="multipart/form-data" class="card p-4 shadow">
    <div class="mb-3">
      <label class="form-label">Título</label>
      <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($recurso['titulo']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Tipo</label>
      <select name="tipo" class="form-select" id="tipo" required>
        <option value="documento" <?= $recurso['tipo'] === 'documento' ? 'selected' : '' ?>>Documento</option>
        <option value="video" <?= $recurso['tipo'] === 'video' ? 'selected' : '' ?>>Video</option>
        <option value="enlace" <?= $recurso['tipo'] === 'enlace' ? 'selected' : '' ?>>Enlace</option>
        <option value="ejercicio" <?= $recurso['tipo'] === 'ejercicio' ? 'selected' : '' ?>>Ejercicio</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Curso</label>
      <input type="text" name="curso" class="form-control" value="<?= htmlspecialchars($recurso['curso']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Categoría</label>
      <select name="categoria" class="form-select" required>
        <option value="Matemática" <?= $recurso['categoria'] === 'Matemática' ? 'selected' : '' ?>>Matemática</option>
        <option value="Comunicación" <?= $recurso['categoria'] === 'Comunicación' ? 'selected' : '' ?>>Comunicación</option>
        <option value="Ciencia" <?= $recurso['categoria'] === 'Ciencia' ? 'selected' : '' ?>>Ciencia</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea name="descripcion" class="form-control"><?= htmlspecialchars($recurso['descripcion']) ?></textarea>
    </div>
    <div class="mb-3" id="grupoArchivo">
      <label class="form-label">Archivo nuevo (opcional)</label>
      <input type="file" name="archivo" class="form-control">
    </div>
    <div class="mb-3" id="grupoEnlace" style="display:none;">
      <label class="form-label">Enlace</label>
      <input type="url" name="enlace" class="form-control" value="<?= htmlspecialchars($recurso['enlace']) ?>">
    </div>
    <div class="d-flex justify-content-between">
      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      <a href="docente.php" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
</div>
<script>
document.getElementById('tipo').addEventListener('change', function () {
  const tipo = this.value;
  document.getElementById('grupoArchivo').style.display = (tipo === 'enlace') ? 'none' : 'block';
  document.getElementById('grupoEnlace').style.display = (tipo === 'enlace') ? 'block' : 'none';
});
window.addEventListener('DOMContentLoaded', () => {
  document.getElementById('tipo').dispatchEvent(new Event('change'));
});
</script>
<?php include '../includes/chatbot.php'; ?>
</body>
</html>