/**
 * Dashboard Admin JavaScript
 * Funcionalidades interactivas para el panel de administración
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ==================== NAVIGATION BETWEEN SECTIONS ====================
    // ELIMINADO: El código que manejaba los clicks en menu-item
    // Ahora los links funcionan normalmente con href="?seccion=X" y PHP controla qué mostrar
    
    // ==================== QUICK ACTION CARDS ====================
    const actionCards = document.querySelectorAll('.action-card[data-goto]');
    
    actionCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetSection = this.getAttribute('data-goto');
            
            // Navegar a la URL con el parámetro de sección
            window.location.href = `?seccion=${targetSection}`;
        });
    });
    
    // ==================== SEARCH FUNCTIONALITY ====================
    const searchInput = document.querySelector('.search-box input');
    
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value.toLowerCase();
            
            searchTimeout = setTimeout(() => {
                console.log('Buscando:', searchTerm);
                // Aquí implementarías la lógica de búsqueda real
            }, 300);
        });
    }
    
    // ==================== FILTER TABS ====================
    const filterTabs = document.querySelectorAll('.tab-item');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            filterTabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Here you would filter the publications based on the selected tab
            console.log('Filter tab clicked:', this.textContent);
        });
    });
    
    // ==================== PUBLICATION ACTIONS ====================
    // ELIMINADO: Event listeners para aprobar/rechazar publicaciones
    // Los formularios ahora se envían normalmente al backend sin interceptación de JavaScript
    
    // ==================== MUNDIAL STATUS TOGGLE ====================
    const mundialSection = document.querySelector('#mundiales');
    if (mundialSection) {
        const mundialToggles = mundialSection.querySelectorAll('.form-check-input');
        
        mundialToggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const label = this.nextElementSibling;
                
                if (!label) return; // Prevenir error si no hay label
                
                const row = this.closest('tr');
                
                if (this.checked) {
                    label.textContent = 'Activo';
                    label.classList.remove('status-inactive');
                    label.classList.add('status-active');
                    showNotification('Mundial activado correctamente', 'success');
                } else {
                    label.textContent = 'Inactivo';
                    label.classList.remove('status-active');
                    label.classList.add('status-inactive');
                    showNotification('Mundial desactivado correctamente', 'warning');
                }
            });
        });
    }
    
    // ==================== USER STATUS TOGGLE ====================
    const usuariosSection = document.querySelector('#usuarios');
    if (usuariosSection) {
        const userToggles = usuariosSection.querySelectorAll('.form-check-input');
        
        userToggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const label = this.nextElementSibling;
                
                if (!label) return; // Prevenir error si no hay label
                
                const row = this.closest('tr');
                
                if (this.checked) {
                    label.textContent = 'Activo';
                    label.classList.remove('status-inactive');
                    label.classList.add('status-active');
                    showNotification('Usuario activado correctamente', 'success');
                } else {
                    label.textContent = 'Inactivo';
                    label.classList.remove('status-active');
                    label.classList.add('status-inactive');
                    showNotification('Usuario desactivado correctamente', 'warning');
                }
            });
        });
    }
    
    // ==================== DELETE CATEGORY ====================
    const categoriasSection = document.querySelector('#categorias');
    if (categoriasSection) {
        const deleteCategoryButtons = categoriasSection.querySelectorAll('.category-actions .btn-danger');
        
        deleteCategoryButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const categoryCard = this.closest('.category-card');
                const categoryName = categoryCard.querySelector('h5').textContent;
                
                if (confirm(`¿Estás seguro de que deseas eliminar la categoría "${categoryName}"?`)) {
                    categoryCard.style.transform = 'scale(0)';
                    categoryCard.style.opacity = '0';
                    
                    setTimeout(() => {
                        categoryCard.remove();
                        showNotification('Categoría eliminada correctamente', 'success');
                    }, 300);
                }
            });
        });
    }
    
    // ==================== DELETE COMMENT ====================
    // ELIMINADO: Event listeners para eliminar comentarios
    // Los formularios ahora se envían normalmente al backend sin interceptación de JavaScript
    
    // ==================== FORM SELECT CHANGES ====================
    const filterSelects = document.querySelectorAll('.header-actions select, .section-header select');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            console.log('Filtro cambiado:', this.value);
            showNotification('Filtro aplicado: ' + this.value, 'info');
            
            // Here you would implement the actual filtering logic
        });
    });
    
    // ==================== NOTIFICATION SYSTEM ====================
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notif => notif.remove());
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <i class="fas fa-${getNotificationIcon(type)}"></i>
            <span>${message}</span>
            <button class="notification-close">&times;</button>
        `;
        
        // Add to document
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // Auto hide after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
        
        // Close button
        notification.querySelector('.notification-close').addEventListener('click', () => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        });
    }
    
    function getNotificationIcon(type) {
        const icons = {
            'success': 'check-circle',
            'danger': 'exclamation-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle'
        };
        return icons[type] || 'info-circle';
    }
    
    // Make notification function available globally
    window.showNotification = showNotification;
    
    // ==================== TABLE ROW HOVER EFFECTS ====================
    const tableRows = document.querySelectorAll('.table tbody tr');
    
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // ==================== CONFIRM BEFORE LEAVING ====================
    let formChanged = false;
    
    const formInputs = document.querySelectorAll('input, select, textarea');
    formInputs.forEach(input => {
        input.addEventListener('change', () => {
            formChanged = true;
        });
    });
    
    // Reset on form submit
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', () => {
            formChanged = false;
        });
    });
    
    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    
    // ==================== KEYBOARD SHORTCUTS ====================
    document.addEventListener('keydown', function(e) {
        // Ctrl + F para buscar
        if (e.ctrlKey && e.key === 'f' && searchInput) {
            e.preventDefault();
            searchInput.focus();
        }
    });
    
    // ==================== INITIALIZE TOOLTIPS ====================
    const tooltips = document.querySelectorAll('[title]');
    tooltips.forEach(element => {
        element.setAttribute('data-bs-toggle', 'tooltip');
    });
    
    // Initialize Bootstrap tooltips if available
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // ==================== CONSOLE LOG ====================
    console.log('%c Dashboard Admin Loaded Successfully! ', 'background: linear-gradient(135deg, #6101EB, #B604DC); color: white; font-size: 16px; padding: 10px; border-radius: 5px;');
    console.log('%c Navigation is handled by PHP with URL parameters', 'font-size: 12px; color: #6101EB;');
    console.log('%c Formularios de publicaciones y comentarios funcionan sin interceptación JS', 'font-size: 12px; color: #28a745;');
    console.log('Keyboard Shortcuts:');
    console.log('Ctrl + F: Focus search');
    
});