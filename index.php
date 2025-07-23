<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Recursos Educativos UTP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/estilo.css" />
  <style>
    body {
      background: linear-gradient(135deg, #8b0000, #ff4c4c);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: white;
    }
    .hero {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 15px;
      padding: 40px 30px;
      max-width: 700px;
      box-shadow: 0 0 25px rgba(255, 255, 255, 0.2);
      text-align: center;
    }
    h1 {
      font-weight: 900;
      font-size: 2.8rem;
      margin-bottom: 20px;
      text-shadow: 1px 1px 8px rgba(0,0,0,0.5);
    }
    p {
      font-size: 1.2rem;
      margin-bottom: 35px;
      line-height: 1.5;
      text-shadow: 1px 1px 5px rgba(0,0,0,0.4);
    }
    .btn-custom {
      background-color: #a32a2a;
      border: none;
      padding: 12px 28px;
      font-weight: 600;
      border-radius: 30px;
      transition: background-color 0.3s ease;
      box-shadow: 0 4px 10px rgba(163, 42, 42, 0.5);
      color: white;
      text-decoration: none;
    }
    .btn-custom:hover {
      background-color: #7a1c1c;
      box-shadow: 0 6px 15px rgba(122, 28, 28, 0.7);
      color: white;
      text-decoration: none;
    }
    .info-cards {
      display: flex;
      justify-content: space-around;
      margin-top: 40px;
      gap: 20px;
      flex-wrap: wrap;
    }
    .card-info {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 12px;
      padding: 20px;
      flex: 1 1 200px;
      box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
      color: #fff;
      font-weight: 500;
      transition: background 0.3s ease;
    }
    .card-info:hover {
      background: rgba(255, 255, 255, 0.3);
      cursor: default;
    }
    .card-info h3 {
      margin-bottom: 10px;
      font-size: 1.5rem;
      font-weight: 700;
    }
  </style>
</head>
<body>

  <div class="container hero">
    <h1>Plataforma de Recursos Educativos UTP</h1>
    <p>Docentes y estudiantes conectados para compartir y acceder a materiales educativos de calidad.</p>
    <div>
      <a href="auth/login.php" class="btn btn-custom me-3">Iniciar Sesión</a>
      <a href="auth/register.php" class="btn btn-custom">Registrarse</a>
    </div>

    <div class="info-cards">
      <div class="card-info">
        <h3>Recursos Actualizados</h3>
        <p>Accede a materiales constantemente renovados para tu aprendizaje o docencia.</p>
      </div>
      <div class="card-info">
        <h3>Fácil de Usar</h3>
        <p>Interfaz intuitiva que facilita la navegación y búsqueda rápida de recursos.</p>
      </div>
      <div class="card-info">
        <h3>Comunicación Directa</h3>
        <p>Conecta con docentes y estudiantes para colaborar y compartir conocimiento.</p>
      </div>
    </div>
  </div>

  <?php include 'includes/chatbot.php'; ?>
</body>
</html>
