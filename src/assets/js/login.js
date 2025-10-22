/**
 * LOGIN.JS - Funcionalidad de Inicio de Sesión
 * Cumple con validaciones requeridas
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ==================== ELEMENTOS DEL DOM ====================
    const loginForm = document.getElementById('loginForm');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const emailInput = document.getElementById('email');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');

    // ==================== TOGGLE PASSWORD VISIBILITY ====================
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }

    // ==================== VALIDACIÓN EN TIEMPO REAL ====================
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            validarEmail(this);
        });

        emailInput.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validarEmail(this);
            }
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('blur', function() {
            validarPassword(this);
        });

        passwordInput.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validarPassword(this);
            }
        });
    }



    // ==================== FORGOT PASSWORD FORM ====================
    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            procesarRecuperacion();
        });
    }

    // ==================== FUNCIONES DE VALIDACIÓN ====================
    function validarEmail(input) {
        const email = input.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!email) {
            mostrarError(input, 'El correo electrónico es obligatorio');
            return false;
        }
        
        if (!emailRegex.test(email)) {
            mostrarError(input, 'Por favor ingresa un correo válido');
            return false;
        }
        
        mostrarExito(input);
        return true;
    }

    function validarPassword(input) {
        const password = input.value;
        
        if (!password) {
            mostrarError(input, 'La contraseña es obligatoria');
            return false;
        }
        
        if (password.length < 8) {
            mostrarError(input, 'La contraseña debe tener al menos 8 caracteres');
            return false;
        }
        
        // Validación según requisitos: "Aa1!" mínimo
        const tieneMinuscula = /[a-z]/.test(password);
        const tieneMayuscula = /[A-Z]/.test(password);
        const tieneNumero = /[0-9]/.test(password);
        const tieneEspecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        
        if (!tieneMinuscula || !tieneMayuscula || !tieneNumero || !tieneEspecial) {
            mostrarError(input, 'Debe contener mayúscula, minúscula, número y carácter especial');
            return false;
        }
        
        mostrarExito(input);
        return true;
    }

    function mostrarError(input, mensaje) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        
        const feedback = input.parentElement.querySelector('.invalid-feedback') ||
                        input.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.textContent = mensaje;
        }
    }

    function mostrarExito(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    }

    // ==================== PROCESAR LOGIN ====================


    // ==================== PROCESAR RECUPERACIÓN DE CONTRASEÑA ====================
    function procesarRecuperacion() {
        const forgotEmail = document.getElementById('forgotEmail');
        const email = forgotEmail.value.trim();
        
        if (!validarEmail(forgotEmail)) {
            return;
        }

        mostrarLoading(true);

        // AQUÍ VA LA LLAMADA AL BACKEND PARA ENVIAR EMAIL
        setTimeout(() => {
            mostrarLoading(false);
            
            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('forgotPasswordModal'));
            modal.hide();
            
            // Mostrar mensaje de éxito
            mostrarAlerta('Se ha enviado un enlace de recuperación a tu correo', 'success');
            
            // Limpiar formulario
            forgotPasswordForm.reset();
        }, 2000);
    }

    // ==================== UTILIDADES ====================
    function mostrarLoading(mostrar) {
        if (loadingOverlay) {
            if (mostrar) {
                loadingOverlay.classList.remove('d-none');
            } else {
                loadingOverlay.classList.add('d-none');
            }
        }
    }

    function mostrarAlerta(mensaje, tipo = 'info') {
        // Crear elemento de alerta
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${tipo} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 100px; right: 20px; z-index: 9999; min-width: 300px; animation: slideInRight 0.5s ease;';
        alertDiv.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto-cerrar después de 4 segundos
        setTimeout(() => {
            alertDiv.style.animation = 'slideOutRight 0.5s ease';
            setTimeout(() => {
                alertDiv.remove();
            }, 500);
        }, 4000);
    }

    // ==================== CARGAR EMAIL RECORDADO ====================
    const rememberedEmail = localStorage.getItem('rememberUser');
    if (rememberedEmail && emailInput) {
        emailInput.value = rememberedEmail;
        document.getElementById('rememberMe').checked = true;
    }

    // ==================== SOCIAL LOGIN (SIMULADO) ====================
    const btnGoogle = document.querySelector('.btn-google');
    const btnFacebook = document.querySelector('.btn-facebook');

    if (btnGoogle) {
        btnGoogle.addEventListener('click', function() {
            mostrarAlerta('Login con Google - Funcionalidad próximamente', 'info');
        });
    }

    if (btnFacebook) {
        btnFacebook.addEventListener('click', function() {
            mostrarAlerta('Login con Facebook - Funcionalidad próximamente', 'info');
        });
    }

    // ==================== ANIMACIONES CSS ====================
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    console.log('🔐 Login page inicializado correctamente');
});

// ==================== FUNCIONES PARA BACKEND (COMENTADAS) ====================
/**
 * Función para realizar login con el backend
 */
// async function loginUsuario(email, password) {
//     try {
//         const response = await fetch('api/login.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify({ email, password })
//         });
//         
//         const data = await response.json();
//         return data;
//     } catch (error) {
//         console.error('Error en login:', error);
//         throw error;
//     }
// }

/**
 * Función para recuperar contraseña con el backend
 */
// async function recuperarPassword(email) {
//     try {
//         const response = await fetch('api/recuperar_password.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify({ email })
//         });
//         
//         const data = await response.json();
//         return data;
//     } catch (error) {
//         console.error('Error en recuperación:', error);
//         throw error;
//     }
// }