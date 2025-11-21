// ==================== DASHBOARD USUARIO JS ====================
// Funcionalidades del dashboard de usuario

// ==================== NAVEGACIÓN DE SECCIONES ====================
document.addEventListener('DOMContentLoaded', function() {
    // Manejar navegación entre secciones
    const menuItems = document.querySelectorAll('.menu-item');
    const contentSections = document.querySelectorAll('.content-section');

    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remover clase active de todos los items
            menuItems.forEach(mi => mi.classList.remove('active'));
            
            // Agregar clase active al item clickeado
            this.classList.add('active');
            
            // Ocultar todas las secciones
            contentSections.forEach(section => section.classList.remove('active'));
            
            // Mostrar la sección correspondiente
            const targetSection = this.getAttribute('data-section');
            const section = document.getElementById(targetSection);
            if (section) {
                section.classList.add('active');
                
                // Scroll suave al inicio de la sección
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Inicializar funcionalidades
    initFilterTabs();
    initSearchBox();
    initPhotoPreview();
    initFormValidation();
});

// ==================== FILTROS DE PUBLICACIONES ====================
function initFilterTabs() {
    const tabs = document.querySelectorAll('.tab-item');
    const publications = document.querySelectorAll('.publication-card');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Actualizar tabs activos
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // Filtrar publicaciones
            const status = this.getAttribute('data-status');
            
            publications.forEach(pub => {
                if (status === 'todas') {
                    pub.style.display = 'block';
                } else {
                    const pubStatus = pub.getAttribute('data-status');
                    if (pubStatus === status) {
                        pub.style.display = 'block';
                    } else {
                        pub.style.display = 'none';
                    }
                }
            });

            // Animar aparición
            setTimeout(() => {
                publications.forEach(pub => {
                    if (pub.style.display !== 'none') {
                        pub.style.animation = 'fadeIn 0.5s ease';
                    }
                });
            }, 50);
        });
    });
}

// ==================== BÚSQUEDA DE PUBLICACIONES ====================
function initSearchBox() {
    const searchInput = document.getElementById('searchPublicaciones');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const publications = document.querySelectorAll('.publication-card');

            publications.forEach(pub => {
                const title = pub.querySelector('h5').textContent.toLowerCase();
                
                if (title.includes(searchTerm)) {
                    pub.style.display = 'block';
                } else {
                    pub.style.display = 'none';
                }
            });
        });
    }
}

// ==================== PREVIEW DE FOTO DE PERFIL ====================
function initPhotoPreview() {
    const fotoInput = document.getElementById('fotoPerfil');
    const photoPreview = document.getElementById('photoPreview');
    const profileImg = document.getElementById('profileImg');

    if (fotoInput) {
        fotoInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                // Validar tamaño (máximo 5MB)
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    showErrorMessage('La imagen es demasiado grande. El tamaño máximo es 5MB');
                    this.value = '';
                    return;
                }

                // Validar tipo
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    showErrorMessage('Por favor selecciona una imagen válida (JPG, PNG)');
                    this.value = '';
                    return;
                }

                // Mostrar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                    profileImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

// ==================== VALIDACIÓN DE FORMULARIOS ====================
function initFormValidation() {
    // Validación del formulario de perfil
    const formPerfil = document.getElementById('formEditarPerfil');
    if (formPerfil) {
        formPerfil.addEventListener('submit', function(e) {
            if (!validateProfileForm()) {
                e.preventDefault();
            }
        });
    }

    // Validación del formulario de contraseña
    const formContrasena = document.getElementById('formCambiarContrasena');
    if (formContrasena) {
        formContrasena.addEventListener('submit', function(e) {
            if (!validatePasswordForm()) {
                e.preventDefault();
            }
        });
    }
}

// ==================== VALIDAR FORMULARIO DE PERFIL ====================
function validateProfileForm() {
    const nombre = document.getElementById('nombreCompleto').value.trim();
    const fechaNacimiento = document.getElementById('fechaNacimiento').value;
    const genero = document.getElementById('genero').value;
    const paisNacimiento = document.getElementById('paisNacimiento').value.trim();
    const nacionalidad = document.getElementById('nacionalidad').value.trim();

    // Validar campos requeridos
    if (!nombre || !fechaNacimiento || !genero || !paisNacimiento || !nacionalidad) {
        showErrorMessage('Todos los campos son obligatorios');
        return false;
    }

    // Validar edad mínima (12 años)
    const birthDate = new Date(fechaNacimiento);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    if (age < 12) {
        showErrorMessage('Debes tener al menos 12 años para usar la plataforma');
        return false;
    }

    return true;
}

// ==================== VALIDAR FORMULARIO DE CONTRASEÑA ====================
function validatePasswordForm() {
    const contrasenaActual = document.getElementById('contrasenaActual').value;
    const contrasenaNueva = document.getElementById('contrasenaNueva').value;
    const contrasenaConfirmar = document.getElementById('contrasenaConfirmar').value;

    // Validar que se ingresaron todos los campos
    if (!contrasenaActual || !contrasenaNueva || !contrasenaConfirmar) {
        showErrorMessage('Todos los campos de contraseña son obligatorios');
        return false;
    }

    // Validar longitud mínima
    if (contrasenaNueva.length < 8) {
        showErrorMessage('La contraseña debe tener al menos 8 caracteres');
        return false;
    }

    // Validar que tenga mayúscula
    if (!/[A-Z]/.test(contrasenaNueva)) {
        showErrorMessage('La contraseña debe contener al menos una letra mayúscula');
        return false;
    }

    // Validar que tenga número
    if (!/[0-9]/.test(contrasenaNueva)) {
        showErrorMessage('La contraseña debe contener al menos un número');
        return false;
    }

    // Validar que las contraseñas coincidan
    if (contrasenaNueva !== contrasenaConfirmar) {
        showErrorMessage('Las contraseñas nuevas no coinciden');
        return false;
    }

    return true;
}

// ==================== MENSAJES DE ALERTA ====================
function showSuccessMessage(message) {
    const alert = document.createElement('div');
    alert.className = 'alert alert-success alert-dismissible fade show';
    alert.style.position = 'fixed';
    alert.style.top = '100px';
    alert.style.right = '20px';
    alert.style.zIndex = '9999';
    alert.style.minWidth = '300px';
    alert.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
    alert.innerHTML = `
        <i class="fas fa-check-circle me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

function showErrorMessage(message) {
    const alert = document.createElement('div');
    alert.className = 'alert alert-danger alert-dismissible fade show';
    alert.style.position = 'fixed';
    alert.style.top = '100px';
    alert.style.right = '20px';
    alert.style.zIndex = '9999';
    alert.style.minWidth = '300px';
    alert.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
    alert.innerHTML = `
        <i class="fas fa-exclamation-circle me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// ==================== ANIMACIONES ====================
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);

console.log('Dashboard de Usuario inicializado correctamente');