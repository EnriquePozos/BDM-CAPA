<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - FIFA Mundiales</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/base.css" rel="stylesheet">
    <link href="assets/css/login.css" rel="stylesheet">
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
                        <a class="nav-link btn-primary text-white ms-2" href="registro.html" style="background:#6101eb; color:#fff; border:none;">
                            <i class="fas fa-user-plus me-1"></i>Registrarse
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Registro Section -->
    <section class="login-section">
        <div class="container-fluid h-100">
            <div class="row min-vh-100">
                <!-- Left Side - Registro Form -->
                <div class="col-lg-7 d-flex align-items-center justify-content-center py-5">
                    <div class="login-container" style="max-width: 600px;">
                        <div class="login-header text-center mb-4">
                            <div class="login-icon mb-3">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h2 class="login-title">Crear Cuenta</h2>
                            <p class="login-subtitle">Únete a la comunidad FIFA Mundiales</p>
                        </div>

                        <!-- Progress Indicator -->
                        <div class="registration-steps mb-4">
                            <div class="step active" data-step="1">
                                <div class="step-number">1</div>
                                <div class="step-label">Datos Personales</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step" data-step="2">
                                <div class="step-number">2</div>
                                <div class="step-label">Cuenta</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step" data-step="3">
                                <div class="step-number">3</div>
                                <div class="step-label">Foto</div>
                            </div>
                        </div>

                        <form id="registroForm" class="login-form">
                            <!-- PASO 1: Datos Personales -->
                            <div class="form-step active" data-step="1">
                                <h5 class="step-title mb-4">
                                    <i class="fas fa-user me-2"></i>Información Personal
                                </h5>

                                <!-- Nombre Completo -->
                                <div class="form-group mb-3">
                                    <label for="nombreCompleto" class="form-label">
                                        <i class="fas fa-id-card me-2"></i>Nombre Completo *
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="nombreCompleto" 
                                           placeholder="Ej: Juan Pérez García" required>
                                    <div class="invalid-feedback">El nombre debe tener al menos 3 caracteres</div>
                                </div>

                                <!-- Fecha de Nacimiento -->
                                <div class="form-group mb-3">
                                    <label for="fechaNacimiento" class="form-label">
                                        <i class="fas fa-calendar me-2"></i>Fecha de Nacimiento *
                                    </label>
                                    <input type="date" class="form-control form-control-lg" id="fechaNacimiento" required>
                                    <small class="form-text text-muted">Debes ser mayor de 12 años</small>
                                    <div class="invalid-feedback">Debes ser mayor de 12 años para registrarte</div>
                                </div>

                                <div class="row">
                                    <!-- Género -->
                                    <div class="col-md-6 mb-3">
                                        <label for="genero" class="form-label">
                                            <i class="fas fa-venus-mars me-2"></i>Género *
                                        </label>
                                        <select class="form-select form-control-lg" id="genero" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                            <option value="Otro">Otro</option>
                                            <option value="Prefiero no decir">Prefiero no decir</option>
                                        </select>
                                        <div class="invalid-feedback">Por favor selecciona tu género</div>
                                    </div>

                                    <!-- País de Nacimiento -->
                                    <div class="col-md-6 mb-3">
                                        <label for="paisNacimiento" class="form-label">
                                            <i class="fas fa-globe-americas me-2"></i>País de Nacimiento *
                                        </label>
                                        <select class="form-select form-control-lg" id="paisNacimiento" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="Mexico">🇲🇽 México</option>
                                            <option value="Argentina">🇦🇷 Argentina</option>
                                            <option value="Brasil">🇧🇷 Brasil</option>
                                            <option value="España">🇪🇸 España</option>
                                            <option value="Colombia">🇨🇴 Colombia</option>
                                            <option value="Chile">🇨🇱 Chile</option>
                                            <option value="Peru">🇵🇪 Perú</option>
                                            <option value="USA">🇺🇸 Estados Unidos</option>
                                        </select>
                                        <div class="invalid-feedback">Por favor selecciona tu país</div>
                                    </div>
                                </div>

                                <!-- Nacionalidad -->
                                <div class="form-group mb-3">
                                    <label for="nacionalidad" class="form-label">
                                        <i class="fas fa-flag me-2"></i>Nacionalidad *
                                    </label>
                                    <select class="form-select form-control-lg" id="nacionalidad" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="Mexicana">🇲🇽 Mexicana</option>
                                        <option value="Argentina">🇦🇷 Argentina</option>
                                        <option value="Brasileña">🇧🇷 Brasileña</option>
                                        <option value="Española">🇪🇸 Española</option>
                                        <option value="Colombiana">🇨🇴 Colombiana</option>
                                        <option value="Chilena">🇨🇱 Chilena</option>
                                        <option value="Peruana">🇵🇪 Peruana</option>
                                        <option value="Estadounidense">🇺🇸 Estadounidense</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor selecciona tu nacionalidad</div>
                                </div>

                                <button type="button" class="btn btn-login btn-lg w-100" onclick="nextStep(2)">
                                    Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>

                            <!-- PASO 2: Datos de Cuenta -->
                            <div class="form-step" data-step="2">
                                <h5 class="step-title mb-4">
                                    <i class="fas fa-envelope me-2"></i>Datos de Acceso
                                </h5>

                                <!-- Email -->
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-at me-2"></i>Correo Electrónico *
                                    </label>
                                    <input type="email" class="form-control form-control-lg" id="email" 
                                           placeholder="ejemplo@correo.com" required>
                                    <div class="invalid-feedback">Por favor ingresa un correo válido</div>
                                </div>

                                <!-- Contraseña -->
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Contraseña *
                                    </label>
                                    <div class="password-input-container">
                                        <input type="password" class="form-control form-control-lg" id="password" 
                                               placeholder="••••••••" required>
                                        <button type="button" class="password-toggle" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small class="form-text text-muted">
                                        Mínimo 8 caracteres: 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial
                                    </small>
                                    <div class="invalid-feedback">La contraseña no cumple los requisitos</div>
                                </div>

                                <!-- Password Strength Indicator -->
                                <div class="password-strength mb-3">
                                    <div class="strength-bar">
                                        <div class="strength-bar-fill" id="strengthBar"></div>
                                    </div>
                                    <small class="strength-text" id="strengthText">Fortaleza de la contraseña</small>
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="form-group mb-4">
                                    <label for="confirmarPassword" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Confirmar Contraseña *
                                    </label>
                                    <div class="password-input-container">
                                        <input type="password" class="form-control form-control-lg" id="confirmarPassword" 
                                               placeholder="••••••••" required>
                                        <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">Las contraseñas no coinciden</div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-secondary btn-lg flex-fill" onclick="prevStep(1)">
                                        <i class="fas fa-arrow-left me-2"></i>Anterior
                                    </button>
                                    <button type="button" class="btn btn-login btn-lg flex-fill" onclick="nextStep(3)">
                                        Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- PASO 3: Foto de Perfil -->
                            <div class="form-step" data-step="3">
                                <h5 class="step-title mb-4">
                                    <i class="fas fa-camera me-2"></i>Foto de Perfil
                                </h5>

                                <!-- Upload Photo -->
                                <div class="photo-upload-container mb-4">
                                    <div class="photo-preview" id="photoPreview">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="photo-upload-controls">
                                        <label for="fotoUsuario" class="btn btn-outline-primary">
                                            <i class="fas fa-upload me-2"></i>Seleccionar Foto
                                        </label>
                                        <input type="file" class="d-none" id="fotoUsuario" accept="image/*">
                                        <button type="button" class="btn btn-outline-danger mt-2 d-none" id="removePhoto">
                                            <i class="fas fa-trash me-2"></i>Eliminar Foto
                                        </button>
                                    </div>
                                    <small class="form-text text-muted d-block mt-2">
                                        Formatos: JPG, PNG (Máx. 2MB)
                                    </small>
                                </div>

                                <!-- Términos y Condiciones -->
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="terminos" required>
                                    <label class="form-check-label" for="terminos">
                                        Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#terminosModal">términos y condiciones</a> 
                                        y la <a href="#" data-bs-toggle="modal" data-bs-target="#privacidadModal">política de privacidad</a> *
                                    </label>
                                    <div class="invalid-feedback">Debes aceptar los términos y condiciones</div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-secondary btn-lg flex-fill" onclick="prevStep(2)">
                                        <i class="fas fa-arrow-left me-2"></i>Anterior
                                    </button>
                                    <button type="submit" class="btn btn-login btn-lg flex-fill">
                                        <i class="fas fa-check me-2"></i>Crear Cuenta
                                    </button>
                                </div>
                            </div>

                            <!-- Login Link -->
                            <div class="register-link text-center mt-4">
                                <p class="mb-0">¿Ya tienes una cuenta? 
                                    <a href="login.html" class="link-primary">Inicia sesión aquí</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Side - Visual Content -->
                <div class="col-lg-5 d-none d-lg-flex">
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

    <!-- Modal Términos y Condiciones -->
    <div class="modal fade" id="terminosModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-file-contract me-2"></i>
                        Términos y Condiciones
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Aceptación de los términos</h6>
                    <p>Al registrarte en FIFA Mundiales, aceptas estos términos y condiciones...</p>
                    
                    <h6>2. Uso de la plataforma</h6>
                    <p>El contenido subido debe ser apropiado y relacionado con el fútbol...</p>
                    
                    <h6>3. Propiedad intelectual</h6>
                    <p>El contenido que subes sigue siendo de tu propiedad...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
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
            <p class="mt-3 text-white">Creando tu cuenta...</p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/registro.js"></script>
</body>
</html>