<?php
require_once __DIR__ . '/../models/Comentario.php';

/**
 * Controlador de Comentario
 * Maneja operaciones CRUD de comentarios
 */
class ComentarioController {
    
    private $comentarioModel;

    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->comentarioModel = new Comentario();
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
     * Crear nuevo comentario
     */
    public function crear() {
        $this->verificarAutenticacion();

        // Validar campos requeridos
        if (empty($_POST['contenido']) || empty($_POST['id_publicacion'])) {
            $this->redirectWithError('Todos los campos son obligatorios', $_POST['id_publicacion']);
            return;
        }

        // Validar que el contenido no esté vacío
        $contenido = trim($_POST['contenido']);
        if (strlen($contenido) < 1) {
            $this->redirectWithError('El comentario no puede estar vacío', $_POST['id_publicacion']);
            return;
        }

        // Preparar datos
        $datos = [
            'contenido' => $contenido,
            'id_publicacion' => intval($_POST['id_publicacion']),
            'id_usuario' => $_SESSION['usuario_id']
        ];

        // Crear comentario
        $idComentario = $this->comentarioModel->crear($datos);

        if ($idComentario) {
            $this->redirectWithSuccess('Comentario agregado exitosamente', $datos['id_publicacion']);
        } else {
            $this->redirectWithError('Error al crear el comentario', $datos['id_publicacion']);
        }
    }

    /**
     * Eliminar comentario (soft delete)
     */
    public function eliminar() {
        $this->verificarAutenticacion();

        // Validar que venga el ID
        if (empty($_POST['id_comentario']) || empty($_POST['id_publicacion'])) {
            $this->redirectWithError('ID de comentario requerido', $_POST['id_publicacion'] ?? null);
            return;
        }

        $idComentario = intval($_POST['id_comentario']);
        $idPublicacion = intval($_POST['id_publicacion']);
        $idUsuario = $_SESSION['usuario_id'];
        $esAdmin = ($_SESSION['usuario_tipo'] == 1);

        // Eliminar comentario
        $resultado = $this->comentarioModel->eliminar($idComentario, $idUsuario, $esAdmin);

        if ($resultado) {
            $this->redirectWithSuccess('Comentario eliminado exitosamente', $idPublicacion);
        } else {
            $this->redirectWithError('Error al eliminar el comentario o no tienes permiso', $idPublicacion);
        }
    }

    /**
     * Listar comentarios de una publicación
     * Retorna datos para mostrar en el muro
     */
    public function listarPorPublicacion($idPublicacion) {
        $comentarios = $this->comentarioModel->listarPorPublicacion($idPublicacion);

        if ($comentarios === false) {
            return [];
        }

        return $comentarios;
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