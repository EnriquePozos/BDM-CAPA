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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="index.html">
                <img src="assets/logov3.png" alt="Logo FIFA Mundiales" style="height: 48px; vertical-align: middle;">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto" style="flex-direction: row; justify-content: center; width: 100%;">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html"><i class="fas fa-home me-1"></i>Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="mundiales.html"><i class="fas fa-globe me-1"></i>Mundiales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="galeria.html"><i class="fas fa-images me-1"></i>Galería</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto" style="flex-direction: row;">
                    <li class="nav-item">
                        <a class="nav-link btn-outline-primary ms-2" href="login.html">
                            <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-primary text-white ms-2" href="login.html" style="background:#6101eb; color:#fff; border:none;">
                            <i class="fas fa-user-plus me-1"></i>Registrarse
                        </a>
                    </li>
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
                                        <label class="filter-label">Mundial</label>
                                        <select class="filter-select" id="mundialFilter">
                                            <option value="">Todos los mundiales</option>
                                            <option value="2022">Qatar 2022</option>
                                            <option value="2018">Rusia 2018</option>
                                            <option value="2014">Brasil 2014</option>
                                            <option value="2010">Sudáfrica 2010</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="filter-group">
                                        <label class="filter-label">País Sede</label>
                                        <select class="filter-select" id="sedeFilter">
                                            <option value="">Todas las sedes</option>
                                            <option value="qatar">Qatar</option>
                                            <option value="rusia">Rusia</option>
                                            <option value="brasil">Brasil</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="filter-group">
                                        <label class="filter-label">Ordenar por</label>
                                        <select class="filter-select" id="sortFilter">
                                            <option value="cronologico">Cronológico</option>
                                            <option value="likes">Más likes</option>
                                            <option value="comentarios">Más comentarios</option>
                                            <option value="reciente">Más reciente</option>
                                        </select>
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
                <h2 class="section-title">
                    <i class="fas fa-globe-americas me-2"></i> MUNDIALES FIFA
                </h2>
                <p class="section-description">Haz clic en un mundial para ver todas sus publicaciones</p>
            </div>

            <div class="row g-4">
                <!-- QATAR 2022 -->
                <div class="col-lg-4 col-md-6">
                    <a href="muro.html?mundial=qatar2022" class="mundial-card-link">
                        <div class="mundial-card">
                            <div class="mundial-image">
                                <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=800" alt="Qatar 2022">
                                <div class="mundial-overlay">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="mundial-content">
                                <div class="mundial-badge-year">2022</div>
                                <h3 class="mundial-title">Qatar 2022</h3>
                                <p class="mundial-description">
                                    <i class="fas fa-map-marker-alt me-2"></i>Qatar
                                </p>
                                <div class="mundial-stats">
                                    <span><i class="fas fa-images me-1"></i> 245 publicaciones</span>
                                    <span><i class="fas fa-heart me-1"></i> 12.5K likes</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- RUSIA 2018 -->
                <div class="col-lg-4 col-md-6">
                    <a href="muro.html?mundial=rusia2018" class="mundial-card-link">
                        <div class="mundial-card">
                            <div class="mundial-image">
                                <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800" alt="Rusia 2018">
                                <div class="mundial-overlay">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="mundial-content">
                                <div class="mundial-badge-year">2018</div>
                                <h3 class="mundial-title">Rusia 2018</h3>
                                <p class="mundial-description">
                                    <i class="fas fa-map-marker-alt me-2"></i>Rusia
                                </p>
                                <div class="mundial-stats">
                                    <span><i class="fas fa-images me-1"></i> 198 publicaciones</span>
                                    <span><i class="fas fa-heart me-1"></i> 9.8K likes</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- BRASIL 2014 -->
                <div class="col-lg-4 col-md-6">
                    <a href="muro.html?mundial=brasil2014" class="mundial-card-link">
                        <div class="mundial-card">
                            <div class="mundial-image">
                                <img src="https://images.unsplash.com/photo-1522778119026-d647f0596c20?w=800" alt="Brasil 2014">
                                <div class="mundial-overlay">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="mundial-content">
                                <div class="mundial-badge-year">2014</div>
                                <h3 class="mundial-title">Brasil 2014</h3>
                                <p class="mundial-description">
                                    <i class="fas fa-map-marker-alt me-2"></i>Brasil
                                </p>
                                <div class="mundial-stats">
                                    <span><i class="fas fa-images me-1"></i> 176 publicaciones</span>
                                    <span><i class="fas fa-heart me-1"></i> 8.2K likes</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- SUDÁFRICA 2010 -->
                <div class="col-lg-4 col-md-6">
                    <a href="muro.html?mundial=sudafrica2010" class="mundial-card-link">
                        <div class="mundial-card">
                            <div class="mundial-image">
                                <img src="https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=800" alt="Sudáfrica 2010">
                                <div class="mundial-overlay">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="mundial-content">
                                <div class="mundial-badge-year">2010</div>
                                <h3 class="mundial-title">Sudáfrica 2010</h3>
                                <p class="mundial-description">
                                    <i class="fas fa-map-marker-alt me-2"></i>Sudáfrica
                                </p>
                                <div class="mundial-stats">
                                    <span><i class="fas fa-images me-1"></i> 142 publicaciones</span>
                                    <span><i class="fas fa-heart me-1"></i> 6.5K likes</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- ALEMANIA 2006 -->
                <div class="col-lg-4 col-md-6">
                    <a href="muro.html?mundial=alemania2006" class="mundial-card-link">
                        <div class="mundial-card">
                            <div class="mundial-image">
                                <img src="https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?w=800" alt="Alemania 2006">
                                <div class="mundial-overlay">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="mundial-content">
                                <div class="mundial-badge-year">2006</div>
                                <h3 class="mundial-title">Alemania 2006</h3>
                                <p class="mundial-description">
                                    <i class="fas fa-map-marker-alt me-2"></i>Alemania
                                </p>
                                <div class="mundial-stats">
                                    <span><i class="fas fa-images me-1"></i> 128 publicaciones</span>
                                    <span><i class="fas fa-heart me-1"></i> 5.9K likes</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MÉXICO 1986 -->
                <div class="col-lg-4 col-md-6">
                    <a href="muro.html?mundial=mexico1986" class="mundial-card-link">
                        <div class="mundial-card">
                            <div class="mundial-image">
                                <img src="https://images.unsplash.com/photo-1553778263-73a83bab9b0c?w=800" alt="México 1986">
                                <div class="mundial-overlay">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="mundial-content">
                                <div class="mundial-badge-year">1986</div>
                                <h3 class="mundial-title">México 1986</h3>
                                <p class="mundial-description">
                                    <i class="fas fa-map-marker-alt me-2"></i>México
                                </p>
                                <div class="mundial-stats">
                                    <span><i class="fas fa-images me-1"></i> 95 publicaciones</span>
                                    <span><i class="fas fa-heart me-1"></i> 7.3K likes</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
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
</body>
</html>