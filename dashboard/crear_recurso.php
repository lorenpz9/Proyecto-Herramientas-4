<?php
require_once '../includes/sesion.php';
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $curso = $_POST['curso'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $docente_id = $_SESSION['usuario']['id'];

    $archivo_nombre = null;
    $enlace = null;

    if ($tipo === 'enlace') {
        $enlace = $_POST['enlace'];
    } else {
        if ($_FILES['archivo']['error'] === 0) {
            $archivo_nombre = 'uploads/' . basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], "../" . $archivo_nombre);
        }
    }

    $stmt = $pdo->prepare("INSERT INTO recursos (docente_id, titulo, tipo, archivo, enlace, descripcion, curso, categoria)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$docente_id, $titulo, $tipo, $archivo_nombre, $enlace, $descripcion, $curso, $categoria]);
    header("Location: docente.php");
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2>Nuevo Recurso Educativo</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Título</label>
      <input type="text" name="titulo" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Tipo de recurso</label>
      <select name="tipo" class="form-select" id="tipo" required>
        <option value="documento">Documento</option>
        <option value="video">Video</option>
        <option value="enlace">Enlace</option>
        <option value="ejercicio">Ejercicio</option>
      </select>
    </div>

    <div class="mb-3">
      <label>Curso</label>
      <input type="text" name="curso" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Categoría</label>
      <select name="categoria" class="form-select" required>
        <option value="Matemática">Matemática</option>
        <option value="Comunicación">Comunicación</option>
        <option value="Ciencia">Ciencia</option>
      </select>
    </div>

    <div class="mb-3">
      <label>Descripción</label>
      <textarea name="descripcion" class="form-control"></textarea>
    </div>

    <div class="mb-3" id="grupoArchivo">
      <label>Archivo</label>
      <input type="file" name="archivo" class="form-control">
    </div>

    <div class="mb-3" id="grupoEnlace" style="display:none;">
      <label>Enlace</label>
      <input type="url" name="enlace" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Guardar recurso</button>
    <a href="docente.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<script>
document.getElementById('tipo').addEventListener('change', function () {
  const tipo = this.value;
  document.getElementById('grupoArchivo').style.display = (tipo === 'enlace') ? 'none' : 'block';
  document.getElementById('grupoEnlace').style.display = (tipo === 'enlace') ? 'block' : 'none';
});
</script>
