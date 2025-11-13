<?php
require_once __DIR__ . '/../models/Usuario.php';

/**
 * Controlador de Usuario
 * Maneja operaciones CRUD de usuarios (solo para administradores)
 */
class UsuarioController {
    
    private $usuarioModel;

    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->usuarioModel = new Usuario();
    }

    /**
     * Verificar que el usuario esté autenticado y sea administrador
     */
    private function verificarAdmin() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ../../src/login.php?error=Debes iniciar sesión');
            exit();
        }

        if ($_SESSION['usuario_tipo'] != 1) {
            header('Location: ../../src/index.php?error=Acceso denegado');
            exit();
        }
    }

    /**
     * Listar todos los usuarios
     * Retorna los datos para mostrar en el dashboard
     */
    public function listar() {
        $this->verificarAdmin();

        $usuarios = $this->usuarioModel->listarTodos();

        if ($usuarios === false) {
            header('Location: ../../src/dashboard-admin.php?error=Error al cargar usuarios');
            exit();
        }

        // Retornar los usuarios para que el dashboard los muestre
        return $usuarios;
    }

    /**
     * Actualizar un usuario
     * Procesa el formulario de edición
     */
    public function actualizar() {
        $this->verificarAdmin();

        // Validar que vengan los datos requeridos
        if (empty($_POST['id_usuario'])) {
            $this->redirectWithError('ID de usuario requerido');
            return;
        }

        $id = intval($_POST['id_usuario']);

        // Validar campos requeridos
        $camposRequeridos = ['nombre', 'correo', 'pais_nacimiento', 'genero', 'nacionalidad', 'fecha_nacimiento'];
        
        foreach ($camposRequeridos as $campo) {
            if (empty($_POST[$campo])) {
                $this->redirectWithError('Todos los campos son obligatorios');
                return;
            }
        }

        // Validar formato de correo
        if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
            $this->redirectWithError('Correo electrónico inválido');
            return;
        }

        // Preparar datos para actualizar
        $datos = [
            'nombre' => trim($_POST['nombre']),
            'correo' => trim($_POST['correo']),
            'pais_nacimiento' => trim($_POST['pais_nacimiento']),
            'genero' => trim($_POST['genero']),
            'nacionalidad' => trim($_POST['nacionalidad']),
            'fecha_nacimiento' => trim($_POST['fecha_nacimiento']),
            'tipo_usuario' => isset($_POST['tipo_usuario']) ? intval($_POST['tipo_usuario']) : 0,
            'activo' => isset($_POST['activo']) ? intval($_POST['activo']) : 1
        ];

        // Intentar actualizar
        $resultado = $this->usuarioModel->actualizar($id, $datos);

        if ($resultado) {
            header('Location: ../../src/dashboard-admin.php?seccion=usuarios&success=Usuario actualizado correctamente');
        } else {
            $this->redirectWithError('Error al actualizar usuario. El correo podría estar en uso.');
        }
        exit();
    }

    /**
     * Eliminar (desactivar) un usuario
     */
    public function eliminar() {
        $this->verificarAdmin();

        // Validar que venga el ID
        if (empty($_POST['id_usuario'])) {
            $this->redirectWithError('ID de usuario requerido');
            return;
        }

        $id = intval($_POST['id_usuario']);

        // No permitir que el admin se elimine a sí mismo
        if ($id == $_SESSION['usuario_id']) {
            $this->redirectWithError('No puedes eliminar tu propio usuario');
            return;
        }

        // Intentar eliminar
        $resultado = $this->usuarioModel->eliminar($id);

        if ($resultado) {
            header('Location: ../../src/dashboard-admin.php?seccion=usuarios&success=Usuario eliminado correctamente');
        } else {
            $this->redirectWithError('Error al eliminar usuario');
        }
        exit();
    }

    /**
     * Redirigir con mensaje de error
     */
    private function redirectWithError($mensaje) {
        header('Location: ../../src/dashboard-admin.php?seccion=usuarios&error=' . urlencode($mensaje));
        exit();
    }
}
?>