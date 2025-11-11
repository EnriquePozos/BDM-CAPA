// ==================== DASHBOARD USUARIO JS ====================
// Funcionalidades completas del dashboard de usuario

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

    // Inicializar otras funcionalidades
    initFilterTabs();
    initPublicationForm();
    initProfileForm();
    initSearchBox();
    initFilePreview();
    initPasswordValidation();
    initNotifications();
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
                    if (pubStatus === status.slice(0, -1)) { // Remove 's' from 'aprobadas' or 'pendientes'
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

// ==================== FORMULARIO NUEVA PUBLICACIÓN ====================
function initPublicationForm() {
    const form = document.getElementById('formNuevaPublicacion');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validar formulario
            if (!validatePublicationForm()) {
                return;
            }

            // Recopilar datos del formulario
            const formData = {
                titulo: document.getElementById('tituloPublicacion').value,
                mundial: document.getElementById('mundialSelect').value,
                categoria: document.getElementById('categoriaSelect').value,
                seleccion: document.getElementById('seleccionInput').value,
                descripcion: document.getElementById('descripcionPublicacion').value,
                tipoContenido: document.getElementById('tipoContenido').value,
                archivo: document.getElementById('archivoMultimedia').files[0]
            };

            // Simular envío (aquí iría la llamada al servidor)
            console.log('Datos de la publicación:', formData);

            // Mostrar mensaje de éxito
            showSuccessMessage('¡Publicación enviada! Tu contenido será revisado por un administrador.');

            // Resetear formulario
            form.reset();
            document.getElementById('previewContainer').style.display = 'none';

            // Opcional: redirigir a la sección de publicaciones después de 2 segundos
            setTimeout(() => {
                document.querySelector('[data-section="publicaciones"]').click();
            }, 2000);
        });
    }
}

// ==================== VALIDACIÓN FORMULARIO PUBLICACIÓN ====================
function validatePublicationForm() {
    const titulo = document.getElementById('tituloPublicacion').value.trim();
    const mundial = document.getElementById('mundialSelect').value;
    const categoria = document.getElementById('categoriaSelect').value;
    const descripcion = document.getElementById('descripcionPublicacion').value.trim();
    const tipoContenido = document.getElementById('tipoContenido').value;
    const archivo = document.getElementById('archivoMultimedia').files[0];

    // Validar campos requeridos
    if (!titulo) {
        showErrorMessage('Por favor ingresa un título para la publicación');
        return false;
    }

    if (!mundial) {
        showErrorMessage('Por favor selecciona un mundial');
        return false;
    }

    if (!categoria) {
        showErrorMessage('Por favor selecciona una categoría');
        return false;
    }

    if (!descripcion) {
        showErrorMessage('Por favor ingresa una descripción');
        return false;
    }

    if (!tipoContenido) {
        showErrorMessage('Por favor selecciona el tipo de contenido');
        return false;
    }

    if (!archivo) {
        showErrorMessage('Por favor selecciona un archivo para subir');
        return false;
    }

    // Validar tamaño del archivo (máximo 50MB)
    const maxSize = 50 * 1024 * 1024; // 50MB en bytes
    if (archivo.size > maxSize) {
        showErrorMessage('El archivo es demasiado grande. El tamaño máximo es 50MB');
        return false;
    }

    // Validar tipo de archivo
    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
    const validVideoTypes = ['video/mp4', 'video/avi', 'video/quicktime'];
    
    if (tipoContenido === 'imagen' && !validImageTypes.includes(archivo.type)) {
        showErrorMessage('Por favor selecciona un archivo de imagen válido (JPG, PNG, GIF)');
        return false;
    }

    if (tipoContenido === 'video' && !validVideoTypes.includes(archivo.type)) {
        showErrorMessage('Por favor selecciona un archivo de video válido (MP4, AVI)');
        return false;
    }

    return true;
}

// ==================== PREVIEW DE ARCHIVOS ====================
function initFilePreview() {
    const archivoInput = document.getElementById('archivoMultimedia');
    const tipoContenido = document.getElementById('tipoContenido');
    const previewContainer = document.getElementById('previewContainer');
    const preview = document.getElementById('preview');

    if (archivoInput) {
        archivoInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const tipo = tipoContenido.value;
                    
                    if (tipo === 'imagen') {
                        preview.innerHTML = `<img src="${e.target.result}" alt="Vista previa" style="max-width: 100%; border-radius: 12px;">`;
                    } else if (tipo === 'video') {
                        preview.innerHTML = `<video controls style="max-width: 100%; border-radius: 12px;">
                            <source src="${e.target.result}" type="${file.type}">
                            Tu navegador no soporta el elemento de video.
                        </video>`;
                    }
                    
                    previewContainer.style.display = 'block';
                };
                
                reader.readAsDataURL(file);
            }
        });
    }
}

