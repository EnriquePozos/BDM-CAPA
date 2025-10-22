<?php
/**
 * Clase Request
 * Maneja las peticiones HTTP
 */
class Request {
    
    /**
     * Obtener datos de GET
     */
    public static function get($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    /**
     * Obtener datos de POST
     */
    public static function post($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    /**
     * Obtener datos JSON del body
     */
    public static function getJSON() {
        $json = file_get_contents('php://input');
        return json_decode($json, true);
    }

    /**
     * Obtener archivo subido
     */
    public static function file($key) {
        return isset($_FILES[$key]) ? $_FILES[$key] : null;
    }

    /**
     * Obtener método HTTP
     */
    public static function method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Verificar si es una petición POST
     */
    public static function isPost() {
        return self::method() === 'POST';
    }

    /**
     * Verificar si es una petición GET
     */
    public static function isGet() {
        return self::method() === 'GET';
    }

    /**
     * Obtener todos los datos (POST o JSON)
     */
    public static function all() {
        if (self::isPost()) {
            $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
            
            if (strpos($contentType, 'application/json') !== false) {
                return self::getJSON();
            }
            return $_POST;
        }
        return [];
    }
}
?>