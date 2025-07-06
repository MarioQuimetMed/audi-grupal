<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impuestos Nacionales de Bolivia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header-bg py-3" role="banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
                    <img src="assets/images/logo.png" alt="Logo Impuestos" class="img-fluid" style="max-height: 80px;">
                </div>
                <div class="col-md-6">
                    <h1>Servicio de Impuestos Nacionales</h1>
                    <p>República de Bolivia</p>
                </div>
                <div class="col-md-4 text-end">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="dashboard.php" class="btn btn-light"><i class="bi bi-person-workspace me-2"></i>Mi Portal</a>
                        <a href="logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-light"><i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <nav class="nav nav-pills nav-fill">
                        <a class="nav-link text-white active" href="#"><i class="bi bi-house-door-fill me-1"></i>Inicio</a>
                        <a class="nav-link text-white" href="#"><i class="bi bi-info-circle-fill me-1"></i>Normativa</a>
                        <a class="nav-link text-white" href="#"><i class="bi bi-newspaper me-1"></i>Noticias</a>
                        <a class="nav-link text-white" href="#"><i class="bi bi-question-circle-fill me-1"></i>Ayuda</a>
                        <a class="nav-link text-white" href="#"><i class="bi bi-telephone-fill me-1"></i>Contacto</a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Banner Principal -->
    <section class="banner-rts">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2><i class="bi bi-check-circle-fill me-2"></i> El RTS está plenamente vigente y garantizado</h2>
                    <p class="lead"><strong>El RTS NO EMITE FACTURA</strong> y por tanto <strong>NO</strong> debe implementar ninguna modalidad.</p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="assets/images/logo.png" alt="RTS - Régimen Tributario Simplificado" class="img-fluid" style="max-width: 150px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container my-5" role="main">
        <div class="row">
            <section class="col-md-8">
                <h2>Bienvenido al Portal de Impuestos Nacionales</h2>
                <p class="lead">Sistema de información tributaria para ciudadanos y empresas</p>

                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        Servicios Principales
                    </div>
                    <div class="card-body">
                        <ul class="list-group" aria-label="Servicios principales">
                            <li class="list-group-item">Declaración de impuestos</li>
                            <li class="list-group-item">Consulta de obligaciones</li>
                            <li class="list-group-item">Certificados tributarios</li>
                            <li class="list-group-item">Facturación electrónica</li>
                        </ul>
                    </div>
                </div>
            </section>

            <aside class="col-md-4 quick-access">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-grid-fill me-2"></i> Acceso Rápido
                    </div>
                    <div class="card-body">
                        <a href="login.php" class="btn btn-primary d-block mb-3">
                            <i class="bi bi-person-circle access-icon"></i> Ingresar al Sistema
                        </a>
                        <a href="#" class="btn btn-outline-primary d-block mb-3">
                            <i class="bi bi-search access-icon"></i> Consultar NIT
                        </a>
                        <a href="#" class="btn btn-outline-primary d-block mb-3">
                            <i class="bi bi-receipt access-icon"></i> Verificar Facturas
                        </a>
                        <a href="#" class="btn btn-outline-primary d-block">
                            <i class="bi bi-calendar-check access-icon"></i> Fechas de Vencimiento
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-bg mt-5" role="contentinfo">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="bi bi-building me-2"></i>Servicio de Impuestos Nacionales</h5>
                    <address>
                        <i class="bi bi-geo-alt-fill me-2"></i>Av. Ballivián N° 1333, La Paz – Bolivia<br>
                        <i class="bi bi-telephone-fill me-2"></i>Call Center: 800-10-3444<br>
                        <i class="bi bi-envelope-fill me-2"></i>contacto@impuestos.gob.bo
                    </address>
                </div>
                <div class="col-md-4">
                    <h5><i class="bi bi-link-45deg me-2"></i>Enlaces rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white text-decoration-none"><i class="bi bi-chevron-right me-1"></i>Portal de Trámites</a></li>
                        <li><a href="#" class="text-white text-decoration-none"><i class="bi bi-chevron-right me-1"></i>Servicios en Línea</a></li>
                        <li><a href="#" class="text-white text-decoration-none"><i class="bi bi-chevron-right me-1"></i>Denuncias</a></li>
                        <li><a href="#" class="text-white text-decoration-none"><i class="bi bi-chevron-right me-1"></i>Preguntas Frecuentes</a></li>
                    </ul>
                </div>
                <div class="col-md-4 text-end">
                    <h5><i class="bi bi-info-circle-fill me-2"></i>Información</h5>
                    <p>© 2025 Todos los derechos reservados</p>
                    <small>Versión de demostración para pruebas de auditoría</small>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-4"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-twitter fs-4"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-youtube fs-4"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