// ==================== FORMULARIO DE PERFIL ====================
function initProfileForm() {
    const form = document.getElementById('formEditarPerfil');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validar formulario
            if (!validateProfileForm()) {
                return;
            }

            // Recopilar datos del formulario
            const formData = {
                nombreCompleto: document.getElementById('nombreCompleto').value,
                fechaNacimiento: document.getElementById('fechaNacimiento').value,
                genero: document.getElementById('genero').value,
                paisNacimiento: document.getElementById('paisNacimiento').value,
                nacionalidad: document.getElementById('nacionalidad').value,
                correoElectronico: document.getElementById('correoElectronico').value
            };

            // Si hay cambio de contraseña
            const contrasenaActual = document.getElementById('contrasenaActual').value;
            const contrasenaNueva = document.getElementById('contrasenaNueva').value;
            
            if (contrasenaActual || contrasenaNueva) {
                if (!validatePasswordChange()) {
                    return;
                }
                formData.contrasenaActual = contrasenaActual;
                formData.contrasenaNueva = contrasenaNueva;
            }

            // Simular envío (aquí iría la llamada al servidor)
            console.log('Datos del perfil:', formData);

            // Mostrar mensaje de éxito
            showSuccessMessage('¡Perfil actualizado correctamente!');

            // Actualizar nombre en el sidebar
            document.getElementById('userName').textContent = formData.nombreCompleto.split(' ')[0];
        });
    }

    // Preview de foto de perfil
    const fotoPerfil = document.getElementById('fotoPerfil');
    if (fotoPerfil) {
        fotoPerfil.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreview').src = e.target.result;
                    document.getElementById('profileImg').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

// ==================== VALIDACIÓN FORMULARIO PERFIL ====================
function validateProfileForm() {
    const nombreCompleto = document.getElementById('nombreCompleto').value.trim();
    const fechaNacimiento = document.getElementById('fechaNacimiento').value;
    const correoElectronico = document.getElementById('correoElectronico').value.trim();

    // Validar nombre completo
    if (!nombreCompleto) {
        showErrorMessage('Por favor ingresa tu nombre completo');
        return false;
    }

    // Validar fecha de nacimiento (mayor de 12 años)
    if (!fechaNacimiento) {
        showErrorMessage('Por favor ingresa tu fecha de nacimiento');
        return false;
    }

    const fecha = new Date(fechaNacimiento);
    const hoy = new Date();
    const edad = hoy.getFullYear() - fecha.getFullYear();
    const mes = hoy.getMonth() - fecha.getMonth();
    
    if (mes < 0 || (mes === 0 && hoy.getDate() < fecha.getDate())) {
        edad--;
    }

    if (edad < 12) {
        showErrorMessage('Debes ser mayor de 12 años para usar la plataforma');
        return false;
    }

    // Validar correo electrónico
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(correoElectronico)) {
        showErrorMessage('Por favor ingresa un correo electrónico válido');
        return false;
    }

    return true;
}

// ==================== VALIDACIÓN CAMBIO DE CONTRASEÑA ====================
function initPasswordValidation() {
    const contrasenaNueva = document.getElementById('contrasenaNueva');
    
    if (contrasenaNueva) {
        contrasenaNueva.addEventListener('input', function() {
            const password = this.value;
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
            };

            // Aquí podrías mostrar indicadores visuales de los requisitos
            console.log('Requisitos de contraseña:', requirements);
        });
    }
}

