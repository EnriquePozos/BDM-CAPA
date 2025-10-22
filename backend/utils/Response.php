<?php
/**
 * Clase Response
 * Maneja las respuestas JSON de la API
 */
class Response {
    
    /**
     * Enviar respuesta JSON exitosa
     */
    public static function success($data = [], $message = "Operación exitosa", $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }

    /**
     * Enviar respuesta JSON de error
     */
    public static function error($message = "Error en la operación", $statusCode = 400, $errors = []) {
        http_response_code($statusCode);
        echo json_encode([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ]);
        exit;
    }

    /**
     * Respuesta no autorizado (401)
     */
    public static function unauthorized($message = "No autorizado") {
        self::error($message, 401);
    }

    /**
     * Respuesta prohibido (403)
     */
    public static function forbidden($message = "Acceso denegado") {
        self::error($message, 403);
    }

    /**
     * Respuesta no encontrado (404)
     */
    public static function notFound($message = "Recurso no encontrado") {
        self::error($message, 404);
    }

    /**
     * Respuesta error del servidor (500)
     */
    public static function serverError($message = "Error interno del servidor") {
        self::error($message, 500);
    }
}
?>