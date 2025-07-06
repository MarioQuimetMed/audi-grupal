<?php
// Página de error personalizada
header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Impuestos Nacionales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .error-container {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }
        .error-code {
            font-size: 120px;
            color: #0B3861;
            margin-bottom: 0;
        }
        .error-message {
            font-size: 24px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container error-container">
        <img src="assets/images/logo.png" alt="Logo Impuestos Nacionales" style="max-width: 120px; margin-bottom: 30px;">
        <h1 class="error-code">404</h1>
        <h2 class="error-message">Página no encontrada</h2>
        <p class="mb-4">La página que estás buscando no existe o ha sido movida.</p>
        <a href="index.php" class="btn btn-primary">Volver al inicio</a>
    </div>
</body>
</html>
