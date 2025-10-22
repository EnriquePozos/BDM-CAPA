<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../utils/Response.php';

/**
 * Controlador de Autenticación
 * Maneja login, logout y sesiones
 */
class AuthController {
    
    private $usuarioModel;

    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->usuarioModel = new Usuario();
    }

    /**
     * Procesar login
     */
    public function login() {
        // Validar que vengan los datos
        if (empty($_POST['correo']) || empty($_POST['contrasena'])) {
            $this->redirectWithError('Correo y contraseña son requeridos');
            return;
        }

        $correo = trim($_POST['correo']);
        $contrasena = trim($_POST['contrasena']);

        // Validar formato de correo
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->redirectWithError('Correo electrónico inválido');
            return;
        }

        // Intentar login
        $usuario = $this->usuarioModel->login($correo, $contrasena);

        if ($usuario) {
            // Login exitoso - Guardar datos en sesión
            $_SESSION['usuario_id'] = $usuario['id_Usuario'];
            $_SESSION['usuario_nombre'] = $usuario['Nombre'];
            $_SESSION['usuario_correo'] = $usuario['Correo'];
            $_SESSION['usuario_tipo'] = $usuario['Tipo_Usuario'];
            $_SESSION['usuario_foto'] = $usuario['Foto'];
            
            // Redireccionar según tipo de usuario
            if ($usuario['Tipo_Usuario'] == 1) {
                // Administrador
                header('Location: ../../src/dashboard-admin.php');
            } else {
                // Usuario normal
                header('Location: ../../src/index.php');
            }
            exit();
        } else {
            // Login fallido
            $this->redirectWithError('Correo o contraseña incorrectos');
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        session_destroy();
        header('Location: ../../src/login.php?mensaje=Sesión cerrada correctamente');
        exit();
    }

    /**
     * Verificar si hay sesión activa
     */
    public function verificarSesion() {
        return isset($_SESSION['usuario_id']);
    }

    /**
     * Redireccionar con mensaje de error
     */
    private function redirectWithError($mensaje) {
        header('Location: ../../src/login.php?error=' . urlencode($mensaje));
        exit();
    }
}
?>
