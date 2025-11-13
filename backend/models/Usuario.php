<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Modelo Usuario 
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
    /**
     * Listar todos los usuarios
     * 
     * @return array|false Array con usuarios o false si hay error
     */
    public function listarTodos() {
        try {
            $conn = $this->db->getConnection();
            
            // Preparar llamada al stored procedure
            $stmt = $conn->prepare("CALL sp_usuario_listar()");
            
            // Ejecutar
            $stmt->execute();
            
            // Obtener resultados
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Cerrar cursor para liberar la conexión
            $stmt->closeCursor();
            
            return $usuarios;
            
        } catch (PDOException $e) {
            error_log("Error en listarTodos(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualizar datos de un usuario
     * 
     * @param int $id ID del usuario
     * @param array $datos Array asociativo con los datos a actualizar
     * @return bool True si éxito, false si error
     */
    public function actualizar($id, $datos) {
        try {
            $conn = $this->db->getConnection();
            
            // Preparar llamada al stored procedure
            // sp_usuario_actualizar(id, nombre, correo, pais, genero, nacionalidad, fecha_nac, tipo_usuario, activo)
            $stmt = $conn->prepare("CALL sp_usuario_actualizar(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            // Bindear parámetros
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->bindParam(2, $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(3, $datos['correo'], PDO::PARAM_STR);
            $stmt->bindParam(4, $datos['pais_nacimiento'], PDO::PARAM_STR);
            $stmt->bindParam(5, $datos['genero'], PDO::PARAM_STR);
            $stmt->bindParam(6, $datos['nacionalidad'], PDO::PARAM_STR);
            $stmt->bindParam(7, $datos['fecha_nacimiento'], PDO::PARAM_STR);
            $stmt->bindParam(8, $datos['tipo_usuario'], PDO::PARAM_INT);
            $stmt->bindParam(9, $datos['activo'], PDO::PARAM_INT);
            
            // Ejecutar
            $resultado = $stmt->execute();
            
            // Cerrar cursor
            $stmt->closeCursor();
            
            return $resultado;
            
        } catch (PDOException $e) {
            error_log("Error en actualizar(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar (soft delete) un usuario
     * 
     * @param int $id ID del usuario
     * @return bool True si éxito, false si error
     */
    public function eliminar($id) {
        try {
            $conn = $this->db->getConnection();
            
            // Preparar llamada al stored procedure
            $stmt = $conn->prepare("CALL sp_usuario_eliminar(?)");
            
            // Bindear parámetro
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            
            // Ejecutar
            $resultado = $stmt->execute();
            
            // Cerrar cursor
            $stmt->closeCursor();
            
            return $resultado;
            
        } catch (PDOException $e) {
            error_log("Error en eliminar(): " . $e->getMessage());
            return false;
        }
    }
}
?>