/**
 * REGISTRO.JS - Funcionalidad de Registro de Usuarios
 * Cumple con todas las validaciones requeridas
 */

let currentStep = 1;
const totalSteps = 3;

document.addEventListener('DOMContentLoaded', function() {
    
    // ==================== ELEMENTOS DEL DOM ====================
    const registroForm = document.getElementById('registroForm');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const passwordInput = document.getElementById('password');
    const confirmarPasswordInput = document.getElementById('confirmarPassword');
    const fotoUsuario = document.getElementById('fotoUsuario');
    const photoPreview = document.getElementById('photoPreview');
    const removePhoto = document.getElementById('removePhoto');
    const loadingOverlay = document.getElementById('loadingOverlay');

    // ==================== TOGGLE PASSWORD VISIBILITY ====================
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            togglePasswordVisibility(passwordInput, this);
        });
    }

    if (toggleConfirmPassword && confirmarPasswordInput) {
        toggleConfirmPassword.addEventListener('click', function() {
            togglePasswordVisibility(confirmarPasswordInput, this);
        });
    }

    function togglePasswordVisibility(input, button) {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        
        const icon = button.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }

    // ==================== VALIDACIONES EN TIEMPO REAL ====================
    
    // Nombre Completo
    const nombreCompleto = document.getElementById('nombreCompleto');
    if (nombreCompleto) {
        nombreCompleto.addEventListener('blur', function() {
            validarNombre(this);
        });
    }

    // Fecha de Nacimiento
    const fechaNacimiento = document.getElementById('fechaNacimiento');
    if (fechaNacimiento) {
        fechaNacimiento.addEventListener('change', function() {
            validarEdad(this);
        });
    }

    // Email
    const email = document.getElementById('email');
    if (email) {
        email.addEventListener('blur', function() {
            validarEmail(this);
        });
    }

    // Password con strength indicator
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            actualizarPasswordStrength(this);
            if (confirmarPasswordInput.value) {
                validarPasswordsCoinciden();
            }
        });

        passwordInput.addEventListener('blur', function() {
            validarPassword(this);
        });
    }

    // Confirmar Password
    if (confirmarPasswordInput) {
        confirmarPasswordInput.addEventListener('input', function() {
            validarPasswordsCoinciden();
        });
    }

    // ==================== UPLOAD FOTO ====================
    if (fotoUsuario) {
        fotoUsuario.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                validarYMostrarFoto(file);
            }
        });
    }

    if (removePhoto) {
        removePhoto.addEventListener('click', function() {
            fotoUsuario.value = '';
            photoPreview.innerHTML = '<i class="fas fa-user"></i>';
            this.classList.add('d-none');
        });
    }

    // ==================== SUBMIT FORM ====================


    // ==================== FUNCIONES DE VALIDACIÓN ====================
    
    function validarNombre(input) {
        const nombre = input.value.trim();
        
        if (!nombre || nombre.length < 3) {
            mostrarError(input, 'El nombre debe tener al menos 3 caracteres');
            return false;
        }
        
        mostrarExito(input);
        return true;
    }

    function validarEdad(input) {
        const fechaNac = new Date(input.value);
        const hoy = new Date();
        let edad = hoy.getFullYear() - fechaNac.getFullYear();
        const mes = hoy.getMonth() - fechaNac.getMonth();
        
        if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())) {
            edad--;
        }
        
        if (edad < 12) {
            mostrarError(input, 'Debes ser mayor de 12 años para registrarte');
            return false;
        }
        
        mostrarExito(input);
        return true;
    }

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
        
        // Validación según requisitos del proyecto: "Aa1!" mínimo
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

    function actualizarPasswordStrength(input) {
        const password = input.value;
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        if (!password) {
            strengthBar.className = 'strength-bar-fill';
            strengthText.className = 'strength-text';
            strengthText.textContent = 'Fortaleza de la contraseña';
            return;
        }
        
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
        
        strengthBar.className = 'strength-bar-fill';
        strengthText.className = 'strength-text';
        
        if (strength <= 2) {
            strengthBar.classList.add('weak');
            strengthText.classList.add('weak');
            strengthText.textContent = 'Débil';
        } else if (strength <= 4) {
            strengthBar.classList.add('medium');
            strengthText.classList.add('medium');
            strengthText.textContent = 'Media';
        } else {
            strengthBar.classList.add('strong');
            strengthText.classList.add('strong');
            strengthText.textContent = 'Fuerte';
        }
    }

    function validarPasswordsCoinciden() {
        const password = passwordInput.value;
        const confirmar = confirmarPasswordInput.value;
        
        if (!confirmar) {
            return false;
        }
        
        if (password !== confirmar) {
            mostrarError(confirmarPasswordInput, 'Las contraseñas no coinciden');
            return false;
        }
        
        mostrarExito(confirmarPasswordInput);
        return true;
    }

    function validarYMostrarFoto(file) {
        // Validar tipo de archivo
        const tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!tiposPermitidos.includes(file.type)) {
            mostrarAlerta('Solo se permiten imágenes JPG o PNG', 'warning');
            fotoUsuario.value = '';
            return false;
        }
        
        // Validar tamaño (2MB)
        const maxSize = 2 * 1024 * 1024;
        if (file.size > maxSize) {
            mostrarAlerta('La imagen no puede superar los 2MB', 'warning');
            fotoUsuario.value = '';
            return false;
        }
        
        // Mostrar preview
        const reader = new FileReader();
        reader.onload = function(e) {
            photoPreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            removePhoto.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
        
        return true;
    }

    function mostrarError(input, mensaje) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        
        const feedback = input.closest('.form-group').querySelector('.invalid-feedback') ||
                        input.parentElement.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.textContent = mensaje;
        }
    }

    function mostrarExito(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    }

    // ==================== NAVEGACIÓN ENTRE PASOS ====================
    window.nextStep = function(step) {
        if (!validarPasoActual()) {
            mostrarAlerta('Por favor completa todos los campos requeridos correctamente', 'warning');
            return;
        }
        
        cambiarPaso(step);
    };

    window.prevStep = function(step) {
        cambiarPaso(step);
    };

    function validarPasoActual() {
        const stepActual = document.querySelector(`.form-step[data-step="${currentStep}"]`);
        const inputs = stepActual.querySelectorAll('input[required], select[required]');
        let todosValidos = true;
        
        inputs.forEach(input => {
            if (input.type === 'text' && input.id === 'nombreCompleto') {
                if (!validarNombre(input)) todosValidos = false;
            } else if (input.type === 'date') {
                if (!validarEdad(input)) todosValidos = false;
            } else if (input.type === 'email') {
                if (!validarEmail(input)) todosValidos = false;
            } else if (input.type === 'password') {
                if (!validarPassword(input)) todosValidos = false;
                if (input.id === 'confirmarPassword' && !validarPasswordsCoinciden()) {
                    todosValidos = false;
                }
            } else if (input.tagName === 'SELECT') {
                if (!input.value) {
                    mostrarError(input, 'Este campo es obligatorio');
                    todosValidos = false;
                } else {
                    mostrarExito(input);
                }
            }
        });
        
        return todosValidos;
    }

    function cambiarPaso(nuevoStep) {
        // Ocultar paso actual
        document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('completed');
        
        // Mostrar nuevo paso
        currentStep = nuevoStep;
        document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.add('active');
        document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
        
        // Scroll al inicio
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // ==================== PROCESAR REGISTRO ====================
    

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
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${tipo} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 100px; right: 20px; z-index: 9999; min-width: 300px; animation: slideInRight 0.5s ease;';
        alertDiv.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.style.animation = 'slideOutRight 0.5s ease';
            setTimeout(() => {
                alertDiv.remove();
            }, 500);
        }, 4000);
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

    console.log('📝 Página de registro inicializada correctamente');
});

// ==================== FUNCIONES PARA BACKEND (COMENTADAS) ====================
/**
 * Función para registrar usuario con el backend
 */
// async function registrarUsuario(formData) {
//     const data = new FormData();
//     data.append('nombreCompleto', formData.nombreCompleto);
//     data.append('fechaNacimiento', formData.fechaNacimiento);
//     data.append('genero', formData.genero);
//     data.append('paisNacimiento', formData.paisNacimiento);
//     data.append('nacionalidad', formData.nacionalidad);
//     data.append('email', formData.email);
//     data.append('password', formData.password);
//     if (formData.foto) {
//         data.append('foto', formData.foto);
//     }
//     
//     try {
//         const response = await fetch('api/registro.php', {
//             method: 'POST',
//             body: data
//         });
//         
//         const result = await response.json();
//         return result;
//     } catch (error) {
//         console.error('Error en registro:', error);
//         throw error;
//     }
// }