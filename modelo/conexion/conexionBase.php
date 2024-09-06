<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    die();
}
$data = json_decode(
    file_get_contents("php://input", true)
);
class ConexionBase {
    // Definición de atributos
    private $host;
    private $user;
    private $password;
    private $database;
    private $conn;

    public function __construct() {
        // Constructor
        require_once "configDb.php";
        $this->host = HOST;
        $this->user = USER;
        $this->password = PASSWORD;
        $this->database = DATABASE;
    }

    public function createConnection() {
        // Método que crea y retorna la conexión a la BD
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->conn->connect_error) {
            throw new Exception("Error al conectarse a MySQL: (" . $this->conn->connect_errno . ") " . $this->conn->connect_error);
        }

        // Establecer el conjunto de caracteres a utf8
        if (!$this->conn->set_charset("utf8")) {
            throw new Exception("Error cargando el conjunto de caracteres utf8: " . $this->conn->error);
        }
    }

    public function closeConnection() {
        // Método que cierra la conexión a la BD
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function executeQuery($sql) {
        // Método que ejecuta una consulta SQL
        $result = $this->conn->query($sql);

        if (!$result) {
            throw new Exception("Error en la consulta SQL: " . $this->conn->error);
        }

        return $result;
    }

    public function getCountAffectedRows() {
        // Método que retorna la cantidad de filas afectadas con el último query realizado
        return $this->conn->affected_rows;
    }

    public function getRows($result) {
        // Método que retorna la última fila de un resultado en forma de arreglo asociativo
        return $result->fetch_assoc();
    }

    public function setFreeResult($result) {
        // Método que libera el resultado del query
        $result->free();
    }

    public function escapeString($string) {
        // Método que escapa las cadenas para evitar inyecciones SQL
        return $this->conn->real_escape_string($string);
    }

    // Métodos para manejo de transacciones
    public function beginTransaction() {
        $this->conn->begin_transaction();
    }

    public function commit() {
        $this->conn->commit();
    }

    public function rollBack() {
        $this->conn->rollback();
    }

    // Método para preparar una sentencia SQL
    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    // Método para obtener el último ID insertado
    public function lastInsertId() {
        return $this->conn->insert_id;
    }
}
?>
