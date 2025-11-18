<?php
require_once __DIR__ . '/../models/Publicacion.php';
require_once __DIR__ . '/../models/Multimedia.php';
require_once __DIR__ . '/../models/Categoria.php';

/**
 * Controlador de Publicacion
 * Maneja operaciones CRUD de publicaciones
 */
class PublicacionController {
    
    private $publicacionModel;
    private $multimediaModel;
    private $categoriaModel;

    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->publicacionModel = new Publicacion();
        $this->multimediaModel = new Multimedia();
        $this->categoriaModel = new Categoria();
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
     * Verificar que el usuario sea administrador
     */
    private function verificarAdmin() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 1) {
            header('Location: ../../src/index.php?error=Acceso denegado');
            exit();
        }
    }

    /**
     * Crear nueva publicación
     */
    public function crear() {
        $this->verificarAutenticacion();

        // Validar campos requeridos
        if (empty($_POST['titulo']) || empty($_POST['id_mundial'])) {
            $this->redirectWithError('Título y mundial son obligatorios', 'mundiales.php');
            return;
        }

        // Validar título
        $titulo = trim($_POST['titulo']);
        if (strlen($titulo) < 3) {
            $this->redirectWithError('El título debe tener al menos 3 caracteres', 'mundiales.php');
            return;
        }

        // Preparar datos
        $datos = [
            'titulo' => $titulo,
            'descripcion' => isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '',
            'seleccion' => isset($_POST['seleccion']) ? trim($_POST['seleccion']) : null,
            'id_mundial' => intval($_POST['id_mundial']),
            'id_usuario_creador' => $_SESSION['usuario_id']
        ];

        // Crear publicación
        $idPublicacion = $this->publicacionModel->crear($datos);

        if (!$idPublicacion) {
            $this->redirectWithError('Error al crear la publicación', 'mundiales.php');
            return;
        }

        // Asociar categorías si vienen
        if (isset($_POST['categorias']) && is_array($_POST['categorias'])) {
            foreach ($_POST['categorias'] as $idCategoria) {
                $this->publicacionModel->asociarCategoria($idPublicacion, intval($idCategoria));
            }
        }

        // Procesar archivos multimedia si vienen
        if (isset($_FILES['archivos']) && is_array($_FILES['archivos']['name'])) {
            $this->procesarArchivosMultimedia($idPublicacion);
        }

        $this->redirectWithSuccess('Publicación creada exitosamente. Pendiente de aprobación', 'mundiales.php');
    }

    /**
     * Procesar archivos multimedia de una publicación
     */
    private function procesarArchivosMultimedia($idPublicacion) {
        $totalArchivos = count($_FILES['archivos']['name']);
        $orden = 1;

        for ($i = 0; $i < $totalArchivos; $i++) {
            // Verificar que no haya error
            if ($_FILES['archivos']['error'][$i] !== UPLOAD_ERR_OK) {
                continue;
            }

            // Leer archivo
            $nombreArchivo = $_FILES['archivos']['name'][$i];
            $archivoBlob = file_get_contents($_FILES['archivos']['tmp_name'][$i]);

            if ($archivoBlob === false) {
                continue;
            }

            // Crear registro de multimedia
            $idMultimedia = $this->multimediaModel->crear($nombreArchivo, $archivoBlob);

            if ($idMultimedia) {
                // Asociar a publicación
                $this->multimediaModel->asociarAPublicacion($idPublicacion, $idMultimedia, $orden);
                $orden++;
            }
        }
    }

    /**
     * Actualizar estatus de publicación (Admin)
     */
    public function actualizarEstatus() {
        $this->verificarAdmin();

        // Validar campos requeridos
        if (empty($_POST['id_publicacion']) || empty($_POST['estatus'])) {
            $this->redirectWithError('Datos incompletos', 'dashboard-admin.php');
            return;
        }

        $idPublicacion = intval($_POST['id_publicacion']);
        $estatus = $_POST['estatus'];

        // Validar estatus
        $estatusValidos = ['Pendiente', 'Aprobada', 'Rechazada', 'Eliminada'];
        if (!in_array($estatus, $estatusValidos)) {
            $this->redirectWithError('Estatus no válido', 'dashboard-admin.php');
            return;
        }

        // Actualizar estatus
        $resultado = $this->publicacionModel->actualizarEstatus($idPublicacion, $estatus);

        if ($resultado) {
            $this->redirectWithSuccess('Estatus actualizado exitosamente', 'dashboard-admin.php');
        } else {
            $this->redirectWithError('Error al actualizar estatus', 'dashboard-admin.php');
        }
    }

    /**
     * Incrementar vistas de una publicación
     */
    public function incrementarViews($idPublicacion) {
        return $this->publicacionModel->incrementarViews($idPublicacion);
    }

    /**
     * Listar publicaciones por mundial
     */
    public function listarPorMundial($idMundial, $soloAprobadas = true) {
        $publicaciones = $this->publicacionModel->listarPorMundial($idMundial, $soloAprobadas);

        if ($publicaciones === false) {
            return [];
        }

        return $publicaciones;
    }

    /**
     * Obtener publicación por ID
     */
    public function obtenerPorId($id) {
        return $this->publicacionModel->obtenerPorId($id);
    }

    /**
     * Listar publicaciones pendientes (Admin)
     */
    public function listarPendientes() {
        $this->verificarAdmin();
        
        $publicaciones = $this->publicacionModel->listarPendientes();

        if ($publicaciones === false) {
            return [];
        }

        return $publicaciones;
    }

    /**
     * Listar publicaciones de un usuario
     */
    public function listarPorUsuario($idUsuario = null) {
        $this->verificarAutenticacion();

        // Si no se especifica usuario, usar el de la sesión
        if ($idUsuario === null) {
            $idUsuario = $_SESSION['usuario_id'];
        }

        $publicaciones = $this->publicacionModel->listarPorUsuario($idUsuario);

        if ($publicaciones === false) {
            return [];
        }

        return $publicaciones;
    }

    /**
     * Obtener publicaciones con multimedia para el muro
     */
    public function obtenerPublicacionesConMultimedia($idMundial, $soloAprobadas = true) {
        // Obtener publicaciones
        $publicaciones = $this->listarPorMundial($idMundial, $soloAprobadas);

        // Para cada publicación, obtener su multimedia
        foreach ($publicaciones as &$publicacion) {
            $multimedia = $this->multimediaModel->obtenerPorPublicacion($publicacion['id_Publicacion']);
            $publicacion['multimedia'] = $multimedia ? $multimedia : [];
        }

        return $publicaciones;
    }

    /**
     * Redireccionar con mensaje de error
     */
    private function redirectWithError($mensaje, $pagina) {
        header("Location: ../../src/{$pagina}?error=" . urlencode($mensaje));
        exit();
    }

    /**
     * Redireccionar con mensaje de éxito
     */
    private function redirectWithSuccess($mensaje, $pagina) {
        header("Location: ../../src/{$pagina}?success=" . urlencode($mensaje));
        exit();
    }
}
?>