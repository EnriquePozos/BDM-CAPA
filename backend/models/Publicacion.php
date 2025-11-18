<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Modelo Publicacion 
 * Maneja operaciones con publicaciones del muro
 */
class Publicacion {
    
    private $conn;
    private $db;

    /**
     * Constructor - Inicializa la conexión a BD
     */
    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Crear nueva publicación
     * @param array $datos
     * @return int|false ID de la publicación creada o false si falla
     */
    public function crear($datos) {
        try {
            $stmt = $this->conn->prepare("CALL sp_publicacion_crear(?, ?, ?, ?, ?)");
            $stmt->execute([
                $datos['titulo'],
                $datos['descripcion'],
                $datos['seleccion'],
                $datos['id_mundial'],
                $datos['id_usuario_creador']
            ]);
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultado ? $resultado['id_Publicacion'] : false;
            
        } catch (PDOException $e) {
            error_log("Error en crear(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualizar estatus de publicación (Admin)
     * @param int $id
     * @param string $estatus (Pendiente/Aprobada/Rechazada/Eliminada)
     * @return bool
     */
    public function actualizarEstatus($id, $estatus) {
        try {
            $stmt = $this->conn->prepare("CALL sp_publicacion_actualizar_estatus(?, ?)");
            $stmt->execute([$id, $estatus]);
            
            $stmt->closeCursor();
            return true;
            
        } catch (PDOException $e) {
            error_log("Error en actualizarEstatus(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Incrementar contador de vistas
     * @param int $id
     * @return bool
     */
    public function incrementarViews($id) {
        try {
            $stmt = $this->conn->prepare("CALL sp_publicacion_incrementar_views(?)");
            $stmt->execute([$id]);
            
            $stmt->closeCursor();
            return true;
            
        } catch (PDOException $e) {
            error_log("Error en incrementarViews(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Listar publicaciones por mundial
     * @param int $id_mundial
     * @param bool $solo_aprobadas True para usuarios, False para admin
     * @return array|false
     */
    public function listarPorMundial($id_mundial, $solo_aprobadas = true) {
        try {
            $stmt = $this->conn->prepare("CALL sp_publicacion_listar_por_mundial(?, ?)");
            $stmt->execute([$id_mundial, $solo_aprobadas ? 1 : 0]);
            
            $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $publicaciones;
            
        } catch (PDOException $e) {
            error_log("Error en listarPorMundial(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener publicación por ID
     * @param int $id
     * @return array|false
     */
    public function obtenerPorId($id) {
        try {
            $stmt = $this->conn->prepare("CALL sp_publicacion_obtener_por_id(?)");
            $stmt->execute([$id]);
            
            $publicacion = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $publicacion ? $publicacion : false;
            
        } catch (PDOException $e) {
            error_log("Error en obtenerPorId(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Listar publicaciones pendientes (para Admin)
     * @return array|false
     */
    public function listarPendientes() {
        try {
            $stmt = $this->conn->prepare("CALL sp_publicacion_listar_pendientes()");
            $stmt->execute();
            
            $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $publicaciones;
            
        } catch (PDOException $e) {
            error_log("Error en listarPendientes(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Listar publicaciones de un usuario
     * @param int $id_usuario
     * @return array|false
     */
    public function listarPorUsuario($id_usuario) {
        try {
            $stmt = $this->conn->prepare("CALL sp_publicacion_listar_por_usuario(?)");
            $stmt->execute([$id_usuario]);
            
            $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $publicaciones;
            
        } catch (PDOException $e) {
            error_log("Error en listarPorUsuario(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Asociar categoría a publicación
     * @param int $id_publicacion
     * @param int $id_categoria
     * @return bool
     */
    public function asociarCategoria($id_publicacion, $id_categoria) {
        try {
            $stmt = $this->conn->prepare("CALL sp_publicacion_categoria_asociar(?, ?)");
            $stmt->execute([$id_publicacion, $id_categoria]);
            
            $stmt->closeCursor();
            return true;
            
        } catch (PDOException $e) {
            error_log("Error en asociarCategoria(): " . $e->getMessage());
            return false;
        }
    }
}
?>