<?php
/**
 * API Endpoint - Publicaciones
 * Maneja las acciones relacionadas con publicaciones
 */

require_once __DIR__ . '/../controllers/PublicacionController.php';

// Crear instancia del controlador
$publicacionController = new PublicacionController();

// Determinar la acción según el método y parámetros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    
    switch ($accion) {
        case 'crear':
            $publicacionController->crear();
            break;
            
        case 'actualizar_estatus':
            $publicacionController->actualizarEstatus();
            break;
            
        case 'incrementar_views':
            if (empty($_POST['id_publicacion'])) {
                header('Location: ../../src/mundiales.php?error=ID de publicación requerido');
                exit();
            }
            
            $idPublicacion = intval($_POST['id_publicacion']);
            $resultado = $publicacionController->incrementarViews($idPublicacion);
            
            // Redirigir de vuelta a la publicación
            header('Location: ../../src/muro.php?id_publicacion=' . $idPublicacion);
            exit();
            break;
            
        default:
            header('Location: ../../src/mundiales.php?error=Acción no válida');
            exit();
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $accion = isset($_GET['accion']) ? $_GET['accion'] : '';
    
    switch ($accion) {
        case 'listar_por_mundial':
            if (empty($_GET['id_mundial'])) {
                header('Location: ../../src/mundiales.php?error=ID de mundial requerido');
                exit();
            }
            
            $idMundial = intval($_GET['id_mundial']);
            $soloAprobadas = isset($_GET['solo_aprobadas']) ? (bool)$_GET['solo_aprobadas'] : true;
            
            $publicaciones = $publicacionController->listarPorMundial($idMundial, $soloAprobadas);
            break;
            
        case 'obtener':
            if (empty($_GET['id'])) {
                header('Location: ../../src/mundiales.php?error=ID requerido');
                exit();
            }
            
            $id = intval($_GET['id']);
            $publicacion = $publicacionController->obtenerPorId($id);
            
            if (!$publicacion) {
                header('Location: ../../src/mundiales.php?error=Publicación no encontrada');
                exit();
            }
            break;
            
        case 'listar_pendientes':
            $publicaciones = $publicacionController->listarPendientes();
            break;
            
        case 'listar_por_usuario':
            $idUsuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : null;
            $publicaciones = $publicacionController->listarPorUsuario($idUsuario);
            break;
            
        case 'obtener_con_multimedia':
            if (empty($_GET['id_mundial'])) {
                header('Location: ../../src/mundiales.php?error=ID de mundial requerido');
                exit();
            }
            
            $idMundial = intval($_GET['id_mundial']);
            $soloAprobadas = isset($_GET['solo_aprobadas']) ? (bool)$_GET['solo_aprobadas'] : true;
            
            $publicaciones = $publicacionController->obtenerPublicacionesConMultimedia($idMundial, $soloAprobadas);
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