<?php
require_once __DIR__ . '/../models/Categoria.php';

/**
 * Controlador de Categorías
 */
class CategoriaController {
    
    private $categoriaModel;

    /**
     * Constructor
     */
    public function __construct() {
        $this->categoriaModel = new Categoria();
    }

    /**
     * Listar todas las categorías
     */
    public function listar() {
        $categorias = $this->categoriaModel->listar();
        
        if ($categorias === false) {
            header('Location: ../../src/dashboard-admin.php?error=Error al cargar categorías');
            exit();
        }
        
        return $categorias;
    }

    /**
     * Crear nueva categoría
     */
    public function crear() {
        // Validar que venga el nombre
        if (!isset($_POST['nombre']) || empty(trim($_POST['nombre']))) {
            header('Location: ../../src/dashboard-admin.php?error=El nombre de la categoría es obligatorio');
            exit();
        }
        
        $nombre = trim($_POST['nombre']);
        
        // Validar longitud mínima
        if (strlen($nombre) < 3) {
            header('Location: ../../src/dashboard-admin.php?error=El nombre debe tener al menos 3 caracteres');
            exit();
        }
        
        // Intentar crear la categoría
        $idCategoria = $this->categoriaModel->crear($nombre);
        
        if ($idCategoria === false) {
            header('Location: ../../src/dashboard-admin.php?error=Error al crear la categoría. Puede que ya exista');
            exit();
        }
        
        // Éxito
        header('Location: ../../src/dashboard-admin.php?exito=Categoría creada exitosamente');
        exit();
    }
}
?>