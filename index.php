
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recursos Educativos UTP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/estilo.css">
</head>
<body>

  <div class="container hero">
    <h1>Plataforma de Recursos Educativos UTP</h1>
    <p>Docentes y estudiantes conectados para compartir y acceder a materiales educativos.</p>
    <div class="mt-4">
      <a href="auth/login.php" class="btn btn-custom me-3">Iniciar Sesión</a>
      <a href="auth/register.php" class="btn btn-custom">Registrarse</a>
    </div>
  </div>
<?php include 'includes/chatbot.php'; ?>
</body>
</html>
