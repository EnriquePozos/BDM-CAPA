<?php
require_once __DIR__ . '/../controllers/PerfilController.php';

// Crear instancia del controlador
$perfilController = new PerfilController();

// Determinar la acción según el método y parámetros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Si viene la acción en POST
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    
    switch ($accion) {
        case 'actualizar_perfil':
            $perfilController->actualizarPerfil();
            break;
            
        case 'cambiar_contrasena':
            $perfilController->cambiarContrasena();
            break;
            
        case 'obtener_perfil':
            $perfil = $perfilController->obtenerPerfil();
            break;
            
        case 'obtener_publicaciones':
            $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : 'todas';
            $publicaciones = $perfilController->obtenerPublicaciones($filtro);
            break;
            
        default:
            header('Location: ../../src/dashboard-usuario.php?error=Acción no válida');
            exit();
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    // Manejar acciones por GET
    $accion = isset($_GET['accion']) ? $_GET['accion'] : '';
    
    switch ($accion) {
        case 'obtener_perfil':
            $perfil = $perfilController->obtenerPerfil();
            break;
            
        case 'obtener_publicaciones':
            $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'todas';
            $publicaciones = $perfilController->obtenerPublicaciones($filtro);
            break;
            
        default:
            header('Location: ../../src/dashboard-usuario.php');
            exit();
    }
    
} else {
    // Método no permitido
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Método no permitido';
    exit();
}
?>