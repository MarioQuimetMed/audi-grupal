<?php
session_start();
require_once 'db.php';

// Comprobar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Obtener información de usuario usando sentencias preparadas
$query = "SELECT * FROM usuarios WHERE id = $1";
$result = pg_query_params($conn, $query, array($user_id));
$user = pg_fetch_assoc($result);

// Registrar visita al dashboard usando sentencias preparadas
$log_query = "INSERT INTO logs (usuario_id, accion, ip_address) VALUES ($1, $2, $3)";
pg_query_params($conn, $log_query, array($user_id, 'visita_dashboard', $_SERVER['REMOTE_ADDR']));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Impuestos Nacionales</title>
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
        
        /* Estilos adicionales para el área de subida de archivos */
        .upload-area {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
            background-color: #f9f9f9;
        }
        .upload-area:hover {
            border-color: #0B3861;
            background-color: #f0f8ff;
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
                    <a href="#" class="nav-link active">
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
                    <a href="logs.php" class="nav-link">
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
                    <h4>Panel de Control</h4>
                    <div class="user-info">
                        <span class="me-2"><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($username); ?></span>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="row">
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Declaraciones</h5>
                                    <h2>3</h2>
                                    <p>Pendientes este mes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Pagos</h5>
                                    <h2>2</h2>
                                    <p>Completados</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card bg-warning text-dark">
                                <div class="card-body">
                                    <h5 class="card-title">Facturas</h5>
                                    <h2>15</h2>
                                    <p>Este período</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Notificaciones</h5>
                                    <h2>4</h2>
                                    <p>Sin leer</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Próximas Fechas Importantes</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Concepto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10/07/2025</td>
                                        <td>IVA Mensual</td>
                                        <td><span class="badge bg-warning">Pendiente</span></td>
                                    </tr>
                                    <tr>
                                        <td>15/07/2025</td>
                                        <td>IT Mensual</td>
                                        <td><span class="badge bg-warning">Pendiente</span></td>
                                    </tr>
                                    <tr>
                                        <td>30/07/2025</td>
                                        <td>RC-IVA</td>
                                        <td><span class="badge bg-warning">Pendiente</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Formulario de carga de archivos vulnerable (sin validación de tipo o extensión) -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Subir Documentación Tributaria</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="fileToUpload" class="form-label">Seleccione archivo:</label>
                                    <input type="file" class="form-control" id="fileToUpload" name="fileToUpload">
                                    <div class="form-text">Formatos permitidos: PDF, JPG, PNG (máximo 2MB)</div>
                                </div>
                                <div class="mb-3">
                                    <label for="fileDescription" class="form-label">Descripción:</label>
                                    <input type="text" class="form-control" id="fileDescription" name="fileDescription" placeholder="Describa el documento">
                                </div>
                                <button type="submit" name="upload" class="btn btn-primary">Subir Archivo</button>
                            </form>
                            <?php
                            if(isset($_POST['upload'])) {
                                // Directorio de subida con validación de tipo de archivo
                                $target_dir = "uploads/";
                                if (!file_exists($target_dir)) {
                                    mkdir($target_dir, 0755, true);
                                }
                                
                                // Validaciones de seguridad
                                $fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
                                $maxFileSize = 2 * 1024 * 1024; // 2MB máximo
                                $allowedTypes = array('pdf', 'jpg', 'jpeg', 'png');
                                $newFileName = uniqid() . '.' . $fileType; // Nombre aleatorio para evitar sobrescrituras
                                $target_file = $target_dir . $newFileName;
                                
                                // Validaciones
                                $uploadOk = 1;
                                $errorMsg = "";
                                
                                // Comprobar tamaño del archivo
                                if ($_FILES["fileToUpload"]["size"] > $maxFileSize) {
                                    $errorMsg = "El archivo es demasiado grande. Máximo 2MB permitido.";
                                    $uploadOk = 0;
                                }
                                
                                // Comprobar tipo de archivo
                                if (!in_array($fileType, $allowedTypes)) {
                                    $errorMsg = "Solo se permiten archivos PDF, JPG y PNG.";
                                    $uploadOk = 0;
                                }
                                
                                // Si todo está bien, subir el archivo
                                if ($uploadOk == 1) {
                                    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                    echo "<div class='alert alert-success mt-3'>Archivo subido correctamente a: $target_file</div>";
                                    
                                    // Registrar en logs (útil para auditoría) usando sentencias preparadas
                                    $file_desc = htmlspecialchars($_POST['fileDescription'] ?? 'Sin descripción');
                                    $log_query = "INSERT INTO logs (usuario_id, accion, ip_address, detalles) VALUES 
                                                ($1, $2, $3, $4)";
                                    pg_query_params($conn, $log_query, array($user_id, 'subida_archivo', $_SERVER['REMOTE_ADDR'], "Archivo: $target_file, Desc: $file_desc"));
                                } else {
                                    echo "<div class='alert alert-danger mt-3'>Error al subir el archivo.</div>";
                                }
                                } else {
                                    echo "<div class='alert alert-danger mt-3'>$errorMsg</div>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Sección de comentarios con vulnerabilidad XSS almacenada -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Comentarios y Notas</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Añadir comentario:</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                </div>
                                <button type="submit" name="addComment" class="btn btn-primary">Publicar</button>
                            </form>
                            
                            <hr>
                            
                            <h6>Comentarios recientes:</h6>
                            <?php
                            // Procesar nuevo comentario (sanitizado contra XSS)
                            if(isset($_POST['addComment']) && !empty($_POST['comment'])) {
                                $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8'); // Sanitizar para evitar XSS
                                $comment_query = "INSERT INTO logs (usuario_id, accion, ip_address, detalles) VALUES 
                                                 ($1, $2, $3, $4)";
                                pg_query_params($conn, $comment_query, array($user_id, 'comentario', $_SERVER['REMOTE_ADDR'], $comment));
                            }
                            
                            // Mostrar comentarios recientes (vulnerable a XSS almacenado)
                            $comments_query = "SELECT l.detalles, u.username, l.fecha 
                                               FROM logs l JOIN usuarios u ON l.usuario_id = u.id 
                                               WHERE l.accion = 'comentario' 
                                               ORDER BY l.fecha DESC LIMIT 5";
                            $comments_result = pg_query($conn, $comments_query);
                            
                            while($comment = pg_fetch_assoc($comments_result)) {
                                echo "<div class='card mb-2'>";
                                echo "<div class='card-body'>";
                                // Sanitizamos la salida para prevenir XSS
                                echo "<p>" . htmlspecialchars($comment['detalles'], ENT_QUOTES, 'UTF-8') . "</p>";
                                echo "<small class='text-muted'>Publicado por " . htmlspecialchars($comment['username'], ENT_QUOTES, 'UTF-8') . " el " . 
                                     date('d/m/Y H:i', strtotime($comment['fecha'])) . "</small>";
                                echo "</div></div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>