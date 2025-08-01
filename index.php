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

  <div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="container hero text-center">
      <h1>Plataforma de Recursos Educativos UTP</h1>
      <p>Docentes y estudiantes conectados para compartir y acceder a materiales educativos.</p>
      <div class="mt-4">
        <a href="auth/login.php" class="btn btn-custom me-3">Iniciar Sesión</a>
        <a href="auth/register.php" class="btn btn-custom">Registrarse</a>
      </div>
    </div>
  </div>

  <!-- Chatbot Landbot -->
  <script>
    window.addEventListener('mouseover', initLandbot, { once: true });
    window.addEventListener('touchstart', initLandbot, { once: true });
    var myLandbot;
    function initLandbot() {
      if (!myLandbot) {
        var s = document.createElement('script');
        s.type = "module";
        s.async = true;
        s.addEventListener('load', function() {
          myLandbot = new Landbot.Livechat({
            configUrl: 'https://storage.googleapis.com/landbot.online/v3/H-2957355-52VTQJ5O5XG386QE/index.json',
          });
        });
        s.src = 'https://cdn.landbot.io/landbot-3/landbot-3.0.0.mjs';
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
      }
    }
  </script>
</body>
</html>