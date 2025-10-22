<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería - FIFA Mundiales</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/base.css" rel="stylesheet">
    <link href="assets/css/galeria.css" rel="stylesheet">
</head>
<body>
<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si hay sesión activa
$sesionActiva = isset($_SESSION['usuario_id']);
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
                    <a class="nav-link active" href="index.php"><i class="fas fa-home me-1"></i>Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mundiales.php"><i class="fas fa-globe me-1"></i>Mundiales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="galeria.php"><i class="fas fa-images me-1"></i>Galería</a>
                </li>
            </ul>
            
            <ul class="navbar-nav ms-auto" style="flex-direction: row;">
                <?php if ($sesionActiva): ?>
                    <!-- Usuario CON sesión activa -->
                    <li class="nav-item">
                        <span class="nav-link text-primary fw-bold">
                            <i class="fas fa-user-circle me-1"></i>
                            <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
                        </span>
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

    <!-- HERO SECTION GALERÍA -->
    <section class="hero-galeria">
        <div class="hero-overlay-galeria"></div>
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <div class="hero-content-galeria">
                        <div class="hero-icon-galeria">
                            <i class="fas fa-camera-retro"></i>
                        </div>
                        <h1 class="hero-title-galeria">
                            GALERÍA MULTIMEDIA
                        </h1>
                        <p class="hero-subtitle-galeria">
                            Explora imágenes y videos icónicos de la historia de los mundiales
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FILTROS DE GALERÍA -->
    <section class="gallery-filters-section">
        <div class="container">
            <div class="filters-tabs">
                <button class="filter-tab active" data-filter="all">
                    <i class="fas fa-th me-2"></i>Todo
                </button>
                <button class="filter-tab" data-filter="images">
                    <i class="fas fa-image me-2"></i>Imágenes
                </button>
                <button class="filter-tab" data-filter="videos">
                    <i class="fas fa-video me-2"></i>Videos
                </button>
                <button class="filter-tab" data-filter="highlights">
                    <i class="fas fa-star me-2"></i>Destacados
                </button>
            </div>

            <div class="filters-options">
                <div class="filter-group-galeria">
                    <select class="filter-select-galeria" id="mundialFilterGallery">
                        <option value="">Todos los mundiales</option>
                        <option value="2022">Qatar 2022</option>
                        <option value="2018">Rusia 2018</option>
                        <option value="2014">Brasil 2014</option>
                        <option value="2010">Sudáfrica 2010</option>
                    </select>
                </div>
                <div class="filter-group-galeria">
                    <select class="filter-select-galeria" id="categoryFilterGallery">
                        <option value="">Todas las categorías</option>
                        <option value="goals">Goles</option>
                        <option value="celebrations">Celebraciones</option>
                        <option value="stadiums">Estadios</option>
                        <option value="fans">Aficionados</option>
                    </select>
                </div>
                <div class="view-toggle">
                    <button class="view-btn active" data-view="grid">
                        <i class="fas fa-th"></i>
                    </button>
                    <button class="view-btn" data-view="masonry">
                        <i class="fas fa-th-large"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- GALERÍA GRID -->
    <section class="gallery-section">
        <div class="container">
            <div class="gallery-grid" id="galleryGrid">
                
                <!-- ITEM 1 - Imagen -->
                <div class="gallery-item" data-type="image">
                    <div class="gallery-card">
                        <div class="gallery-image">
                            <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=800" alt="Mundial">
                            <div class="gallery-overlay">
                                <button class="btn-view" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <button class="btn-download">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn-share">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                            <div class="media-type-badge">
                                <i class="fas fa-image"></i>
                            </div>
                        </div>
                        <div class="gallery-info">
                            <h5 class="gallery-title">Gol de Maradona</h5>
                            <div class="gallery-meta">
                                <span class="mundial-tag">México 1986</span>
                                <div class="gallery-stats">
                                    <span><i class="far fa-heart"></i> 1.2K</span>
                                    <span><i class="far fa-eye"></i> 5.4K</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ITEM 2 - Video -->
                <div class="gallery-item" data-type="video">
                    <div class="gallery-card">
                        <div class="gallery-image">
                            <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800" alt="Mundial">
                            <div class="gallery-overlay">
                                <button class="btn-play" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button class="btn-download">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn-share">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                            <div class="media-type-badge video-badge">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="video-duration">3:45</div>
                        </div>
                        <div class="gallery-info">
                            <h5 class="gallery-title">Final Brasil 2014</h5>
                            <div class="gallery-meta">
                                <span class="mundial-tag">Brasil 2014</span>
                                <div class="gallery-stats">
                                    <span><i class="far fa-heart"></i> 856</span>
                                    <span><i class="far fa-eye"></i> 3.2K</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ITEM 3 - Imagen -->
                <div class="gallery-item" data-type="image">
                    <div class="gallery-card">
                        <div class="gallery-image">
                            <img src="https://images.unsplash.com/photo-1522778119026-d647f0596c20?w=800" alt="Mundial">
                            <div class="gallery-overlay">
                                <button class="btn-view" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <button class="btn-download">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn-share">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                            <div class="media-type-badge">
                                <i class="fas fa-image"></i>
                            </div>
                        </div>
                        <div class="gallery-info">
                            <h5 class="gallery-title">Estadio Maracaná</h5>
                            <div class="gallery-meta">
                                <span class="mundial-tag">Brasil 2014</span>
                                <div class="gallery-stats">
                                    <span><i class="far fa-heart"></i> 634</span>
                                    <span><i class="far fa-eye"></i> 2.1K</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ITEM 4 - Imagen -->
                <div class="gallery-item" data-type="image">
                    <div class="gallery-card">
                        <div class="gallery-image">
                            <img src="https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?w=800" alt="Mundial">
                            <div class="gallery-overlay">
                                <button class="btn-view" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <button class="btn-download">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn-share">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                            <div class="media-type-badge">
                                <i class="fas fa-image"></i>
                            </div>
                        </div>
                        <div class="gallery-info">
                            <h5 class="gallery-title">Celebración Argentina</h5>
                            <div class="gallery-meta">
                                <span class="mundial-tag">Qatar 2022</span>
                                <div class="gallery-stats">
                                    <span><i class="far fa-heart"></i> 2.5K</span>
                                    <span><i class="far fa-eye"></i> 8.9K</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ITEM 5 - Video -->
                <div class="gallery-item" data-type="video">
                    <div class="gallery-card">
                        <div class="gallery-image">
                            <img src="https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=800" alt="Mundial">
                            <div class="gallery-overlay">
                                <button class="btn-play" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button class="btn-download">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn-share">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                            <div class="media-type-badge video-badge">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="video-duration">2:15</div>
                        </div>
                        <div class="gallery-info">
                            <h5 class="gallery-title">Resumen Rusia 2018</h5>
                            <div class="gallery-meta">
                                <span class="mundial-tag">Rusia 2018</span>
                                <div class="gallery-stats">
                                    <span><i class="far fa-heart"></i> 1.8K</span>
                                    <span><i class="far fa-eye"></i> 6.3K</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ITEM 6 - Imagen -->
                <div class="gallery-item" data-type="image">
                    <div class="gallery-card">
                        <div class="gallery-image">
                            <img src="https://images.unsplash.com/photo-1489944440615-453fc2b6a9a9?w=800" alt="Mundial">
                            <div class="gallery-overlay">
                                <button class="btn-view" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <button class="btn-download">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn-share">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                            <div class="media-type-badge">
                                <i class="fas fa-image"></i>
                            </div>
                        </div>
                        <div class="gallery-info">
                            <h5 class="gallery-title">Afición Mexicana</h5>
                            <div class="gallery-meta">
                                <span class="mundial-tag">México 1986</span>
                                <div class="gallery-stats">
                                    <span><i class="far fa-heart"></i> 945</span>
                                    <span><i class="far fa-eye"></i> 3.7K</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- LOAD MORE -->
            <div class="load-more-section">
                <button class="btn-load-more-gallery">
                    <i class="fas fa-plus-circle me-2"></i>Cargar más contenido
                </button>
            </div>
        </div>
    </section>

    <!-- MODAL PARA VER MEDIA -->
    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-media">
                <button type="button" class="btn-close-media" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
                <div class="modal-body p-0">
                    <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=1200" alt="Media" class="modal-image">
                </div>
                <div class="modal-media-info">
                    <div class="modal-media-title">
                        <h4>Gol de Maradona</h4>
                        <span class="mundial-tag">México 1986</span>
                    </div>
                    <div class="modal-media-actions">
                        <button class="btn-modal-action">
                            <i class="far fa-heart"></i> 1.2K
                        </button>
                        <button class="btn-modal-action">
                            <i class="fas fa-download"></i>
                        </button>
                        <button class="btn-modal-action">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer pb-2 pt-4" id="main-footer">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="text-white">FIFA Mundiales</h5>
                    <p class="text-white-50 mb-0">Proyecto académico - Bases de Datos Multimedia</p>
                    <p class="text-white-50">UANL - Facultad de Ciencias Físico Matemáticas</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                    <p class="text-white-50 mt-2 mb-0">&copy; 2025 FIFA Mundiales. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/galeria.js"></script>
</body>
</html>