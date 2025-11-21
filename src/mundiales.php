<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mundiales FIFA - Historia y Publicaciones</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/base.css" rel="stylesheet">
    <link href="assets/css/mundiales.css" rel="stylesheet">
</head>
<body>
<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si hay sesión activa
$sesionActiva = isset($_SESSION['usuario_id']);

// ========== CARGAR MUNDIALES DESDE BASE DE DATOS ==========
require_once __DIR__ . '/../backend/controllers/MundialController.php';

$mundialController = new MundialController();
$mundiales = $mundialController->listar();

// Si no hay mundiales, inicializar array vacío
if ($mundiales === false || !is_array($mundiales)) {
    $mundiales = [];
}

// Detectar página actual para navbar
$currentPage = basename($_SERVER['PHP_SELF']);
?>
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
                <?php if ($sesionActiva): ?>
                    <!-- Usuario CON sesión activa -->
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-bold" href="dashboard-usuario.php" style="cursor: pointer;">
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
                        <a class="nav-link btn-outline-danger ms-2" href="../backend/api/auth.php?accion=logout">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                        </a>
                    </li>
                    
                <?php else: ?>
                    <!-- Usuario SIN sesión -->
                    <li class="nav-item">
                        <a class="nav-link btn-outline-primary ms-2" href="login.php">
                            <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-primary text-white ms-2" href="registro.php">
                            <i class="fas fa-user-plus me-1"></i>Registrarse
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

    <!-- HERO SECTION -->
    <section class="hero-section-mundiales">
        <div class="hero-particles"></div>
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10">
                    <div class="hero-content-mundiales">
                        <div class="hero-badge">
                            <i class="fas fa-trophy me-2"></i> Selecciona un Mundial
                        </div>
                        <h1 class="hero-title-mundiales">
                            ELIGE TU<br>
                            <span class="text-gradient-mundial">MUNDIAL FAVORITO</span>
                        </h1>
                        <p class="hero-subtitle-mundiales">
                            Explora las publicaciones, jugadas legendarias y momentos inolvidables de cada Copa del Mundo
                        </p>
                        
                        <!-- Filtros -->
                        <div class="filters-container mt-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="filter-group">
                                        <label class="filter-label">Año</label>
                                        <select class="filter-select" id="filterPais">
                                            <option value="todos">Todos los años</option>
                                            <?php 
                                            // Generar opciones de años dinámicamente
                                            $aniosUnicos = array_unique(array_column($mundiales, 'Anio'));
                                            rsort($aniosUnicos);
                                            foreach ($aniosUnicos as $anio): 
                                            ?>
                                                <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="filter-group">
                                        <label class="filter-label">País Sede</label>
                                        <select class="filter-select" id="sortSelect">
                                            <option value="cronologico">Más reciente</option>
                                            <option value="cronologico-asc">Más antiguo</option>
                                            <option value="pais">Por país (A-Z)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="filter-group">
                                        <label class="filter-label">Buscar</label>
                                        <input type="text" class="filter-select" id="searchMundial" placeholder="Buscar mundial...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MUNDIALES GRID -->
    <section class="mundiales-section">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title">MUNDIALES FIFA</h2>
                <p class="section-description">
                    <?php echo count($mundiales); ?> mundiales disponibles
                </p>
            </div>

            <!-- Mensaje sin resultados (oculto por defecto) -->
            <div id="noResults" class="alert alert-info text-center" style="display: none;">
                <i class="fas fa-search me-2"></i> No se encontraron mundiales con esos filtros
            </div>

            <div class="row g-4" id="mundialesContainer">
                <?php if (empty($mundiales)): ?>
                    <!-- No hay mundiales -->
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            No hay mundiales registrados aún
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($mundiales as $mundial): ?>
                        <?php
                        // Convertir Logo BLOB a Base64
                        $logoBase64 = '';
                        if (!empty($mundial['Logo'])) {
                            $logoBase64 = base64_encode($mundial['Logo']);
                        }
                        
                        // Imagen por defecto si no hay logo
                        $imagenSrc = !empty($logoBase64) 
                            ? "data:image/jpeg;base64,{$logoBase64}" 
                            : "https://via.placeholder.com/800x600?text=" . urlencode($mundial['Nombre']);
                        ?>
                        
                        <!-- Card de Mundial -->
                        <div class="col-lg-4 col-md-6 mundial-item" 
                             data-year="<?php echo $mundial['Anio']; ?>"
                             data-pais="<?php echo strtolower($mundial['Sede']); ?>"
                             data-likes="0"
                             data-comments="0">
                            <a href="muro.php?id_mundial=<?php echo $mundial['id_Mundial']; ?>" class="mundial-card-link">
                                <div class="mundial-card">
                                    <div class="mundial-image">
                                        <img src="<?php echo $imagenSrc; ?>" 
                                             alt="<?php echo htmlspecialchars($mundial['Nombre']); ?>"
                                             onerror="this.src='https://via.placeholder.com/800x600?text=Mundial+FIFA'">
                                        <div class="mundial-overlay">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                    </div>
                                    <div class="mundial-content">
                                        <div class="mundial-badge-year"><?php echo $mundial['Anio']; ?></div>
                                        <h3 class="mundial-title"><?php echo htmlspecialchars($mundial['Nombre']); ?></h3>
                                        <p class="mundial-description">
                                            <i class="fas fa-map-marker-alt me-2"></i><?php echo htmlspecialchars($mundial['Sede']); ?>
                                        </p>
                                        <?php if (!empty($mundial['Descripcion'])): ?>
                                            <p class="mundial-description text-muted small">
                                                <?php echo htmlspecialchars(substr($mundial['Descripcion'], 0, 100)); ?>
                                                <?php if (strlen($mundial['Descripcion']) > 100) echo '...'; ?>
                                            </p>
                                        <?php endif; ?>
                                        <div class="mundial-stats">
                                            <span><i class="fas fa-images me-1"></i> Ver publicaciones</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer pb-2 pt-4">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/mundiales.js"></script>
</body>
</html>