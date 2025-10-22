<?php
/**
 * Clase Database
 * Maneja la conexión a la base de datos usando PDO
 */
class Database {
    private $host = "localhost";
    private $db_name = "mundiales_fifa"; // Cambia por el nombre de tu BD
    private $username = "root";        // Cambia por tu usuario
    private $password = "";            // Cambia por tu contraseña
    private $conn;

    /**
     * Obtener conexión a la base de datos
     * @return PDO|null
     */
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>