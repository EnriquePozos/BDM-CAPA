<?php
/**
 * API Endpoint - Multimedia
 * Maneja las acciones relacionadas con archivos multimedia
 */

require_once __DIR__ . '/../controllers/MultimediaController.php';

// Crear instancia del controlador
$multimediaController = new MultimediaController();

// Determinar la acción según el método y parámetros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    
    switch ($accion) {
        case 'subir':
            $idMultimedia = $multimediaController->subir();
            
            if ($idMultimedia) {
                // Redirigir con éxito
                if (isset($_POST['redirect_url'])) {
                    header('Location: ' . $_POST['redirect_url'] . '?success=Archivo subido&id_multimedia=' . $idMultimedia);
                } else {
                    header('Location: ../../src/mundiales.php?success=Archivo subido');
                }
                exit();
            } else {
                header('Location: ../../src/mundiales.php?error=Error al subir el archivo');
                exit();
            }
            break;
            
        case 'subir_multiples':
            $idsMultimedia = $multimediaController->subirMultiples();
            
            if (count($idsMultimedia) > 0) {
                $ids = implode(',', $idsMultimedia);
                if (isset($_POST['redirect_url'])) {
                    header('Location: ' . $_POST['redirect_url'] . '?success=Archivos subidos&ids_multimedia=' . $ids);
                } else {
                    header('Location: ../../src/mundiales.php?success=Archivos subidos');
                }
                exit();
            } else {
                header('Location: ../../src/mundiales.php?error=Error al subir archivos');
                exit();
            }
            break;
            
        case 'asociar':
            if (empty($_POST['id_publicacion']) || empty($_POST['id_multimedia'])) {
                header('Location: ../../src/mundiales.php?error=Datos incompletos');
                exit();
            }
            
            $idPublicacion = intval($_POST['id_publicacion']);
            $idMultimedia = intval($_POST['id_multimedia']);
            $orden = isset($_POST['orden']) ? intval($_POST['orden']) : 1;
            
            $resultado = $multimediaController->asociarAPublicacion($idPublicacion, $idMultimedia, $orden);
            
            if ($resultado) {
                header('Location: ../../src/muro.php?id_publicacion=' . $idPublicacion . '&success=Multimedia asociado');
            } else {
                header('Location: ../../src/muro.php?id_publicacion=' . $idPublicacion . '&error=Error al asociar');
            }
            exit();
            break;
            
        default:
            header('Location: ../../src/mundiales.php?error=Acción no válida');
            exit();
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $accion = isset($_GET['accion']) ? $_GET['accion'] : '';
    
    switch ($accion) {
        case 'servir':
            // Esta acción SÍ devuelve el archivo directamente
            $multimediaController->servir();
            break;
            
        case 'obtener':
            if (empty($_GET['id'])) {
                header('Location: ../../src/mundiales.php?error=ID requerido');
                exit();
            }
            
            $id = intval($_GET['id']);
            $multimedia = $multimediaController->obtenerPorId($id);
            break;
            
        case 'listar':
            $multimedia = $multimediaController->listar();
            break;
            
        case 'obtener_por_publicacion':
            if (empty($_GET['id_publicacion'])) {
                header('Location: ../../src/mundiales.php?error=ID de publicación requerido');
                exit();
            }
            
            $idPublicacion = intval($_GET['id_publicacion']);
            $multimedia = $multimediaController->obtenerPorPublicacion($idPublicacion);
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