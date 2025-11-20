<?php
require_once __DIR__ . '/../models/Multimedia.php';

/**
 * Controlador de Multimedia
 * Maneja subida y gestión de archivos multimedia (imágenes/videos)
 */
class MultimediaController {
    
    private $multimediaModel;
    private $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'avi', 'mov'];
    private $tamanoMaximo = 104857600; // 100MB en bytes

    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->multimediaModel = new Multimedia();
    }

    /**
     * Verificar que el usuario esté autenticado
     */
    private function verificarAutenticacion() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ../../src/login.php?error=Debes iniciar sesión');
            exit();
        }
    }

    /**
     * Subir archivo multimedia
     * @return int|false ID del archivo creado o false si falla
     */
    public function subir() {
        $this->verificarAutenticacion();

        // Validar que venga un archivo
        if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $archivo = $_FILES['archivo'];

        // Validar extensión
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->extensionesPermitidas)) {
            return false;
        }

        // Validar tamaño
        if ($archivo['size'] > $this->tamanoMaximo) {
            return false;
        }

        // Leer el archivo como BLOB
        $archivoBlob = file_get_contents($archivo['tmp_name']);
        
        if ($archivoBlob === false) {
            return false;
        }

        // Guardar en base de datos
        $nombreArchivo = $archivo['name'];
        $idMultimedia = $this->multimediaModel->crear($nombreArchivo, $archivoBlob);

        return $idMultimedia;
    }

    /**
     * Subir múltiples archivos
     * @return array Array de IDs de archivos creados
     */
    public function subirMultiples() {
        $this->verificarAutenticacion();

        $idsMultimedia = [];

        // Verificar que vengan archivos
        if (!isset($_FILES['archivos']) || !is_array($_FILES['archivos']['name'])) {
            return $idsMultimedia;
        }

        $totalArchivos = count($_FILES['archivos']['name']);

        for ($i = 0; $i < $totalArchivos; $i++) {
            // Verificar que no haya error en este archivo
            if ($_FILES['archivos']['error'][$i] !== UPLOAD_ERR_OK) {
                continue;
            }

            // Validar extensión
            $nombreArchivo = $_FILES['archivos']['name'][$i];
            $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
            
            if (!in_array($extension, $this->extensionesPermitidas)) {
                continue;
            }

            // Validar tamaño
            if ($_FILES['archivos']['size'][$i] > $this->tamanoMaximo) {
                continue;
            }

            // Leer el archivo como BLOB
            $archivoBlob = file_get_contents($_FILES['archivos']['tmp_name'][$i]);
            
            if ($archivoBlob === false) {
                continue;
            }

            // Guardar en base de datos
            $idMultimedia = $this->multimediaModel->crear($nombreArchivo, $archivoBlob);

            if ($idMultimedia) {
                $idsMultimedia[] = $idMultimedia;
            }
        }

        return $idsMultimedia;
    }

    /**
     * Obtener archivo multimedia por ID
     */
    public function obtenerPorId($id) {
        return $this->multimediaModel->obtenerPorId($id);
    }

    /**
     * Servir archivo multimedia (para mostrar en navegador)
     */
    public function servir() {
        // Validar que venga el ID
        if (empty($_GET['id'])) {
            http_response_code(404);
            exit();
        }

        $id = intval($_GET['id']);
        $multimedia = $this->multimediaModel->obtenerPorId($id);

        if (!$multimedia) {
            http_response_code(404);
            exit();
        }

        // Determinar tipo MIME basado en extensión
        $extension = strtolower(pathinfo($multimedia['Nombre_Archivo'], PATHINFO_EXTENSION));
        $tiposMime = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'mp4' => 'video/mp4',
            'avi' => 'video/x-msvideo',
            'mov' => 'video/quicktime'
        ];

        $contentType = $tiposMime[$extension] ?? 'application/octet-stream';

        // Enviar headers
        header('Content-Type: ' . $contentType);
        header('Content-Length: ' . strlen($multimedia['File']));
        header('Cache-Control: public, max-age=86400'); // Cache por 1 día

        // Enviar archivo
        echo $multimedia['File'];
        exit();
    }

    /**
     * Listar todos los archivos (solo metadata)
     */
    public function listar() {
        $this->verificarAutenticacion();
        return $this->multimediaModel->listar();
    }

    /**
     * Obtener multimedia de una publicación
     */
    public function obtenerPorPublicacion($idPublicacion) {
        return $this->multimediaModel->obtenerPorPublicacion($idPublicacion);
    }

    /**
     * Asociar multimedia a publicación
     */
    public function asociarAPublicacion($idPublicacion, $idMultimedia, $orden = 1) {
        $this->verificarAutenticacion();
        return $this->multimediaModel->asociarAPublicacion($idPublicacion, $idMultimedia, $orden);
    }

    /**
     * Validar archivo (sin guardarlo)
     */
    public function validarArchivo($archivo) {
        // Validar extensión
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->extensionesPermitidas)) {
            return ['valido' => false, 'error' => 'Extensión no permitida'];
        }

        // Validar tamaño
        if ($archivo['size'] > $this->tamanoMaximo) {
            return ['valido' => false, 'error' => 'Archivo muy grande (máx 10MB)'];
        }

        return ['valido' => true];
    }
}
?>