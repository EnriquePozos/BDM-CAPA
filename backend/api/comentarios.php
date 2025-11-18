<?php
/**
 * API Endpoint - Comentarios
 * Maneja las acciones relacionadas con comentarios
 */

require_once __DIR__ . '/../controllers/ComentarioController.php';

// Crear instancia del controlador
$comentarioController = new ComentarioController();

// Determinar la acción según el método y parámetros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    
    switch ($accion) {
        case 'crear':
            $comentarioController->crear();
            break;
            
        case 'eliminar':
            $comentarioController->eliminar();
            break;
            
        default:
            header('Location: ../../src/mundiales.php?error=Acción no válida');
            exit();
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $accion = isset($_GET['accion']) ? $_GET['accion'] : '';
    
    switch ($accion) {
        case 'listar':
            if (empty($_GET['id_publicacion'])) {
                header('Location: ../../src/mundiales.php?error=ID de publicación requerido');
                exit();
            }
            
            $idPublicacion = intval($_GET['id_publicacion']);
            $comentarios = $comentarioController->listarPorPublicacion($idPublicacion);
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