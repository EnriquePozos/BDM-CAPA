<?php
// Gestión de Mundiales

require_once __DIR__ . '/../controllers/MundialController.php';

// Crear instancia del controlador
$mundialController = new MundialController();

// Determinar la acción según el método y parámetros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Si viene la acción en POST
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    
    switch ($accion) {
        case 'crear':
            $mundialController->crear();
            break;
            
        case 'actualizar':
            $mundialController->actualizar();
            break;
            
        case 'listar':
            $mundialController->listar();
            break;
            
        default:
            header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=Acción no válida');
            exit();
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    // Manejar listar por GET si es necesario
    $accion = isset($_GET['accion']) ? $_GET['accion'] : '';
    
    if ($accion === 'listar') {
        $mundialController->listar();
    } else {
        header('Location: ../../src/dashboard-admin.php?seccion=mundiales');
        exit();
    }
    
} else {
    // Método no permitido
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Método no permitido';
    exit();
}
?>