<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Modelo Reaccion 
 * Maneja operaciones con likes/reacciones de publicaciones
 */
class Reaccion {
    
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
     * Toggle like (dar o quitar like)
     * @param int $id_usuario
     * @param int $id_publicacion
     * @return string|false 'like' o 'unlike' o false si falla
     */
    public function toggle($id_usuario, $id_publicacion) {
        try {
            $stmt = $this->conn->prepare("CALL sp_reaccion_toggle(?, ?)");
            $stmt->execute([$id_usuario, $id_publicacion]);
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultado ? $resultado['accion'] : false;
            
        } catch (PDOException $e) {
            error_log("Error en toggle(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si usuario dio like a publicación
     * @param int $id_usuario
     * @param int $id_publicacion
     * @return bool
     */
    public function verificar($id_usuario, $id_publicacion) {
        try {
            $stmt = $this->conn->prepare("CALL sp_reaccion_verificar(?, ?)");
            $stmt->execute([$id_usuario, $id_publicacion]);
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultado ? (bool)$resultado['tiene_like'] : false;
            
        } catch (PDOException $e) {
            error_log("Error en verificar(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Contar likes de una publicación
     * @param int $id_publicacion
     * @return int
     */
    public function contar($id_publicacion) {
        try {
            $stmt = $this->conn->prepare("CALL sp_reaccion_contar_por_publicacion(?)");
            $stmt->execute([$id_publicacion]);
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultado ? (int)$resultado['total_likes'] : 0;
            
        } catch (PDOException $e) {
            error_log("Error en contar(): " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Listar usuarios que dieron like a una publicación
     * @param int $id_publicacion
     * @return array|false
     */
    public function listarUsuarios($id_publicacion) {
        try {
            $stmt = $this->conn->prepare("CALL sp_reaccion_listar_usuarios(?)");
            $stmt->execute([$id_publicacion]);
            
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $usuarios;
            
        } catch (PDOException $e) {
            error_log("Error en listarUsuarios(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Listar publicaciones que le gustaron a un usuario
     * @param int $id_usuario
     * @return array|false
     */
    public function listarPorUsuario($id_usuario) {
        try {
            $stmt = $this->conn->prepare("CALL sp_reaccion_listar_por_usuario(?)");
            $stmt->execute([$id_usuario]);
            
            $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $publicaciones;
            
        } catch (PDOException $e) {
            error_log("Error en listarPorUsuario(): " . $e->getMessage());
            return false;
        }
    }
}
?>