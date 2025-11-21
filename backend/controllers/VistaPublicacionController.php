<?php
require_once __DIR__ . '/../models/VistaPublicacion.php';

/**
 * Controlador de Vista de Publicaciones
 * Maneja el registro de vistas de publicaciones mediante AJAX
 */
class VistaPublicacionController {
    
    private $vistaPublicacionModel;

    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->vistaPublicacionModel = new VistaPublicacion();
    }

    /**
     * Verificar que el usuario esté autenticado
     * @return bool True si está autenticado, False si no
     */
    private function verificarAutenticacion() {
        return isset($_SESSION['usuario_id']);
    }

    /**
     * Registrar una vista de publicación (AJAX)
     * Método principal llamado desde el frontend
     */
    public function registrarVista() {
        // Validar que el usuario esté autenticado
        if (!$this->verificarAutenticacion()) {
            $this->enviarRespuestaJSON(401, false, 'Usuario no autenticado');
            return;
        }

        // Validar que vengan los datos requeridos
        if (empty($_POST['id_publicacion'])) {
            $this->enviarRespuestaJSON(400, false, 'ID de publicación requerido');
            return;
        }

        // Obtener datos
        $idPublicacion = intval($_POST['id_publicacion']);
        $idUsuario = $_SESSION['usuario_id'];
        
        // Obtener IP del usuario (opcional)
        $ipAddress = $this->obtenerIPUsuario();

        // Validar que el ID de publicación sea válido
        if ($idPublicacion <= 0) {
            $this->enviarRespuestaJSON(400, false, 'ID de publicación inválido');
            return;
        }

        // Registrar la vista a través del modelo
        $resultado = $this->vistaPublicacionModel->registrarVista(
            $idPublicacion, 
            $idUsuario, 
            $ipAddress
        );

        // Procesar respuesta del stored procedure
        if ($resultado && isset($resultado['codigo'])) {
            $codigo = (int)$resultado['codigo'];
            $mensaje = $resultado['mensaje'];

            // Determinar si fue exitoso según el código
            // 200 = Ya vista, 201 = Nueva vista registrada
            $exitoso = ($codigo === 200 || $codigo === 201);

            // Enviar respuesta JSON
            $this->enviarRespuestaJSON($codigo, $exitoso, $mensaje);
        } else {
            // Error inesperado
            $this->enviarRespuestaJSON(500, false, 'Error al procesar la solicitud');
        }
    }

    /**
     * Obtener total de vistas de una publicación (AJAX)
     */
    public function obtenerTotalVistas() {
        // Validar que venga el ID de publicación
        if (empty($_GET['id_publicacion'])) {
            $this->enviarRespuestaJSON(400, false, 'ID de publicación requerido');
            return;
        }

        $idPublicacion = intval($_GET['id_publicacion']);

        // Obtener total de vistas
        $totalVistas = $this->vistaPublicacionModel->obtenerTotalVistas($idPublicacion);

        if ($totalVistas !== false) {
            $this->enviarRespuestaJSON(200, true, 'Total de vistas obtenido', [
                'total_vistas' => $totalVistas
            ]);
        } else {
            $this->enviarRespuestaJSON(500, false, 'Error al obtener vistas');
        }
    }

    /**
     * Verificar si usuario ya vio una publicación (AJAX)
     */
    public function verificarVistaUsuario() {
        // Validar autenticación
        if (!$this->verificarAutenticacion()) {
            $this->enviarRespuestaJSON(401, false, 'Usuario no autenticado');
            return;
        }

        // Validar que venga el ID de publicación
        if (empty($_GET['id_publicacion'])) {
            $this->enviarRespuestaJSON(400, false, 'ID de publicación requerido');
            return;
        }

        $idPublicacion = intval($_GET['id_publicacion']);
        $idUsuario = $_SESSION['usuario_id'];

        // Verificar si ya vio la publicación
        $yaVio = $this->vistaPublicacionModel->usuarioYaVio($idPublicacion, $idUsuario);

        $this->enviarRespuestaJSON(200, true, 'Verificación completada', [
            'ya_visto' => $yaVio
        ]);
    }

    /**
     * Obtener estadísticas de vistas del usuario (AJAX)
     */
    public function obtenerEstadisticasUsuario() {
        // Validar autenticación
        if (!$this->verificarAutenticacion()) {
            $this->enviarRespuestaJSON(401, false, 'Usuario no autenticado');
            return;
        }

        $idUsuario = $_SESSION['usuario_id'];

        // Obtener estadísticas
        $estadisticas = $this->vistaPublicacionModel->obtenerEstadisticasUsuario($idUsuario);

        if ($estadisticas) {
            $this->enviarRespuestaJSON(200, true, 'Estadísticas obtenidas', $estadisticas);
        } else {
            $this->enviarRespuestaJSON(500, false, 'Error al obtener estadísticas');
        }
    }

    /**
     * Obtener publicaciones más vistas (AJAX)
     */
    public function obtenerMasVistas() {
        // Obtener parámetros opcionales
        $limite = isset($_GET['limite']) ? intval($_GET['limite']) : 10;
        $idMundial = isset($_GET['id_mundial']) ? intval($_GET['id_mundial']) : null;

        // Validar límite
        if ($limite <= 0 || $limite > 50) {
            $limite = 10;
        }

        // Obtener publicaciones más vistas
        $publicaciones = $this->vistaPublicacionModel->obtenerMasVistas($limite, $idMundial);

        if ($publicaciones !== false) {
            $this->enviarRespuestaJSON(200, true, 'Publicaciones obtenidas', [
                'publicaciones' => $publicaciones,
                'total' => count($publicaciones)
            ]);
        } else {
            $this->enviarRespuestaJSON(500, false, 'Error al obtener publicaciones');
        }
    }

    /**
     * Enviar respuesta en formato JSON
     * @param int $httpCode Código HTTP (200, 400, 401, 500, etc.)
     * @param bool $exitoso Si la operación fue exitosa
     * @param string $mensaje Mensaje descriptivo
     * @param array $datos Datos adicionales (opcional)
     */
    private function enviarRespuestaJSON($httpCode, $exitoso, $mensaje, $datos = []) {
        // Establecer código de respuesta HTTP
        http_response_code($httpCode);
        
        // Establecer header JSON
        header('Content-Type: application/json; charset=utf-8');
        
        // Preparar respuesta
        $respuesta = [
            'exitoso' => $exitoso,
            'mensaje' => $mensaje,
            'codigo' => $httpCode
        ];

        // Agregar datos adicionales si existen
        if (!empty($datos)) {
            $respuesta['datos'] = $datos;
        }

        // Enviar respuesta JSON
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit();
    }

    /**
     * Obtener la dirección IP del usuario
     * Considera proxies y balanceadores de carga
     * @return string IP del usuario
     */
    private function obtenerIPUsuario() {
        // Verificar si viene de un proxy
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Puede contener múltiples IPs separadas por comas
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        }

        // Validar formato de IP
        $ip = trim($ip);
        
        // Validar que sea una IP válida (IPv4 o IPv6)
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }

        return 'unknown';
    }

    /**
     * Método auxiliar para debugging (solo en desarrollo)
     * Eliminar en producción
     */
    public function test() {
        if ($this->verificarAutenticacion()) {
            $this->enviarRespuestaJSON(200, true, 'Controlador funcionando correctamente', [
                'usuario_id' => $_SESSION['usuario_id'],
                'usuario_nombre' => $_SESSION['usuario_nombre'] ?? 'N/A'
            ]);
        } else {
            $this->enviarRespuestaJSON(401, false, 'Usuario no autenticado');
        }
    }
}