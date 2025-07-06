<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impuestos Nacionales de Bolivia</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header-bg {
            background-color: #0B3861;
            color: white;
        }
        .footer-bg {
            background-color: #0B3861;
            color: white;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-bg py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>Servicio de Impuestos Nacionales</h1>
                    <p>República de Bolivia</p>
                </div>
                <div class="col-md-4 text-end">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="dashboard.php" class="btn btn-light">Mi Portal</a>
                        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-light">Iniciar Sesión</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Bienvenido al Portal de Impuestos Nacionales</h2>
                <p class="lead">Sistema de información tributaria para ciudadanos y empresas</p>
                
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        Servicios Principales
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Declaración de impuestos</li>
                            <li class="list-group-item">Consulta de obligaciones</li>
                            <li class="list-group-item">Certificados tributarios</li>
                            <li class="list-group-item">Facturación electrónica</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Acceso Rápido
                    </div>
                    <div class="card-body">
                        <a href="login.php" class="btn btn-primary d-block mb-3">Ingresar al Sistema</a>
                        <a href="#" class="btn btn-outline-secondary d-block mb-3">Consultar NIT</a>
                        <a href="#" class="btn btn-outline-secondary d-block">Verificar Facturas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-bg mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Servicio de Impuestos Nacionales</h5>
                    <p>Av. Ballivan N° 1333, La Paz - Bolivia</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>© 2025 Todos los derechos reservados</p>
                    <small>Versión de demostración para pruebas de auditoría</small>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>