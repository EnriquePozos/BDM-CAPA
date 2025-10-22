//Autenticación (login,registro,logout)

<?php
require_once __DIR__ . '/../controllers/AuthController.php';

// Crear instancia del controlador
$authController = new AuthController();

// Determinar la acción según el método y parámetros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Si viene la acción en POST
    $accion = isset($_POST['accion']) ? $_POST['accion'] : 'login';
    
    switch ($accion) {
        case 'login':
            $authController->login();
            break;
            
        case 'registrar':
            $authController->registrar();
            break;
            
        case 'logout':
            $authController->logout();
            break;
            
        default:
            header('Location: ../../src/login.php?error=Acción no válida');
            exit();
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    // Manejar logout por GET si es necesario
    $accion = isset($_GET['accion']) ? $_GET['accion'] : '';
    
    if ($accion === 'logout') {
        $authController->logout();
    } else {
        header('Location: ../../src/login.php');
        exit();
    }
    
} else {
    // Método no permitido
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Método no permitido';
    exit();
}
?>