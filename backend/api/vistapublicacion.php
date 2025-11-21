<?php
/**
 * API Endpoint - Vista de Publicaciones
 * Maneja las acciones relacionadas con el registro de vistas de publicaciones (AJAX)
 */

require_once __DIR__ . '/../controllers/VistaPublicacionController.php';

// Crear instancia del controlador
$vistaPublicacionController = new VistaPublicacionController();

// Determinar la acción según el método y parámetros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    
    switch ($accion) {
        case 'registrar':
            // Registrar vista de publicación (AJAX)
            $vistaPublicacionController->registrarVista();
            break;
            
        default:
            // Acción no válida - Respuesta JSON para AJAX
            http_response_code(400);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'exitoso' => false,
                'mensaje' => 'Acción no válida',
                'codigo' => 400
            ], JSON_UNESCAPED_UNICODE);
            exit();
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $accion = isset($_GET['accion']) ? $_GET['accion'] : '';
    
    switch ($accion) {
        case 'total':
            // Obtener total de vistas de una publicación
            $vistaPublicacionController->obtenerTotalVistas();
            break;
            
        case 'verificar':
            // Verificar si usuario ya vio una publicación
            $vistaPublicacionController->verificarVistaUsuario();
            break;
            
        case 'estadisticas':
            // Obtener estadísticas del usuario actual
            $vistaPublicacionController->obtenerEstadisticasUsuario();
            break;
            
        case 'mas_vistas':
            // Obtener publicaciones más vistas
            $vistaPublicacionController->obtenerMasVistas();
            break;
            
        case 'test':
            // Método de prueba (eliminar en producción)
            $vistaPublicacionController->test();
            break;
            
        default:
            // Acción no válida - Respuesta JSON para AJAX
            http_response_code(400);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'exitoso' => false,
                'mensaje' => 'Acción no válida',
                'codigo' => 400
            ], JSON_UNESCAPED_UNICODE);
            exit();
    }
    
} else {
    // Método no permitido
    http_response_code(405);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'exitoso' => false,
        'mensaje' => 'Método HTTP no permitido. Solo se permiten POST y GET',
        'codigo' => 405
    ], JSON_UNESCAPED_UNICODE);
    exit();
}
?>