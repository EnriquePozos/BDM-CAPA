<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Modelo Comentario 
 * Maneja operaciones con comentarios de publicaciones
 */
class Comentario {
    
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
     * Crear comentario en publicación
     * @param array $datos
     * @return int|false ID del comentario creado o false si falla
     */
    public function crear($datos) {
        try {
            $stmt = $this->conn->prepare("CALL sp_comentario_crear(?, ?, ?)");
            $stmt->execute([
                $datos['contenido'],
                $datos['id_publicacion'],
                $datos['id_usuario']
            ]);
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultado ? $resultado['id_Comentario'] : false;
            
        } catch (PDOException $e) {
            error_log("Error en crear(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Listar comentarios de una publicación
     * @param int $id_publicacion
     * @return array|false
     */
    public function listarPorPublicacion($id_publicacion) {
        try {
            $stmt = $this->conn->prepare("CALL sp_comentario_listar_por_publicacion(?)");
            $stmt->execute([$id_publicacion]);
            
            $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $comentarios;
            
        } catch (PDOException $e) {
            error_log("Error en listarPorPublicacion(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener comentario por ID
     * @param int $id
     * @return array|false
     */
    public function obtenerPorId($id) {
        try {
            $stmt = $this->conn->prepare("CALL sp_comentario_obtener_por_id(?)");
            $stmt->execute([$id]);
            
            $comentario = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $comentario ? $comentario : false;
            
        } catch (PDOException $e) {
            error_log("Error en obtenerPorId(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar comentario (soft delete)
     * @param int $id_comentario
     * @param int $id_usuario
     * @param bool $es_admin
     * @return bool
     */
    public function eliminar($id_comentario, $id_usuario, $es_admin = false) {
        try {
            $stmt = $this->conn->prepare("CALL sp_comentario_eliminar(?, ?, ?)");
            $stmt->execute([$id_comentario, $id_usuario, $es_admin ? 1 : 0]);
            
            $stmt->closeCursor();
            return true;
            
        } catch (PDOException $e) {
            error_log("Error en eliminar(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Contar comentarios de una publicación
     * @param int $id_publicacion
     * @return int
     */
    public function contar($id_publicacion) {
        try {
            $stmt = $this->conn->prepare("CALL sp_comentario_contar_por_publicacion(?)");
            $stmt->execute([$id_publicacion]);
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultado ? (int)$resultado['total_comentarios'] : 0;
            
        } catch (PDOException $e) {
            error_log("Error en contar(): " . $e->getMessage());
            return 0;
        }
    }
}
?>