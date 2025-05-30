<?php
class Database {
    private $host = "localhost";
    private $usuario = "root";
    private $password = "";
    private $nombre_bd = "db_ndong_viajes";
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli(
            $this->host,
            $this->usuario,
            $this->password,
            $this->nombre_bd
        );

        // Verificamos si hubo un error en la conexión
        if ($this->conexion->connect_error) {
            die("Error en la conexión: " . $this->conexion->connect_error);
        }

        // Forzar uso de UTF-8
        $this->conexion->set_charset("utf8mb4");
    }

    // Método para obtener la conexión desde fuera de la clase
    public function getConexion() {
        return $this->conexion;
    }

    // Cerrar conexión (opcional)
    public function cerrarConexion() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}

$obj = new Database();
$obj->getConexion();

if ($obj->getConexion()->connect_error) {
    die("Error de conexión: " . $obj->getConexion()->connect_error);
} else {
    // echo "Conexión exitosa";
}


?>
