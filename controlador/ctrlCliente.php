<?php
include_once "../modelo/modCliente.php";
if($method=="POST"){
    $nombre=htmlspecialchars($data->nombre);
    $apellido1=htmlspecialchars($data->apellido1);
    $apellido2=htmlspecialchars($data->apellido2);
    $email=htmlspecialchars($data->email);
    $direccion=htmlspecialchars($data->direccion);
    $cliente= new Cliente();
    $cliente->setNombre($nombre);
    $cliente->setApellido1($apellido1);
    $cliente->setApellido2($apellido2);
    $cliente->setEmail($email);
    $cliente->setDireccion($direccion);
    $cliente->RegistrarCliente();
}