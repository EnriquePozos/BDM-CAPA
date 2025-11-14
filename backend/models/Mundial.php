<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Modelo Mundial 
 */
class Mundial {
    
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
     * Listar todos los mundiales
     * @return array|false
     */
    public function listar() {
        try {
            $stmt = $this->conn->prepare("CALL sp_mundial_listar()");
            $stmt->execute();
            
            $mundiales = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $mundiales;
            
        } catch (PDOException $e) {
            error_log("Error en listar(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener mundial por ID
     * @param int $id
     * @return array|false
     */
    public function obtenerPorId($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Mundial WHERE id_Mundial = ?");
            $stmt->execute([$id]);
            
            $mundial = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $mundial ? $mundial : false;
            
        } catch (PDOException $e) {
            error_log("Error en obtenerPorId(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Crear nuevo mundial
     * @param array $datos
     * @return int|false ID del mundial creado o false si falla
     */
    public function crear($datos) {
        try {
            $stmt = $this->conn->prepare("CALL sp_mundial_crear(?, ?, ?, ?, ?)");
            
            // Bindear parámetros con tipos específicos
            $stmt->bindParam(1, $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(2, $datos['anio'], PDO::PARAM_INT);
            $stmt->bindParam(3, $datos['sede'], PDO::PARAM_STR);
            $stmt->bindParam(4, $datos['descripcion'], PDO::PARAM_STR);
            $stmt->bindParam(5, $datos['logo'], PDO::PARAM_LOB);
            
            $stmt->execute();
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultado ? $resultado['id_Mundial'] : false;
            
        } catch (PDOException $e) {
            error_log("Error en crear(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualizar mundial existente
     * @param int $id
     * @param array $datos
     * @return bool
     */
    public function actualizar($id, $datos) {
        try {
            $stmt = $this->conn->prepare("CALL sp_mundial_actualizar(?, ?, ?, ?, ?, ?)");
            
            // Bindear parámetros con tipos específicos
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->bindParam(2, $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(3, $datos['anio'], PDO::PARAM_INT);
            $stmt->bindParam(4, $datos['sede'], PDO::PARAM_STR);
            $stmt->bindParam(5, $datos['descripcion'], PDO::PARAM_STR);
            $stmt->bindParam(6, $datos['logo'], PDO::PARAM_LOB);
            
            $stmt->execute();
            $stmt->closeCursor();
            
            return true;
            
        } catch (PDOException $e) {
            error_log("Error en actualizar(): " . $e->getMessage());
            return false;
        }
    }
}
?>