<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Modelo VistaPublicacion
 * Maneja el registro de vistas de publicaciones por usuario
 */
class VistaPublicacion {
    
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
     * Registrar una vista de publicación
     * Llama al stored procedure que valida y registra la vista
     * El trigger actualizará automáticamente el contador en Publicacion
     * 
     * @param int $idPublicacion ID de la publicación vista
     * @param int $idUsuario ID del usuario que vio la publicación
     * @param string|null $ipAddress IP del usuario (opcional)
     * @return array Array asociativo con 'codigo' y 'mensaje'
     */
    public function registrarVista($idPublicacion, $idUsuario, $ipAddress = null) {
        try {
            // Preparar llamada al stored procedure
            // sp_registrar_vista_publicacion(id_publicacion, id_usuario, ip_address)
            $stmt = $this->conn->prepare("CALL sp_registrar_vista_publicacion(?, ?, ?)");
            
            // Bindear parámetros
            $stmt->bindParam(1, $idPublicacion, PDO::PARAM_INT);
            $stmt->bindParam(2, $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(3, $ipAddress, PDO::PARAM_STR);
            
            // Ejecutar
            $stmt->execute();
            
            // Obtener respuesta del stored procedure
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Cerrar cursor para liberar la conexión
            $stmt->closeCursor();
            
            // Retornar respuesta del SP (codigo, mensaje)
            return $resultado ? $resultado : [
                'codigo' => 500,
                'mensaje' => 'Error al procesar la vista'
            ];
            
        } catch (PDOException $e) {
            error_log("Error en registrarVista(): " . $e->getMessage());
            return [
                'codigo' => 500,
                'mensaje' => 'Error de conexión con la base de datos'
            ];
        }
    }

    /**
     * Obtener total de vistas de una publicación
     * 
     * @param int $idPublicacion ID de la publicación
     * @return int|false Número de vistas o false si hay error
     */
    public function obtenerTotalVistas($idPublicacion) {
        try {
            $stmt = $this->conn->prepare(
                "SELECT COUNT(*) as total 
                 FROM Vista_Publicacion 
                 WHERE id_Publicacion = ?"
            );
            
            $stmt->execute([$idPublicacion]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultado ? (int)$resultado['total'] : 0;
            
        } catch (PDOException $e) {
            error_log("Error en obtenerTotalVistas(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si un usuario ya vio una publicación
     * 
     * @param int $idPublicacion ID de la publicación
     * @param int $idUsuario ID del usuario
     * @return bool True si ya la vio, False si no
     */
    public function usuarioYaVio($idPublicacion, $idUsuario) {
        try {
            $stmt = $this->conn->prepare(
                "SELECT COUNT(*) as existe 
                 FROM Vista_Publicacion 
                 WHERE id_Publicacion = ? AND id_Usuario = ?"
            );
            
            $stmt->execute([$idPublicacion, $idUsuario]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultado && (int)$resultado['existe'] > 0;
            
        } catch (PDOException $e) {
            error_log("Error en usuarioYaVio(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener estadísticas de vistas de un usuario
     * 
     * @param int $idUsuario ID del usuario
     * @return array|false Array con estadísticas o false si hay error
     */
    public function obtenerEstadisticasUsuario($idUsuario) {
        try {
            $stmt = $this->conn->prepare(
                "SELECT 
                    COUNT(DISTINCT vp.id_Publicacion) as publicaciones_vistas,
                    COUNT(*) as total_vistas,
                    DATE(MAX(vp.Fecha_Vista)) as ultima_vista
                 FROM Vista_Publicacion vp
                 WHERE vp.id_Usuario = ?"
            );
            
            $stmt->execute([$idUsuario]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultado ? $resultado : false;
            
        } catch (PDOException $e) {
            error_log("Error en obtenerEstadisticasUsuario(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener las publicaciones más vistas
     * 
     * @param int $limite Número máximo de resultados (default: 10)
     * @param int|null $idMundial Filtrar por mundial específico (opcional)
     * @return array|false Array de publicaciones ordenadas por vistas
     */
    public function obtenerMasVistas($limite = 10, $idMundial = null) {
        try {
            $sql = "SELECT 
                        p.id_Publicacion,
                        p.Titulo,
                        p.Views,
                        p.Fecha_Creacion,
                        COUNT(vp.id_Vista) as total_vistas_unicas
                    FROM Publicacion p
                    LEFT JOIN Vista_Publicacion vp ON p.id_Publicacion = vp.id_Publicacion
                    WHERE p.Estatus = 'Aprobada'";
            
            // Agregar filtro por mundial si se especifica
            if ($idMundial !== null) {
                $sql .= " AND p.id_Mundial = ?";
            }
            
            $sql .= " GROUP BY p.id_Publicacion
                      ORDER BY total_vistas_unicas DESC, p.Views DESC
                      LIMIT ?";
            
            $stmt = $this->conn->prepare($sql);
            
            // Bindear parámetros
            $paramIndex = 1;
            if ($idMundial !== null) {
                $stmt->bindParam($paramIndex++, $idMundial, PDO::PARAM_INT);
            }
            $stmt->bindParam($paramIndex, $limite, PDO::PARAM_INT);
            
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $resultados;
            
        } catch (PDOException $e) {
            error_log("Error en obtenerMasVistas(): " . $e->getMessage());
            return false;
        }
    }
}