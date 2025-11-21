<?php
// Iniciar sesión
session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php?error=Debes iniciar sesión');
    exit();
}

// Cargar controlador de perfil
require_once __DIR__ . '/../backend/controllers/PerfilController.php';
require_once __DIR__ . '/../backend/models/Multimedia.php';

$perfilController = new PerfilController();
$multimediaModel = new Multimedia();

// Obtener datos del perfil
$perfil = $perfilController->obtenerPerfil();

// Obtener publicaciones del usuario
$publicaciones = $perfilController->obtenerPublicaciones('todas');

// Calcular estadísticas
$totalPublicaciones = isset($perfil['Total_Publicaciones']) ? $perfil['Total_Publicaciones'] : 0;
$totalLikes = isset($perfil['Total_Likes_Recibidos']) ? $perfil['Total_Likes_Recibidos'] : 0;

// Contar publicaciones por estatus
$publicacionesAprobadas = 0;
$publicacionesPendientes = 0;
foreach ($publicaciones as $pub) {
    if ($pub['Estatus'] == 'Aprobada') $publicacionesAprobadas++;
    if ($pub['Estatus'] == 'Pendiente') $publicacionesPendientes++;
}

// Detectar página actual para navbar
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Dashboard - Mundiales FIFA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/dashboard-usuario.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="index.php">
                <img src="assets/logov3.png" alt="Logo FIFA Mundiales" style="height: 48px; vertical-align: middle;">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto" style="flex-direction: row; justify-content: center; width: 100%;">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>" href="index.php">
                            <i class="fas fa-home me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'mundiales.php') ? 'active' : ''; ?>" href="mundiales.php">
                            <i class="fas fa-globe me-1"></i>Mundiales
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto" style="flex-direction: row;">
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-bold <?php echo ($currentPage == 'dashboard-usuario.php') ? 'active' : ''; ?>" href="dashboard-usuario.php" style="cursor: pointer;">
                            <i class="fas fa-user-circle me-1"></i>
                            <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
                        </a>
                    </li>
                    
                    <?php if ($_SESSION['usuario_tipo'] == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link btn-outline-warning ms-2" href="dashboard-admin.php">
                                <i class="fas fa-user-shield me-1"></i>Panel Admin
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link btn-danger text-white ms-2" href="../backend/api/auth.php?accion=logout">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <!-- User Profile Card -->
                        <div class="user-profile-card">
                            <div class="profile-avatar">
                                <?php 
                                // Verificar si Foto contiene datos binarios (BLOB) o es un string
                                if (!empty($perfil['Foto']) && $perfil['Foto'] !== 'Default.jpg' && strlen($perfil['Foto']) > 100): 
                                ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($perfil['Foto']); ?>" alt="Usuario" id="profileImg">
                                <?php else: ?>
                                    <img src="assets/default-user.jpg" alt="Usuario" id="profileImg">
                                <?php endif; ?>
                            </div>
                            <h5 class="profile-name" id="userName"><?php echo htmlspecialchars($perfil['Nombre']); ?></h5>
                            <span class="profile-role"><?php echo $perfil['Tipo_Usuario'] == 1 ? 'Administrador' : 'Usuario'; ?></span>
                            <div class="profile-stats mt-3">
                                <div class="stat-item">
                                    <strong id="totalPublicaciones"><?php echo $totalPublicaciones; ?></strong>
                                    <span>Publicaciones</span>
                                </div>
                                <div class="stat-item">
                                    <strong id="totalLikes"><?php echo $totalLikes; ?></strong>
                                    <span>Likes</span>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Menu -->
                        <nav class="sidebar-menu">
                            <a href="#" class="menu-item active" data-section="publicaciones">
                                <i class="fas fa-images"></i>
                                <span>Mis Publicaciones</span>
                            </a>
                            <a href="#" class="menu-item" data-section="perfil">
                                <i class="fas fa-user-edit"></i>
                                <span>Editar Perfil</span>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="dashboard-content">

                        <!-- Publicaciones Section -->
                        <section id="publicaciones" class="content-section active">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-images"></i>
                                    Mis Publicaciones
                                </h3>
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" class="form-control" placeholder="Buscar publicaciones..." id="searchPublicaciones">
                                </div>
                            </div>

                            <!-- Filter Tabs -->
                            <div class="filter-tabs">
                                <button class="tab-item active" data-status="todas">
                                    Todas <span class="badge"><?php echo count($publicaciones); ?></span>
                                </button>
                                <button class="tab-item" data-status="Aprobada">
                                    Aprobadas <span class="badge"><?php echo $publicacionesAprobadas; ?></span>
                                </button>
                                <button class="tab-item" data-status="Pendiente">
                                    Pendientes <span class="badge"><?php echo $publicacionesPendientes; ?></span>
                                </button>
                            </div>

                            <!-- Publications Grid -->
                            <div class="publications-grid" id="publicationsGrid">
                                <?php if (empty($publicaciones)): ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        No tienes publicaciones aún. ¡Crea tu primera publicación desde la página de mundiales!
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($publicaciones as $pub): ?>
                                        <?php 
                                        // Obtener primera imagen de la publicación
                                        $imagen = $multimediaModel->obtenerPrimeraImagen($pub['id_Publicacion']);
                                        
                                        // Detectar tipo de archivo multimedia
                                        $esVideo = false;
                                        if ($imagen && !empty($imagen['Nombre_Archivo'])) {
                                            $extension = strtolower(pathinfo($imagen['Nombre_Archivo'], PATHINFO_EXTENSION));
                                            $esVideo = in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm']);
                                        }
                                        ?>
                                        <div class="publication-card" data-status="<?php echo $pub['Estatus']; ?>">
                                            <div class="publication-image">
                                                <?php if ($imagen && !empty($imagen['File'])): ?>
                                                    <?php if ($esVideo): ?>
                                                        <video controls style="width: 100%; height: 100%; object-fit: cover;">
                                                            <source src="data:video/mp4;base64,<?php echo base64_encode($imagen['File']); ?>" type="video/mp4">
                                                            Tu navegador no soporta videos.
                                                        </video>
                                                    <?php else: ?>
                                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($imagen['File']); ?>" alt="Publicación">
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <img src="assets/mundial-placeholder.jpg" alt="Publicación">
                                                <?php endif; ?>
                                                <span class="status-badge <?php 
                                                    echo $pub['Estatus'] == 'Aprobada' ? 'approved' : 
                                                        ($pub['Estatus'] == 'Pendiente' ? 'pending' : 'rejected'); 
                                                ?>">
                                                    <i class="fas <?php 
                                                        echo $pub['Estatus'] == 'Aprobada' ? 'fa-check-circle' : 
                                                            ($pub['Estatus'] == 'Pendiente' ? 'fa-clock' : 'fa-times-circle'); 
                                                    ?>"></i> <?php echo $pub['Estatus']; ?>
                                                </span>
                                            </div>
                                            <div class="publication-content">
                                                <h5><?php echo htmlspecialchars($pub['Titulo']); ?></h5>
                                                <div class="publication-meta">
                                                    <span><i class="fas fa-globe"></i> <?php echo htmlspecialchars($pub['Mundial_Nombre']); ?></span>
                                                    <span><i class="fas fa-folder"></i> <?php echo htmlspecialchars($pub['Categorias'] ?: 'Sin categoría'); ?></span>
                                                </div>
                                                <?php if ($pub['Estatus'] == 'Aprobada'): ?>
                                                    <div class="publication-stats">
                                                        <span><i class="fas fa-heart text-danger"></i> <?php echo $pub['Total_Likes']; ?> likes</span>
                                                        <span><i class="fas fa-comment text-info"></i> <?php echo $pub['Total_Comentarios']; ?> comentarios</span>
                                                        <span><i class="fas fa-eye text-secondary"></i> <?php echo $pub['Views']; ?> vistas</span>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="publication-stats">
                                                        <span class="text-muted">
                                                            <?php echo $pub['Estatus'] == 'Pendiente' ? 'En espera de aprobación' : 'Publicación rechazada'; ?>
                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </section>

                        <!-- Perfil Section -->
                        <section id="perfil" class="content-section">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-user-edit"></i>
                                    Editar Mi Perfil
                                </h3>
                            </div>

                            <?php if (isset($_GET['success'])): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($_GET['success']); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_GET['error'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($_GET['error']); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <form id="formEditarPerfil" action="../backend/api/perfil.php" method="POST" enctype="multipart/form-data" class="profile-form">
                                <input type="hidden" name="accion" value="actualizar_perfil">
                                
                                <div class="row">
                                    <!-- Foto de Perfil -->
                                    <div class="col-md-12 mb-4">
                                        <div class="profile-photo-section">
                                            <div class="profile-photo-preview">
                                                <?php 
                                                // Verificar si Foto contiene datos binarios (BLOB) o es un string
                                                if (!empty($perfil['Foto']) && $perfil['Foto'] !== 'Default.jpg' && strlen($perfil['Foto']) > 100): 
                                                ?>
                                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($perfil['Foto']); ?>" alt="Foto de perfil" id="photoPreview">
                                                <?php else: ?>
                                                    <img src="assets/default-user.jpg" alt="Foto de perfil" id="photoPreview">
                                                <?php endif; ?>
                                            </div>
                                            <div class="profile-photo-upload">
                                                <h5>Foto de Perfil</h5>
                                                <p class="text-muted">Formato JPG, PNG. Tamaño máximo 5MB.</p>
                                                <input type="file" class="form-control" id="fotoPerfil" name="foto" accept="image/*">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Información Personal -->
                                    <div class="col-12 mb-3">
                                        <h5 class="section-subtitle">
                                            <i class="fas fa-id-card"></i> Información Personal
                                        </h5>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="nombreCompleto" class="form-label">
                                            <i class="fas fa-user"></i> Nombre Completo *
                                        </label>
                                        <input type="text" class="form-control" id="nombreCompleto" name="nombre" 
                                               value="<?php echo htmlspecialchars($perfil['Nombre']); ?>" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="fechaNacimiento" class="form-label">
                                            <i class="fas fa-calendar"></i> Fecha de Nacimiento *
                                        </label>
                                        <input type="date" class="form-control" id="fechaNacimiento" name="fecha_nacimiento" 
                                               value="<?php echo $perfil['Fecha_Nacimiento']; ?>" required>
                                        <small class="form-text text-muted">Debes ser mayor de 12 años</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="genero" class="form-label">
                                            <i class="fas fa-venus-mars"></i> Género *
                                        </label>
                                        <select class="form-select" id="genero" name="genero" required>
                                            <option value="Masculino" <?php echo $perfil['Genero'] == 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                                            <option value="Femenino" <?php echo $perfil['Genero'] == 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
                                            <option value="Otro" <?php echo $perfil['Genero'] == 'Otro' ? 'selected' : ''; ?>>Otro</option>
                                        </select>
                                    </div>

<div class="col-md-6 mb-3">
    <label for="pais_nacimiento" class="form-label">
        <i class="fas fa-map-marker-alt"></i> País de Nacimiento *
    </label>
    <select class="form-select" name="pais_nacimiento" id="pais_nacimiento" 
            data-value="<?php echo isset($usuario['Pais_Nacimiento']) ? htmlspecialchars($usuario['Pais_Nacimiento']) : ''; ?>" required>
        <option value="">Cargando países...</option>
    </select>
    <small class="form-text text-muted">
        <i class="fas fa-info-circle"></i> Al cambiar el país, se actualizará tu nacionalidad
    </small>
</div>

<div class="col-md-6 mb-3">
    <label for="nacionalidad" class="form-label">
        <i class="fas fa-flag"></i> Nacionalidad *
    </label>
    <input type="text" class="form-control" name="nacionalidad" id="nacionalidad" 
           value="<?php echo isset($usuario['Nacionalidad']) ? htmlspecialchars($usuario['Nacionalidad']) : ''; ?>" 
           placeholder="Se completará automáticamente" readonly required>
    <small class="form-text text-muted">
        <i class="fas fa-magic"></i> Este campo se actualiza automáticamente
    </small>
</div>

                                    <div class="col-md-6 mb-3">
                                        <label for="correoElectronico" class="form-label">
                                            <i class="fas fa-envelope"></i> Correo Electrónico
                                        </label>
                                        <input type="email" class="form-control" id="correoElectronico" 
                                               value="<?php echo htmlspecialchars($perfil['Correo']); ?>" disabled>
                                        <small class="form-text text-muted">El correo no puede ser modificado</small>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save"></i> Guardar Cambios
                                        </button>
                                        <button type="reset" class="btn btn-secondary btn-lg ms-2">
                                            <i class="fas fa-undo"></i> Restablecer
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Cambio de Contraseña -->
                            <div class="mt-5">
                                <div class="col-12 mb-3">
                                    <h5 class="section-subtitle">
                                        <i class="fas fa-lock"></i> Cambiar Contraseña
                                    </h5>
                                </div>

                                <form id="formCambiarContrasena" action="../backend/api/perfil.php" method="POST">
                                    <input type="hidden" name="accion" value="cambiar_contrasena">
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="contrasenaActual" class="form-label">
                                                <i class="fas fa-lock"></i> Contraseña Actual *
                                            </label>
                                            <input type="password" class="form-control" id="contrasenaActual" name="contrasena_actual" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="contrasenaNueva" class="form-label">
                                                <i class="fas fa-lock"></i> Nueva Contraseña *
                                            </label>
                                            <input type="password" class="form-control" id="contrasenaNueva" name="contrasena_nueva" required>
                                            <small class="form-text text-muted">Mínimo 8 caracteres, una mayúscula y un número</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="contrasenaConfirmar" class="form-label">
                                                <i class="fas fa-lock"></i> Confirmar Nueva Contraseña *
                                            </label>
                                            <input type="password" class="form-control" id="contrasenaConfirmar" name="contrasena_confirmar" required>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <button type="submit" class="btn btn-warning btn-lg">
                                                <i class="fas fa-key"></i> Cambiar Contraseña
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer pb-2 pt-4" id="main-footer">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="text-white">FIFA Mundiales</h5>
                    <p class="text-white-50 mb-0">Proyecto académico - Bases de Datos Multimedia</p>
                    <p class="text-white-50">UANL - Facultad de Ciencias Físico Matemáticas</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <p class="text-white-50 mt-2 mb-0">&copy; 2025 FIFA Mundiales. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- API de Países y Nacionalidades -->
    <script src="assets/js/countries-api.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dashboard-usuario.js"></script>
</body>
</html>