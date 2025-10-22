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
 * Procesar registro de nuevo usuario
 */
public function registrar() {
    // Validar que vengan todos los datos requeridos
    $camposRequeridos = ['nombre', 'correo', 'contrasena', 'pais_nacimiento', 'genero', 'nacionalidad', 'fecha_nacimiento'];
    
    foreach ($camposRequeridos as $campo) {
        if (empty($_POST[$campo])) {
            $this->redirectWithErrorRegistro('Todos los campos son obligatorios');
            return;
        }
    }

    // Obtener y limpiar datos
    $datos = [
        'nombre' => trim($_POST['nombre']),
        'correo' => trim($_POST['correo']),
        'contrasena' => trim($_POST['contrasena']),
        'foto' => isset($_POST['foto']) ? trim($_POST['foto']) : 'default.jpg',
        'pais_nacimiento' => trim($_POST['pais_nacimiento']),
        'genero' => trim($_POST['genero']),
        'nacionalidad' => trim($_POST['nacionalidad']),
        'fecha_nacimiento' => trim($_POST['fecha_nacimiento']),
        'tipo_usuario' => 0 // Por defecto usuario normal
    ];

    // Validar formato de correo
    if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
        $this->redirectWithErrorRegistro('Correo electrónico inválido');
        return;
    }

    // Validar contraseña
    if (strlen($datos['contrasena']) < 8) {
        $this->redirectWithErrorRegistro('La contraseña debe tener mínimo 8 caracteres');
        return;
    }

    if (!preg_match('/[A-Z]/', $datos['contrasena'])) {
        $this->redirectWithErrorRegistro('La contraseña debe tener al menos una mayúscula');
        return;
    }

    if (!preg_match('/[0-9]/', $datos['contrasena'])) {
        $this->redirectWithErrorRegistro('La contraseña debe tener al menos un número');
        return;
    }

    // Validar confirmación de contraseña (si existe)
    if (isset($_POST['confirmar_contrasena'])) {
        if ($datos['contrasena'] !== $_POST['confirmar_contrasena']) {
            $this->redirectWithErrorRegistro('Las contraseñas no coinciden');
            return;
        }
    }

    // Intentar crear usuario
    try {
        $idUsuario = $this->usuarioModel->crear($datos);

        if ($idUsuario) {
            // Registro exitoso - Redirigir a login con mensaje
            header('Location: ../../src/login.php?mensaje=Registro exitoso. Ya puedes iniciar sesión');
            exit();
        } else {
            $this->redirectWithErrorRegistro('Error al crear el usuario. Intenta nuevamente');
        }
    } catch (Exception $e) {
        // Si el correo ya existe, el SP lanzará un error
        $this->redirectWithErrorRegistro('El correo electrónico ya está registrado');
    }
}

/**
 * Redireccionar con mensaje de error al registro
 */
private function redirectWithErrorRegistro($mensaje) {
    header('Location: ../../src/registro.php?error=' . urlencode($mensaje));
    exit();
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
