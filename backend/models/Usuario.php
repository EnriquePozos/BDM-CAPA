<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Modelo Usuario
 * Ejecuta los Stored Procedures relacionados con usuarios
 */
class Usuario {
    
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
     * Validar login de usuario
     * @param string $correo
     * @param string $contrasena
     * @return array|false
     */
    public function login($correo, $contrasena) {
        try {
            $stmt = $this->conn->prepare("CALL sp_usuario_login(?, ?)");
            $stmt->execute([$correo, $contrasena]);
            
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $usuario ? $usuario : false;
            
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener usuario por ID
     * @param int $id
     * @return array|false
     */
    public function obtenerPorId($id) {
        try {
            $stmt = $this->conn->prepare("CALL sp_usuario_obtener_por_id(?)");
            $stmt->execute([$id]);
            
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $usuario ? $usuario : false;
            
        } catch (PDOException $e) {
            error_log("Error en obtenerPorId: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Crear nuevo usuario
     * @param array $datos
     * @return int|false ID del usuario creado o false si falla
     */
    public function crear($datos) {
        try {
            $stmt = $this->conn->prepare("CALL sp_usuario_crear(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $datos['nombre'],
                $datos['correo'],
                $datos['contrasena'],
                $datos['foto'],
                $datos['pais_nacimiento'],
                $datos['genero'],
                $datos['nacionalidad'],
                $datos['fecha_nacimiento'],
                $datos['tipo_usuario']
            ]);
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultado ? $resultado['id_Usuario'] : false;
            
        } catch (PDOException $e) {
            error_log("Error en crear: " . $e->getMessage());
            return false;
        }
    }
}
?>