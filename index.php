<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Recursos Educativos UTP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/estilo.css" />
  <style>
    /* Reset y base */
    body, html {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #8B0000 0%, #cc0000 100%);
      color: #fff;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Contenedor principal */
    .main-container {
      flex: 1;
      max-width: 900px;
      margin: 3rem auto 2rem auto;
      background-color: rgba(255, 255, 255, 0.1);
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.5);
      text-align: center;
    }

    h1 {
      font-size: 3.2rem;
      font-weight: 900;
      margin-bottom: 1rem;
      text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
      letter-spacing: 2px;
    }

    p.lead {
      font-size: 1.3rem;
      margin-bottom: 2rem;
      font-weight: 500;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }

    /* Botones dorados */
    .btn-custom {
      background-color: #D4AF37;
      color: #000;
      font-weight: 600;
      border-radius: 50px;
      padding: 12px 28px;
      font-size: 1.1rem;
      transition: background-color 0.3s ease;
      box-shadow: 0 3px 8px rgba(212, 175, 55, 0.6);
      border: none;
      margin: 0 12px;
      min-width: 140px;
    }

    .btn-custom:hover,
    .btn-custom:focus {
      background-color: #bfa332;
      color: #000;
      box-shadow: 0 5px 15px rgba(191, 163, 50, 0.8);
    }

    /* Sección extra */
    .extra-section {
      background-color: #f5f5dcdd;
      color: #333;
      max-width: 900px;
      margin: 3rem auto 4rem auto;
      padding: 30px 25px;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
      text-align: left;
      font-size: 1.15rem;
      line-height: 1.6;
    }

    .extra-section h3 {
      margin-bottom: 1.2rem;
      color: #8B0000;
      font-weight: 700;
      text-align: center;
    }

    .extra-section ul {
      padding-left: 20px;
      list-style: none;
    }

    .extra-section ul li {
      margin-bottom: 0.8rem;
      padding-left: 1.5rem;
      position: relative;
      font-weight: 600;
      color: #5a4d00;
    }

    /* Iconos en lista */
    .extra-section ul li::before {
      content: "📁";
      position: absolute;
      left: 0;
    }
    .extra-section ul li:nth-child(2)::before {
      content: "📚";
    }
    .extra-section ul li:nth-child(3)::before {
      content: "👨‍🏫";
    }

    /* Header */
    header {
      background-color: #5a0000;
      padding: 15px 0;
      text-align: center;
      color: #ffffffff;
      font-size: 1.8rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-shadow: 0 0 5px #ffffffff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.5);
    }

    /* Footer */
    footer {
      background-color: #5a0000;
      padding: 12px 0;
      text-align: center;
      color: #ccc;
      font-size: 0.9rem;
      box-shadow: 0 -2px 8px rgba(0,0,0,0.5);
      margin-top: auto;
    }
    @media (max-width: 600px) {
      body {
        background: linear-gradient(135deg, #8B0000, #a00000);
      }
      .main-container, .extra-section {
        margin: 2rem 1rem;
        padding: 25px 15px;
      }
      .btn-custom {
        width: 100%;
        margin: 8px 0;
        min-width: auto;
      }
      .chatbot-container {
        max-width: 90vw;
        right: 5%;
        bottom: 10px;
        max-height: 300px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <header>
    Recursos Educativos UTP
  </header>

  <main class="main-container">
    <h1>Plataforma de Recursos Educativos UTP</h1>
    <p class="lead">Docentes y estudiantes conectados para compartir y acceder a materiales educativos.</p>
    <div class="d-flex justify-content-center flex-wrap gap-3">
      <a href="auth/login.php" class="btn btn-custom">Iniciar Sesión</a>
      <a href="auth/register.php" class="btn btn-custom">Registrarse</a>
    </div>
  </main>

  <section class="extra-section shadow">
    <h3>¿Qué puedes hacer aquí?</h3>
    <ul>
      <li>Subir y descargar recursos educativos</li>
      <li>Consultar materiales según curso o categoría</li>
      <li>Acceso diferenciado para docentes y estudiantes</li>
    </ul>
  </section>

  <div class="chatbot-container shadow">
    <?php include 'includes/chatbot.php'; ?>
  </div>

  <footer>
    &copy; 2025 Universidad Tecnológica del Perú - Todos los derechos reservados
  </footer>
</body>
</html>
