<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Publicacion.php';

/**
 * Controlador de Perfil
 * Maneja operaciones del perfil del usuario autenticado
 */
class PerfilController {
    
    private $usuarioModel;
    private $publicacionModel;

    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->usuarioModel = new Usuario();
        $this->publicacionModel = new Publicacion();
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
     * Obtener datos del perfil del usuario
     * Retorna información completa del usuario con estadísticas
     */
    public function obtenerPerfil() {
        $this->verificarAutenticacion();

        $id_usuario = $_SESSION['usuario_id'];

        // Obtener datos básicos del usuario
        $usuario = $this->usuarioModel->obtenerPorId($id_usuario);

        if (!$usuario) {
            header('Location: ../../src/dashboard-usuario.php?error=Error al cargar perfil');
            exit();
        }

        // Obtener estadísticas del usuario
        $estadisticas = $this->usuarioModel->obtenerEstadisticas($id_usuario);

        // Combinar datos
        $perfil = array_merge($usuario, $estadisticas ? $estadisticas : []);

        return $perfil;
    }

    /**
     * Obtener publicaciones del usuario con estadísticas
     * @param string $filtro Filtro de estatus: 'todas', 'Aprobada', 'Pendiente', 'Rechazada'
     * @return array
     */
    public function obtenerPublicaciones($filtro = 'todas') {
        $this->verificarAutenticacion();

        $id_usuario = $_SESSION['usuario_id'];

        // Obtener publicaciones con estadísticas
        $publicaciones = $this->publicacionModel->obtenerPorUsuarioConStats($id_usuario, $filtro);

        if ($publicaciones === false) {
            return [];
        }

        return $publicaciones;
    }

    /**
     * Actualizar datos del perfil
     * NO actualiza correo ni tipo_usuario
     */
    public function actualizarPerfil() {
        $this->verificarAutenticacion();

        $id_usuario = $_SESSION['usuario_id'];

        // Validar campos requeridos
        $camposRequeridos = ['nombre', 'pais_nacimiento', 'genero', 'nacionalidad', 'fecha_nacimiento'];
        
        foreach ($camposRequeridos as $campo) {
            if (empty($_POST[$campo])) {
                $this->redirectWithError('Todos los campos son obligatorios');
                return;
            }
        }

        // Validar fecha de nacimiento (mínimo 12 años)
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $edad = date_diff(date_create($fecha_nacimiento), date_create('now'))->y;
        
        if ($edad < 12) {
            $this->redirectWithError('Debes tener al menos 12 años para usar la plataforma');
            return;
        }

        // Procesar foto si se subió
        $foto = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
        }

        // Preparar datos
        $datos = [
            'nombre' => trim($_POST['nombre']),
            'foto' => $foto,
            'pais_nacimiento' => trim($_POST['pais_nacimiento']),
            'genero' => trim($_POST['genero']),
            'nacionalidad' => trim($_POST['nacionalidad']),
            'fecha_nacimiento' => $fecha_nacimiento
        ];

        // Actualizar perfil
        $resultado = $this->usuarioModel->actualizarPerfil($id_usuario, $datos);

        if ($resultado) {
            // Actualizar datos en sesión
            $_SESSION['usuario_nombre'] = $datos['nombre'];
            if ($foto) {
                $_SESSION['usuario_foto'] = $foto;
            }

            $this->redirectWithSuccess('Perfil actualizado correctamente');
        } else {
            $this->redirectWithError('Error al actualizar el perfil');
        }
    }

    /**
     * Cambiar contraseña del usuario
     */
    public function cambiarContrasena() {
        $this->verificarAutenticacion();

        $id_usuario = $_SESSION['usuario_id'];

        // Validar campos requeridos
        if (empty($_POST['contrasena_actual']) || empty($_POST['contrasena_nueva']) || empty($_POST['contrasena_confirmar'])) {
            $this->redirectWithError('Todos los campos de contraseña son obligatorios');
            return;
        }

        $contrasena_actual = $_POST['contrasena_actual'];
        $contrasena_nueva = $_POST['contrasena_nueva'];
        $contrasena_confirmar = $_POST['contrasena_confirmar'];

        // Validar que las contraseñas coincidan
        if ($contrasena_nueva !== $contrasena_confirmar) {
            $this->redirectWithError('Las contraseñas nuevas no coinciden');
            return;
        }

        // Validar longitud mínima
        if (strlen($contrasena_nueva) < 8) {
            $this->redirectWithError('La contraseña debe tener al menos 8 caracteres');
            return;
        }

        // Intentar cambiar contraseña
        try {
            $resultado = $this->usuarioModel->cambiarContrasena($id_usuario, $contrasena_actual, $contrasena_nueva);

            if ($resultado) {
                $this->redirectWithSuccess('Contraseña actualizada correctamente');
            } else {
                $this->redirectWithError('Error al cambiar la contraseña');
            }
        } catch (Exception $e) {
            // Capturar error específico del stored procedure
            $this->redirectWithError('La contraseña actual es incorrecta');
        }
    }

    /**
     * Redirigir con mensaje de éxito
     */
    private function redirectWithSuccess($mensaje) {
        header('Location: ../../src/dashboard-usuario.php?success=' . urlencode($mensaje));
        exit();
    }

    /**
     * Redirigir con mensaje de error
     */
    private function redirectWithError($mensaje) {
        header('Location: ../../src/dashboard-usuario.php?error=' . urlencode($mensaje));
        exit();
    }
}
?>