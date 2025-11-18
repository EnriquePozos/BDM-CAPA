<?php
/**
 * API Endpoint - Reacciones
 * Maneja las acciones relacionadas con likes/reacciones
 */

require_once __DIR__ . '/../controllers/ReaccionController.php';

// Crear instancia del controlador
$reaccionController = new ReaccionController();

// Determinar la acción según el método y parámetros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    
    switch ($accion) {
        case 'toggle':
            $reaccionController->toggle();
            break;
            
        default:
            header('Location: ../../src/mundiales.php?error=Acción no válida');
            exit();
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $accion = isset($_GET['accion']) ? $_GET['accion'] : '';
    
    switch ($accion) {
        case 'verificar':
            if (empty($_GET['id_publicacion']) || empty($_GET['id_usuario'])) {
                header('Location: ../../src/mundiales.php?error=Datos incompletos');
                exit();
            }
            
            $idPublicacion = intval($_GET['id_publicacion']);
            $idUsuario = intval($_GET['id_usuario']);
            $tieneLike = $reaccionController->verificar($idUsuario, $idPublicacion);
            break;
            
        case 'contar':
            if (empty($_GET['id_publicacion'])) {
                header('Location: ../../src/mundiales.php?error=ID de publicación requerido');
                exit();
            }
            
            $idPublicacion = intval($_GET['id_publicacion']);
            $totalLikes = $reaccionController->contar($idPublicacion);
            break;
            
        case 'listar_usuarios':
            if (empty($_GET['id_publicacion'])) {
                header('Location: ../../src/mundiales.php?error=ID de publicación requerido');
                exit();
            }
            
            $idPublicacion = intval($_GET['id_publicacion']);
            $usuarios = $reaccionController->listarUsuarios($idPublicacion);
            break;
            
        default:
            header('Location: ../../src/mundiales.php');
            exit();
    }
    
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Método no permitido';
    exit();
}
?>