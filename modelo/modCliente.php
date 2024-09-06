<?php
session_start();

include_once "conexion/conexionBase.php";

class Cliente
{
    private $idCliente;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $direccion;
    private $email;
    private $con;

    public function __construct()
    {
        $this->idCliente = null;
        $this->nombre = "";
        $this->apellido1 = "";
        $this->apellido2 = "";
        $this->direccion = "";
        $this->email = "";
        $this->con = new ConexionBase();
    }

    /**
     * @return null
     */
    public function getIdCliente()
    {
        return $this->idCliente;
    }

    /**
     * @param null $idCliente
     */
    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellido1(): string
    {
        return $this->apellido1;
    }

    public function setApellido1(string $apellido1)
    {
        $this->apellido1 = $apellido1;
    }

    public function getApellido2(): string
    {
        return $this->apellido2;
    }

    public function setApellido2(string $apellido2)
    {
        $this->apellido2 = $apellido2;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion)
    {
        $this->direccion = $direccion;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function RegistrarCliente()
    {
        $resp = $this->validarEmail($this->email);
        if ($resp) {
            echo json_encode(array("mensaje" => "El email ya existe"));
        } else {
            $this->con->createConnection();
            $sql = "insert into cliente(nombre, apellido1, apellido2, direccion, email)
            values('$this->nombre', '$this->apellido1', '$this->apellido2', '$this->direccion', '$this->email')";
            $this->con->executeQuery($sql);
            echo json_encode(array("mensaje" => "Cliente Registrado"));
        }

    }

    private function validarEmail($email)
    {
        $this->con->createConnection();
        $sql = "select email from cliente where email='$email'";
        $resp = $this->con->executeQuery($sql);
        $datos = $this->con->getCountAffectedRows($resp);
        if ($datos == true) {
            return true;
        } else {
            return false;
        }
    }

}