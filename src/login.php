<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - FIFA Mundiales</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/base.css" rel="stylesheet">
    <link href="assets/css/login.css" rel="stylesheet">
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
                        <a class="nav-link" href="index.php"><i class="fas fa-home me-1"></i>Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mundiales.php"><i class="fas fa-globe me-1"></i>Mundiales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="galeria.php"><i class="fas fa-images me-1"></i>Galería</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto" style="flex-direction: row;">
                    <li class="nav-item">
                        <a class="nav-link btn-outline-primary ms-2 active" href="login.php">
                            <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-primary text-white ms-2" href="registro.php" style="background:#6101eb; color:#fff; border:none;">
                            <i class="fas fa-user-plus me-1"></i>Registrarse
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <section class="login-section">
        <div class="container-fluid h-100">
            <div class="row min-vh-100">
                <!-- Left Side - Login Form -->
                <div class="col-lg-6 d-flex align-items-center justify-content-center py-5">
                    <div class="login-container">
                        <div class="login-header text-center mb-4">
                            <div class="login-icon mb-3">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <h2 class="login-title">Iniciar Sesión</h2>
                            <p class="login-subtitle">Accede a tu cuenta para contribuir con contenido</p>
                        </div>

                        <?php if(isset($_GET['error'])): ?>
                        <div style="color: red; background-color: #ffe6e6; padding: 10px; border: 1px solid red; border-radius: 5px; margin-bottom: 15px;">
                                <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                        <?php endif; ?>


                        <form id="loginForm" class="login-form" method="post" action ="../backend/api/auth.php">
                            <!-- Email Input -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Correo Electrónico
                                </label>
                                <input type="email" class="form-control form-control-lg" id="email" name="correo"
                                       placeholder="ejemplo@correo.com" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa un correo válido
                                </div>
                            </div>

                            <!-- Password Input -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Contraseña
                                </label>
                                <div class="password-input-container">
                                    <input type="password" class="form-control form-control-lg" id="password"  name = "contrasena"
                                           placeholder="••••••••" required>
                                    <button type="button" class="password-toggle" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">
                                    La contraseña debe tener al menos 8 caracteres
                                </div>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="form-options mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        Recordarme
                                    </label>
                                </div>
                                <a href="#" class="forgot-password" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>

                            <!-- Login Button -->
                            <button type="submit" class="btn btn-login btn-lg w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Iniciar Sesión
                            </button>

                            <!-- Divider -->
                            <div class="divider">
                                <span>O continúa con</span>
                            </div>

                            <!-- Social Login -->
                            <div class="social-login">
                                <button type="button" class="btn-social btn-google">
                                    <i class="fab fa-google me-2"></i>
                                    Google
                                </button>
                                <button type="button" class="btn-social btn-facebook">
                                    <i class="fab fa-facebook-f me-2"></i>
                                    Facebook
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="register-link text-center mt-4">
                                <p class="mb-0">¿No tienes una cuenta? 
                                    <a href="registro.php" class="link-primary">Regístrate aquí</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Side - Visual Content -->
                <div class="col-lg-6 d-none d-lg-flex">
                    <div class="login-visual">
                        <div class="visual-overlay">
                            <div class="visual-content">
                                <h3 class="visual-title">Únete a la Comunidad FIFA</h3>
                                <p class="visual-subtitle">Comparte tus momentos favoritos, sube contenido exclusivo y conecta con fanáticos de todo el mundo.</p>
                                
                                <div class="features-list">
                                    <div class="feature-item">
                                        <div class="feature-icon">
                                            <i class="fas fa-upload"></i>
                                        </div>
                                        <div class="feature-text">
                                            <h5>Sube contenido</h5>
                                            <p>Comparte fotos y videos de tus momentos favoritos</p>
                                        </div>
                                    </div>
                                    <div class="feature-item">
                                        <div class="feature-icon">
                                            <i class="fas fa-comments"></i>
                                        </div>
                                        <div class="feature-text">
                                            <h5>Comenta y califica</h5>
                                            <p>Interactúa con publicaciones de otros usuarios</p>
                                        </div>
                                    </div>
                                    <div class="feature-item">
                                        <div class="feature-icon">
                                            <i class="fas fa-heart"></i>
                                        </div>
                                        <div class="feature-text">
                                            <h5>Guarda favoritos</h5>
                                            <p>Marca y guarda tu contenido preferido</p>
                                        </div>
                                    </div>
                                    <div class="feature-item">
                                        <div class="feature-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="feature-text">
                                            <h5>Conecta con fans</h5>
                                            <p>Únete a una comunidad global de aficionados</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="stats-preview">
                                    <div class="stat-item">
                                        <span class="stat-number">12,847</span>
                                        <span class="stat-label">Usuarios activos</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">89,234</span>
                                        <span class="stat-label">Publicaciones</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">245K</span>
                                        <span class="stat-label">Me gusta</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-key me-2"></i>
                        Recuperar Contraseña
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-4">
                        Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                    </p>
                    <form id="forgotPasswordForm">
                        <div class="form-group mb-3">
                            <label for="forgotEmail" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="forgotEmail" 
                                   placeholder="ejemplo@correo.com" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>
                                Enviar Enlace de Recuperación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay d-none" id="loadingOverlay">
        <div class="loading-content">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3 text-white">Iniciando sesión...</p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/login.js"></script>
</body>
</html>