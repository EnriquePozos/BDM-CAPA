/**
 * Dashboard Admin JavaScript
 * Funcionalidades interactivas para el panel de administración
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ==================== NAVIGATION BETWEEN SECTIONS ====================
    const menuItems = document.querySelectorAll('.menu-item');
    const contentSections = document.querySelectorAll('.content-section');
    
    // Handle menu item clicks
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all menu items
            menuItems.forEach(mi => mi.classList.remove('active'));
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Hide all content sections
            contentSections.forEach(section => section.classList.remove('active'));
            
            // Show the selected section
            const sectionId = this.getAttribute('data-section');
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.classList.add('active');
                
                // Scroll to top of content
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // ==================== QUICK ACTION CARDS ====================
    const actionCards = document.querySelectorAll('.action-card[data-goto]');
    
    actionCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetSection = this.getAttribute('data-goto');
            
            // Find the corresponding menu item and click it
            const targetMenuItem = document.querySelector(`.menu-item[data-section="${targetSection}"]`);
            if (targetMenuItem) {
                targetMenuItem.click();
            }
        });
    });
    
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
    
    // ==================== SEARCH FUNCTIONALITY ====================
    const searchInput = document.querySelector('.search-box input');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            console.log('Buscando:', searchTerm);
            
            // Here you would implement the actual search logic
            // For now, just log the search term
        });
    }
    
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
        
        // Close button
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        });
        
        // Auto hide after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    function getNotificationIcon(type) {
        switch(type) {
            case 'success': return 'check-circle';
            case 'danger': return 'times-circle';
            case 'warning': return 'exclamation-triangle';
            case 'info': return 'info-circle';
            default: return 'info-circle';
        }
    }
    
    // Add notification styles dynamically
    const notificationStyles = `
        <style>
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                padding: 1rem 1.5rem;
                border-radius: 10px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
                display: flex;
                align-items: center;
                gap: 1rem;
                z-index: 9999;
                transform: translateX(400px);
                opacity: 0;
                transition: all 0.3s ease;
                min-width: 300px;
            }
            
            .notification.show {
                transform: translateX(0);
                opacity: 1;
            }
            
            .notification i {
                font-size: 1.5rem;
            }
            
            .notification-success {
                border-left: 4px solid #10b981;
            }
            
            .notification-success i {
                color: #10b981;
            }
            
            .notification-danger {
                border-left: 4px solid #ef4444;
            }
            
            .notification-danger i {
                color: #ef4444;
            }
            
            .notification-warning {
                border-left: 4px solid #f59e0b;
            }
            
            .notification-warning i {
                color: #f59e0b;
            }
            
            .notification-info {
                border-left: 4px solid #3b82f6;
            }
            
            .notification-info i {
                color: #3b82f6;
            }
            
            .notification span {
                flex: 1;
                color: #1f2937;
                font-weight: 600;
            }
            
            .notification-close {
                background: none;
                border: none;
                font-size: 1.5rem;
                color: #6b7280;
                cursor: pointer;
                padding: 0;
                width: 24px;
                height: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: color 0.3s ease;
            }
            
            .notification-close:hover {
                color: #1f2937;
            }
            
            @media (max-width: 576px) {
                .notification {
                    right: 10px;
                    left: 10px;
                    min-width: auto;
                }
            }
        </style>
    `;
    
    document.head.insertAdjacentHTML('beforeend', notificationStyles);
    
    // ==================== ANIMATION ON SCROLL ====================
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe stat cards
    document.querySelectorAll('.stat-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `all 0.5s ease ${index * 0.1}s`;
        observer.observe(card);
    });
    
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
    
    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    
    // ==================== KEYBOARD SHORTCUTS ====================
    document.addEventListener('keydown', function(e) {
        // Alt + 1-7 para navegar entre secciones
        if (e.altKey && e.key >= '1' && e.key <= '7') {
            e.preventDefault();
            const index = parseInt(e.key) - 1;
            const menuItem = menuItems[index];
            if (menuItem) {
                menuItem.click();
            }
        }
        
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
    console.log('%c Keyboard Shortcuts:', 'font-weight: bold; font-size: 14px;');
    console.log('Alt + 1-7: Navigate between sections');
    console.log('Ctrl + F: Focus search');
    
});