<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mundiales FIFA - Historia Interactiva</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Corregir las rutas de CSS eliminando la barra inicial -->
    <link href="assets/css/base.css" rel="stylesheet">
    <link href="assets/css/index.css" rel="stylesheet">
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
                        <a class="nav-link active" href="index.html"><i class="fas fa-home me-1"></i>Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mundiales.html"><i class="fas fa-globe me-1"></i>Mundiales</a>
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
                        <a class="nav-link btn-primary text-white ms-2" href="registro.html">
                            <i class="fas fa-user-plus me-1"></i>Registrarse
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="hero-section">
        <div class="hero-video">
            <video autoplay muted loop playsinline>
                <source src="assets/videos/videofifamty.mp4" type="video/mp4">
            </video>
            <div class="video-overlay"></div>
        </div>
        
        <div class="container-fluid px-5">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-8 col-xl-6">
                    <div class="hero-content text-start ps-4">
                        <h1 class="hero-title" id="typewriter-title">
                            LA PASIÓN DEL FUTBOL COMIENZA EN
                        </h1>
                        
                        <div class="countdown-timer mt-4 mb-4">
                            <div class="row">
                                <div class="col-3">
                                    <div class="countdown-item">
                                        <span class="countdown-number" id="days">000</span>
                                        <span class="countdown-label">Días</span>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="countdown-item">
                                        <span class="countdown-number" id="hours">00</span>
                                        <span class="countdown-label">Horas</span>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="countdown-item">
                                        <span class="countdown-number" id="minutes">00</span>
                                        <span class="countdown-label">Min</span>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="countdown-item">
                                        <span class="countdown-number" id="seconds">00</span>
                                        <span class="countdown-label">Seg</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="hero-subtitle">
                            ¡Prepárate para el Mundial 2026! USA, Canadá y México serán las sedes y 48 equipos competirán por la gloria.
                        </p>
                        
                        <div class="hero-buttons">
                            <a href="mundiales.html" class="btn btn-primary btn-lg me-3" style="background:#6101eb; color:#fff; border:none;">
                                <i class="fas fa-play me-2"></i>Explorar Mundiales
                            </a>
                            <a href="galeria.html" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-images me-2"></i>Ver Galería
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Mundiales Section -->
    <section class="featured-section" id="mundiales-destacados">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="section-title">MUNDIALES DESTACADOS</h2>
                    <p class="section-subtitle">Revive los momentos más emblemáticos de la historia del fútbol mundial</p>
                </div>
            </div>
            
            <div class="row g-4" id="mundial-list">
                <!-- Card 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="mundial-card card-brasil">
                        <div class="card-blur-bg"></div>
                        <div class="card-content">
                            <div class="card-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="card-header">
                                <span class="year">2014</span>
                                <span class="country">Brasil</span>
                            </div>
                            <h5>Copa Mundial de la FIFA Brasil</h5>
                            <p class="card-description">El torneo que vio nacer nuevas leyendas y dejó momentos inolvidables en el país del fútbol.</p>
                            <a href="#" class="card-button">Explorar Mundial</a>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="mundial-card card-rusia">
                        <div class="card-blur-bg"></div>
                        <div class="card-content">
                            <div class="card-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="card-header">
                                <span class="year">2018</span>
                                <span class="country">Rusia</span>
                            </div>
                            <h5>Copa Mundial de la FIFA Rusia</h5>
                            <p class="card-description">Francia se corona campeón en un torneo lleno de innovación y tecnología VAR.</p>
                            <a href="#" class="card-button">Explorar Mundial</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="mundial-card card-qatar">
                        <div class="card-blur-bg"></div>
                        <div class="card-content">
                            <div class="card-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div class="card-header">
                                <span class="year">2022</span>
                                <span class="country">Qatar</span>
                            </div>
                            <h5>Copa Mundial de la FIFA Qatar</h5>
                            <p class="card-description">Argentina campeón en el primer Mundial invernal de la historia.</p>
                            <a href="#" class="card-button">Explorar Mundial</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Ver Todos -->
            <div class="text-center mt-5">
                <a href="mundiales.html" class="btn-ver-todos">
                    <i class="fas fa-globe"></i>
                    Ver Todos los Mundiales
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section - Únete a Nosotros -->
    <section class="cta-section py-5">
        <div class="container">
            <div class="cta-card">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="cta-content">
                            <h2 class="cta-title">¿QUIERES PUBLICAR TU CONTENIDO?</h2>
                            <p class="cta-text">
                                Únete a nuestra comunidad y comparte tus momentos favoritos de los mundiales. 
                                Sube fotos, videos y sé parte de la historia del fútbol.
                            </p>
                            <div class="cta-features mt-4">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Sube fotos y videos</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Comenta y da likes</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Conecta con fans</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="cta-buttons">
                            <a href="login.html" class="btn btn-cta btn-lg mb-3">
                                <i class="fas fa-user-plus me-2"></i>Crear Cuenta Gratis
                            </a>
                            <p class="cta-login">
                                ¿Ya tienes cuenta? 
                                <a href="login.html" class="login-link">Inicia Sesión</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
    <script src="assets/js/script.js"></script>
</body>
</html>