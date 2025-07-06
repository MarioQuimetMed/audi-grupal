<?php
session_start();
require_once 'db.php';

// Comprobar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Obtener registros de logs (vulnerabilidad: muestra todos los logs)
$query = "SELECT l.id, u.username, l.accion, l.ip_address, l.fecha 
          FROM logs l 
          JOIN usuarios u ON l.usuario_id = u.id 
          ORDER BY l.fecha DESC 
          LIMIT 50";
$result = pg_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial - Impuestos Nacionales</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .sidebar {
            background-color: #0B3861;
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }
        .sidebar a:hover {
            background-color: #0A2A52;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .active {
            background-color: #0A2A52;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <h4 class="text-center mb-4">Impuestos Nacionales</h4>
                <nav class="nav flex-column">
                    <a href="dashboard.php" class="nav-link">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-file-earmark-text"></i> Mis Declaraciones
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-credit-card"></i> Pagos
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-receipt"></i> Facturas
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-calendar-check"></i> Calendario Fiscal
                    </a>
                    <a href="logs.php" class="nav-link active">
                        <i class="bi bi-clock-history"></i> Historial
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-gear"></i> Configuración
                    </a>
                    <a href="logout.php" class="nav-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 content">
                <div class="header d-flex justify-content-between align-items-center">
                    <h4>Historial de Actividad</h4>
                    <div class="user-info">
                        <span class="me-2"><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Registros recientes</h5>
                                <form class="d-flex">
                                    <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario</th>
                                            <th>Acción</th>
                                            <th>IP</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($log = pg_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?php echo $log['id']; ?></td>
                                            <td><?php echo htmlspecialchars($log['username']); ?></td>
                                            <td><?php echo htmlspecialchars($log['accion']); ?></td>
                                            <td><?php echo htmlspecialchars($log['ip_address']); ?></td>
                                            <td><?php echo date('d/m/Y H:i:s', strtotime($log['fecha'])); ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>