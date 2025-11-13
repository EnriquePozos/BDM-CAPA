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
    
    // Approve publication
    const approveButtons = document.querySelectorAll('.publication-actions .btn-success');
    approveButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (confirm('¿Estás seguro de que deseas aprobar esta publicación?')) {
                showNotification('Publicación aprobada exitosamente', 'success');
                
                // Update the card appearance
                const card = this.closest('.publication-card');
                card.classList.remove('pending');
                card.classList.add('approved');
                
                const badge = card.querySelector('.status-badge');
                badge.textContent = 'Aprobada';
                badge.classList.remove('pending');
                badge.classList.add('approved');
                
                // Update action buttons
                const actionsDiv = this.closest('.publication-actions');
                actionsDiv.innerHTML = `
                    <button class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Ver
                    </button>
                    <button class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <button class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                `;
            }
        });
    });
    
    // Reject publication
    const rejectButtons = document.querySelectorAll('.publication-actions .btn-danger');
    rejectButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (confirm('¿Estás seguro de que deseas rechazar esta publicación?')) {
                showNotification('Publicación rechazada', 'danger');
                
                const card = this.closest('.publication-card');
                card.style.opacity = '0.5';
                
                setTimeout(() => {
                    card.remove();
                }, 500);
            }
        });
    });
    
    // ==================== MUNDIAL STATUS TOGGLE ====================
    const mundialToggles = document.querySelectorAll('#mundiales .form-check-input');
    
    mundialToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const label = this.nextElementSibling;
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
    
    // ==================== USER STATUS TOGGLE ====================
    const userToggles = document.querySelectorAll('#usuarios .form-check-input');
    
    userToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const label = this.nextElementSibling;
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
    
    // ==================== DELETE CATEGORY ====================
    const deleteCategoryButtons = document.querySelectorAll('.category-actions .btn-danger');
    
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
    
    // ==================== DELETE COMMENT ====================
    const deleteCommentButtons = document.querySelectorAll('.comment-actions .btn-danger');
    
    deleteCommentButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (confirm('¿Estás seguro de que deseas eliminar este comentario?')) {
                const commentItem = this.closest('.comment-item');
                
                commentItem.style.transform = 'translateX(-100%)';
                commentItem.style.opacity = '0';
                
                setTimeout(() => {
                    commentItem.remove();
                    showNotification('Comentario eliminado correctamente', 'success');
                }, 300);
            }
        });
    });
    
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
    console.log('Keyboard Shortcuts:');
    console.log('Ctrl + F: Focus search');
    
});