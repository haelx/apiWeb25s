<?php
include_once "../modelo/modCliente.php";
if($method=="POST"){
    // Función para validar y sanitizar los datos
    function validarCampo($campo, $nombreCampo) {
        if (isset($campo) && !empty($campo)) {
            return htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');
        } else {
            echo json_encode([
                "status" => 404,
                "mensaje" => "Falta el " . $nombreCampo
            ]);
            exit(); // Termina la ejecución del script
        }
    }
// Validar y sanitizar los datos
    $nombre = validarCampo($data->nombre, 'nombre');
    $apellido1 = validarCampo($data->apellido1, 'apellido1');
    $apellido2 = validarCampo($data->apellido2, 'apellido2');
    $email = validarCampo($data->email, 'email');
    $direccion = validarCampo($data->direccion, 'direccion');

// Puedes añadir validaciones adicionales para campos específicos, por ejemplo, validar el formato del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "status" => 400,
            "mensaje" => "El email no es válido"
        ]);
        exit(); // Termina la ejecución del script
    }
    $cliente= new Cliente();
    $cliente->setNombre($nombre);
    $cliente->setApellido1($apellido1);
    $cliente->setApellido2($apellido2);
    $cliente->setEmail($email);
    $cliente->setDireccion($direccion);
    $cliente->RegistrarCliente();
}