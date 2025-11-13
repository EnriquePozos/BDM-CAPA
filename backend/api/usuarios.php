<?php
require_once __DIR__ . '/../controllers/UsuarioController.php';

// Crear instancia del controlador
$usuarioController = new UsuarioController();

// Determinar la acción según el método y parámetros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Si viene la acción en POST
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    
    switch ($accion) {
        case 'actualizar':
            $usuarioController->actualizar();
            break;
            
        case 'eliminar':
            $usuarioController->eliminar();
            break;
            
        case 'listar':
            $usuarios = $usuarioController->listar();
            break;
            
        default:
            header('Location: ../../src/dashboard-admin.php?error=Acción no válida');
            exit();
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    // Manejar acciones por GET
    $accion = isset($_GET['accion']) ? $_GET['accion'] : '';
    
    switch ($accion) {
        case 'listar':
            $usuarios = $usuarioController->listar();
            
            break;
            
        default:
            header('Location: ../../src/dashboard-admin.php?seccion=usuarios');
            exit();
    }
    
} else {
    // Método no permitido
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Método no permitido';
    exit();
}
?>