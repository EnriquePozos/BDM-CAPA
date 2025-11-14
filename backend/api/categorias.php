<?php
// Gestión de Categorías

require_once __DIR__ . '/../controllers/CategoriaControler.php';

// Crear instancia del controlador
$categoriaController = new CategoriaController();

// Determinar la acción según el método y parámetros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Si viene la acción en POST
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    
    switch ($accion) {
        case 'crear':
            $categoriaController->crear();
            break;
            
        case 'listar':
            $categoriaController->listar();
            break;
            
        default:
            header('Location: ../../src/dashboard-admin.php?error=Acción no válida');
            exit();
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    // Manejar listar por GET si es necesario
    $accion = isset($_GET['accion']) ? $_GET['accion'] : '';
    
    if ($accion === 'listar') {
        $categoriaController->listar();
    } else {
        header('Location: ../../src/dashboard-admin.php');
        exit();
    }
    
} else {
    // Método no permitido
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Método no permitido';
    exit();
}
?>