<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Modelo Categoria 
 */
class Categoria {
    
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
     * Listar todas las categorías
     * @return array|false
     */
    public function listar() {
        try {
            $stmt = $this->conn->prepare("CALL sp_categoria_listar()");
            $stmt->execute();
            
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $categorias;
            
        } catch (PDOException $e) {
            error_log("Error en listar(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Crear nueva categoría
     * @param string $nombre
     * @return int|false ID de la categoría creada o false si falla
     */
    public function crear($nombre) {
        try {
            $stmt = $this->conn->prepare("CALL sp_categoria_crear(?)");
            $stmt->execute([$nombre]);
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultado ? $resultado['id_Categoria'] : false;
            
        } catch (PDOException $e) {
            error_log("Error en crear(): " . $e->getMessage());
            return false;
        }
    }
}
?>