<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Modelo Multimedia 
 * Maneja operaciones con archivos multimedia (imágenes/videos)
 */
class Multimedia {
    
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
     * Crear registro de archivo multimedia
     * @param string $nombre_archivo
     * @param string $file BLOB del archivo
     * @return int|false ID del archivo creado o false si falla
     */
public function crear($nombre_archivo, $file) {
    try {
        // SOLUCIÓN: Usar execute() directo en lugar de bindParam()
        // PDO::PARAM_LOB tiene problemas conocidos con MySQL y archivos grandes
        $stmt = $this->conn->prepare("CALL sp_multimedia_crear(?, ?)");
        
        // Ejecutar directamente pasando los parámetros en el array
        // Esto permite que PDO maneje el BLOB correctamente sin tipo explícito
        $stmt->execute([
            $nombre_archivo,
            $file
        ]);
        
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        // Log de éxito para diagnóstico
        if ($resultado) {
            error_log("✅ Multimedia creado exitosamente - ID: " . $resultado['id_Multimedia'] . 
                     " - Archivo: {$nombre_archivo} - Tamaño: " . strlen($file) . " bytes");
        }
        
        return $resultado ? $resultado['id_Multimedia'] : false;
        
    } catch (PDOException $e) {
        // Log detallado del error
        error_log("❌ Error en Multimedia::crear() - Archivo: {$nombre_archivo} - " . 
                 "Tamaño: " . strlen($file) . " bytes - Error: " . $e->getMessage());
        return false;
    }
}

    /**
     * Obtener archivo multimedia por ID
     * @param int $id
     * @return array|false Array con datos del archivo o false si falla
     */
    public function obtenerPorId($id) {
        try {
            $stmt = $this->conn->prepare("CALL sp_multimedia_obtener_por_id(?)");
            $stmt->execute([$id]);
            
            $multimedia = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $multimedia ? $multimedia : false;
            
        } catch (PDOException $e) {
            error_log("Error en obtenerPorId(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Listar todos los archivos multimedia (solo metadata)
     * @return array|false
     */
    public function listar() {
        try {
            $stmt = $this->conn->prepare("CALL sp_multimedia_listar()");
            $stmt->execute();
            
            $multimedia = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $multimedia;
            
        } catch (PDOException $e) {
            error_log("Error en listar(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener multimedia de una publicación específica
     * @param int $id_publicacion
     * @return array|false
     */
    public function obtenerPorPublicacion($id_publicacion) {
        try {
            $stmt = $this->conn->prepare("CALL sp_multimedia_obtener_por_publicacion(?)");
            $stmt->execute([$id_publicacion]);
            
            $multimedia = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $multimedia;
            
        } catch (PDOException $e) {
            error_log("Error en obtenerPorPublicacion(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Asociar multimedia a una publicación
     * @param int $id_publicacion
     * @param int $id_multimedia
     * @param int $orden
     * @return bool
     */
    public function asociarAPublicacion($id_publicacion, $id_multimedia, $orden = 1) {
        try {
            $stmt = $this->conn->prepare("CALL sp_publicacion_multimedia_asociar(?, ?, ?)");
            $stmt->execute([$id_publicacion, $id_multimedia, $orden]);
            
            $stmt->closeCursor();
            return true;
            
        } catch (PDOException $e) {
            error_log("Error en asociarAPublicacion(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Desasociar multimedia de una publicación
     * @param int $id_publicacion
     * @param int $id_multimedia
     * @return bool
     */
    public function desasociarDePublicacion($id_publicacion, $id_multimedia) {
        try {
            $stmt = $this->conn->prepare("CALL sp_publicacion_multimedia_desasociar(?, ?)");
            $stmt->execute([$id_publicacion, $id_multimedia]);
            
            $stmt->closeCursor();
            return true;
            
        } catch (PDOException $e) {
            error_log("Error en desasociarDePublicacion(): " . $e->getMessage());
            return false;
        }
    }
}
?>