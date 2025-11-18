<?php
require_once __DIR__ . '/../models/Reaccion.php';

/**
 * Controlador de Reaccion
 * Maneja operaciones de likes/reacciones
 */
class ReaccionController {
    
    private $reaccionModel;

    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->reaccionModel = new Reaccion();
    }

    /**
     * Verificar que el usuario esté autenticado
     */
    private function verificarAutenticacion() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ../../src/login.php?error=Debes iniciar sesión');
            exit();
        }
    }

    /**
     * Toggle like (dar o quitar like)
     */
    public function toggle() {
        $this->verificarAutenticacion();

        // Validar que venga el ID de publicación
        if (empty($_POST['id_publicacion'])) {
            $this->redirectWithError('ID de publicación requerido');
            return;
        }

        $idPublicacion = intval($_POST['id_publicacion']);
        $idUsuario = $_SESSION['usuario_id'];

        // Toggle like
        $resultado = $this->reaccionModel->toggle($idUsuario, $idPublicacion);

        if ($resultado) {
            $mensaje = ($resultado === 'like') ? 'Like agregado' : 'Like eliminado';
            $this->redirectWithSuccess($mensaje, $idPublicacion);
        } else {
            $this->redirectWithError('Error al procesar la reacción', $idPublicacion);
        }
    }

    /**
     * Verificar si el usuario dio like a una publicación
     */
    public function verificar($idUsuario, $idPublicacion) {
        return $this->reaccionModel->verificar($idUsuario, $idPublicacion);
    }

    /**
     * Contar likes de una publicación
     */
    public function contar($idPublicacion) {
        return $this->reaccionModel->contar($idPublicacion);
    }

    /**
     * Listar usuarios que dieron like
     */
    public function listarUsuarios($idPublicacion) {
        $usuarios = $this->reaccionModel->listarUsuarios($idPublicacion);

        if ($usuarios === false) {
            return [];
        }

        return $usuarios;
    }

    /**
     * Redireccionar con mensaje de error
     */
    private function redirectWithError($mensaje, $idPublicacion = null) {
        if ($idPublicacion) {
            header("Location: ../../src/muro.php?id_publicacion={$idPublicacion}&error=" . urlencode($mensaje));
        } else {
            header("Location: ../../src/mundiales.php?error=" . urlencode($mensaje));
        }
        exit();
    }

    /**
     * Redireccionar con mensaje de éxito
     */
    private function redirectWithSuccess($mensaje, $idPublicacion) {
        header("Location: ../../src/muro.php?id_publicacion={$idPublicacion}&success=" . urlencode($mensaje));
        exit();
    }
}
?>