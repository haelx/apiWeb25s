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
if($method=="POST") {
    if(isset($data)) {
        if(isset($data->nombre) && isset($data->edad)) {
            $nombre = $data->nombre;
            $edad = $data->edad;
            if ($edad > 18) {
                echo json_encode(array(
                    "mensaje" => "Bienvenido $nombre eres mayor de edad"
                ));
            } else {
                echo json_encode(array(
                    "mensaje" => "$nombre no eres mayor de edad"
                ));
            }
        }else{
            echo json_encode(array("mensaje"=>"No se envio el nombre y la edad"));
        }
    }else{
        echo json_encode(array("mensaje" => "No se envio los datos"));
    }
}