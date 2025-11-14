<?php
require_once __DIR__ . '/../models/Mundial.php';

/**
 * Controlador de Mundiales
 */
class MundialController {
    
    private $mundialModel;

    /**
     * Constructor
     */
    public function __construct() {
        $this->mundialModel = new Mundial();
    }

    /**
     * Listar todos los mundiales
     */
    public function listar() {
        $mundiales = $this->mundialModel->listar();
        
        if ($mundiales === false) {
            return [];
        }
        
        return $mundiales;
    }

    /**
     * Crear nuevo mundial
     */
    public function crear() {
        // Validar campos obligatorios
        if (!isset($_POST['nombre']) || empty(trim($_POST['nombre']))) {
            header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=El nombre del mundial es obligatorio');
            exit();
        }
        
        if (!isset($_POST['anio']) || empty($_POST['anio'])) {
            header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=El año es obligatorio');
            exit();
        }
        
        if (!isset($_POST['sede']) || empty(trim($_POST['sede']))) {
            header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=La sede es obligatoria');
            exit();
        }
        
        // Procesar logo (archivo subido)
        $logo = null;
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            // Validar tipo de archivo
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $tipoArchivo = $_FILES['logo']['type'];
            
            if (!in_array($tipoArchivo, $tiposPermitidos)) {
                header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=El logo debe ser una imagen (JPG, PNG, GIF, WEBP)');
                exit();
            }
            
            // Validar tamaño (máximo 5MB)
            if ($_FILES['logo']['size'] > 5 * 1024 * 1024) {
                header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=El logo no debe exceder 5MB');
                exit();
            }
            
            // Leer el archivo como binario
            $logo = file_get_contents($_FILES['logo']['tmp_name']);
        }
        
        // Preparar datos
        $datos = [
            'nombre' => trim($_POST['nombre']),
            'anio' => intval($_POST['anio']),
            'sede' => trim($_POST['sede']),
            'descripcion' => isset($_POST['descripcion']) ? trim($_POST['descripcion']) : null,
            'logo' => $logo
        ];
        
        // Validar año (debe ser entre 1930 y 2100)
        if ($datos['anio'] < 1930 || $datos['anio'] > 2100) {
            header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=El año debe estar entre 1930 y 2100');
            exit();
        }
        
        // Intentar crear el mundial
        $idMundial = $this->mundialModel->crear($datos);
        
        if ($idMundial === false) {
            header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=Error al crear el mundial. Puede que el año ya exista');
            exit();
        }
        
        // Éxito
        header('Location: ../../src/dashboard-admin.php?seccion=mundiales&exito=Mundial creado exitosamente');
        exit();
    }

    /**
     * Actualizar mundial existente
     */
    public function actualizar() {
        // Validar que venga el ID
        if (!isset($_POST['id_mundial']) || empty($_POST['id_mundial'])) {
            header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=ID de mundial no especificado');
            exit();
        }
        
        $idMundial = intval($_POST['id_mundial']);
        
        // Validar campos obligatorios
        if (!isset($_POST['nombre']) || empty(trim($_POST['nombre']))) {
            header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=El nombre del mundial es obligatorio');
            exit();
        }
        
        if (!isset($_POST['anio']) || empty($_POST['anio'])) {
            header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=El año es obligatorio');
            exit();
        }
        
        if (!isset($_POST['sede']) || empty(trim($_POST['sede']))) {
            header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=La sede es obligatoria');
            exit();
        }
        
        // Procesar logo (archivo subido) - solo si se subió uno nuevo
        $logo = null;
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            // Validar tipo de archivo
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $tipoArchivo = $_FILES['logo']['type'];
            
            if (!in_array($tipoArchivo, $tiposPermitidos)) {
                header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=El logo debe ser una imagen (JPG, PNG, GIF, WEBP)');
                exit();
            }
            
            // Validar tamaño (máximo 5MB)
            if ($_FILES['logo']['size'] > 5 * 1024 * 1024) {
                header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=El logo no debe exceder 5MB');
                exit();
            }
            
            // Leer el archivo como binario
            $logo = file_get_contents($_FILES['logo']['tmp_name']);
        }
        
        // Preparar datos
        $datos = [
            'nombre' => trim($_POST['nombre']),
            'anio' => intval($_POST['anio']),
            'sede' => trim($_POST['sede']),
            'descripcion' => isset($_POST['descripcion']) ? trim($_POST['descripcion']) : null,
            'logo' => $logo
        ];
        
        // Validar año (debe ser entre 1930 y 2100)
        if ($datos['anio'] < 1930 || $datos['anio'] > 2100) {
            header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=El año debe estar entre 1930 y 2100');
            exit();
        }
        
        // Intentar actualizar el mundial
        $resultado = $this->mundialModel->actualizar($idMundial, $datos);
        
        if ($resultado === false) {
            header('Location: ../../src/dashboard-admin.php?seccion=mundiales&error=Error al actualizar el mundial. Puede que el año ya exista en otro mundial');
            exit();
        }
        
        // Éxito
        header('Location: ../../src/dashboard-admin.php?seccion=mundiales&exito=Mundial actualizado exitosamente');
        exit();
    }
}
?>