function validatePasswordChange() {
    const contrasenaActual = document.getElementById('contrasenaActual').value;
    const contrasenaNueva = document.getElementById('contrasenaNueva').value;
    const contrasenaConfirmar = document.getElementById('contrasenaConfirmar').value;

    // Validar que se ingresó la contraseña actual
    if (!contrasenaActual) {
        showErrorMessage('Por favor ingresa tu contraseña actual');
        return false;
    }

    // Validar que se ingresó la nueva contraseña
    if (!contrasenaNueva) {
        showErrorMessage('Por favor ingresa tu nueva contraseña');
        return false;
    }

    // Validar requisitos mínimos de contraseña (Aa1! mínimo 8 caracteres)
    if (contrasenaNueva.length < 8) {
        showErrorMessage('La contraseña debe tener al menos 8 caracteres');
        return false;
    }

    if (!/[A-Z]/.test(contrasenaNueva)) {
        showErrorMessage('La contraseña debe contener al menos una letra mayúscula');
        return false;
    }

    if (!/[a-z]/.test(contrasenaNueva)) {
        showErrorMessage('La contraseña debe contener al menos una letra minúscula');
        return false;
    }

    if (!/[0-9]/.test(contrasenaNueva)) {
        showErrorMessage('La contraseña debe contener al menos un número');
        return false;
    }

    if (!/[!@#$%^&*(),.?":{}|<>]/.test(contrasenaNueva)) {
        showErrorMessage('La contraseña debe contener al menos un símbolo especial (!@#$%^&*...)');
        return false;
    }

    // Validar que las contraseñas coincidan
    if (contrasenaNueva !== contrasenaConfirmar) {
        showErrorMessage('Las contraseñas no coinciden');
        return false;
    }

    return true;
}

// ==================== BÚSQUEDA DE PUBLICACIONES ====================
function initSearchBox() {
    const searchInput = document.querySelector('.search-box input');
    
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

// ==================== NOTIFICACIONES ====================
function initNotifications() {
    // Simular actualización de notificaciones cada 30 segundos
    setInterval(checkNotifications, 30000);
}

function checkNotifications() {
    // Aquí iría la llamada al servidor para verificar nuevas notificaciones
    console.log('Verificando nuevas notificaciones...');
}

// ==================== MENSAJES DE ALERTA ====================
function showSuccessMessage(message) {
    // Crear elemento de alerta
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
    
    // Remover después de 5 segundos
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

function showErrorMessage(message) {
    // Crear elemento de alerta
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
    
    // Remover después de 5 segundos
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// ==================== ACCIONES DE PUBLICACIONES ====================
// Eliminar publicación
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-danger')) {
        const btn = e.target.closest('.btn-danger');
        const card = btn.closest('.publication-card');
        
        if (card && btn.innerHTML.includes('Eliminar')) {
            if (confirm('¿Estás seguro de que deseas eliminar esta publicación?')) {
                // Aquí iría la llamada al servidor para eliminar
                card.style.animation = 'fadeOut 0.5s ease';
                setTimeout(() => {
                    card.remove();
                    showSuccessMessage('Publicación eliminada correctamente');
                }, 500);
            }
        }
    }
});

// ==================== CONFIGURACIÓN ====================
// Guardar configuración
const settingsSwitches = document.querySelectorAll('.settings-section .form-check-input');
settingsSwitches.forEach(switchEl => {
    switchEl.addEventListener('change', function() {
        const settingName = this.id;
        const isEnabled = this.checked;
        
        // Aquí iría la llamada al servidor para guardar la configuración
        console.log(`Configuración ${settingName}: ${isEnabled ? 'activada' : 'desactivada'}`);
    });
});

// ==================== ACTUALIZAR FECHA ACTUAL ====================
function updateCurrentDate() {
    const dateElements = document.querySelectorAll('.current-date');
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const currentDate = new Date().toLocaleDateString('es-ES', options);
    
    dateElements.forEach(el => {
        const text = el.textContent;
        if (!text.includes(currentDate)) {
            el.innerHTML = `<i class="far fa-calendar-alt"></i> ${currentDate}`;
        }
    });
}

// Actualizar fecha al cargar
updateCurrentDate();

// ==================== ANIMACIONES ADICIONALES ====================
// Agregar animación fadeOut
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: scale(1);
        }
        to {
            opacity: 0;
            transform: scale(0.8);
        }
    }
`;
document.head.appendChild(style);

// ==================== UTILIDADES ====================
// Función para formatear números
function formatNumber(num) {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M';
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K';
    }
    return num.toString();
}

// Función para calcular tiempo relativo
function getRelativeTime(date) {
    const now = new Date();
    const diff = now - date;
    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (days > 0) {
        return `Hace ${days} día${days > 1 ? 's' : ''}`;
    } else if (hours > 0) {
        return `Hace ${hours} hora${hours > 1 ? 's' : ''}`;
    } else if (minutes > 0) {
        return `Hace ${minutes} minuto${minutes > 1 ? 's' : ''}`;
    } else {
        return 'Hace unos momentos';
    }
}

console.log('Dashboard de Usuario inicializado correctamente');